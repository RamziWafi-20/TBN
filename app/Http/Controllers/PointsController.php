<?php

namespace App\Http\Controllers;

use App\Models\PointTransaction;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherRedemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $vouchers = Voucher::where('is_active', true)
            ->where('stock', '>', 0)
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->orderBy('points_cost')->get();
        $history = $user->pointTransactions()->latest()->limit(12)->get();
        $redemptions = $user->voucherRedemptions()->with('voucher')->latest()->limit(10)->get();
        return view('app.points', compact('user', 'vouchers', 'history', 'redemptions'));
    }

    public function redeem(Request $request, Voucher $voucher)
    {
        $user = $request->user();
        if (!$voucher->is_active || $voucher->stock < 1 || ($voucher->expires_at && $voucher->expires_at->isPast())) {
            return back()->withErrors(['voucher' => 'Voucher tidak tersedia atau sudah kedaluwarsa.']);
        }

        try {
            $redemption = DB::transaction(function () use ($user, $voucher) {
                $lockedUser = User::whereKey($user->id)->lockForUpdate()->first();
                $lockedVoucher = Voucher::whereKey($voucher->id)->lockForUpdate()->first();
                if (!$lockedVoucher || !$lockedVoucher->is_active || $lockedVoucher->stock < 1 || ($lockedVoucher->expires_at && $lockedVoucher->expires_at->isPast())) {
                    throw new \RuntimeException('Voucher tidak tersedia.');
                }
                if ($lockedUser->points < $lockedVoucher->points_cost) {
                    throw new \RuntimeException('Poin kamu belum cukup.');
                }
                $lockedUser->points -= $lockedVoucher->points_cost;
                $lockedUser->save();
                $lockedVoucher->decrement('stock');

                PointTransaction::create([
                    'user_id' => $lockedUser->id,
                    'points' => -$lockedVoucher->points_cost,
                    'type' => 'redeem',
                    'reference_type' => Voucher::class,
                    'reference_id' => $lockedVoucher->id,
                    'description' => 'Tukar ' . $lockedVoucher->name,
                    'balance_after' => $lockedUser->points,
                ]);

                return VoucherRedemption::create([
                    'user_id' => $lockedUser->id,
                    'voucher_id' => $lockedVoucher->id,
                    'voucher_code' => $lockedVoucher->code,
                    'points_spent' => $lockedVoucher->points_cost,
                    'status' => 'Berhasil',
                    'redeemed_at' => now(),
                ]);
            });
            return back()->with('success', 'Voucher berhasil ditukar. Kode: ' . $redemption->voucher_code);
        } catch (\Throwable $e) {
            return back()->withErrors(['voucher' => $e->getMessage()]);
        }
    }

    public function redeemApi(Request $request, Voucher $voucher)
    {
        $before = $request->user()->points;
        $response = $this->redeem($request, $voucher);
        if ($response->getSession()->has('errors')) {
            return response()->json(['success' => false, 'message' => $response->getSession()->get('errors')->first()], 422);
        }
        return response()->json(['success' => true, 'message' => 'Voucher berhasil ditukar.', 'points_before' => $before, 'points_after' => (int) $request->user()->fresh()->points]);
    }

    public function api(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'data' => [
                'points' => (int) $user->points,
                'earning_per_photo' => 10,
                'vouchers' => Voucher::where('is_active', true)->where('stock', '>', 0)->orderBy('points_cost')->get(),
                'history' => $user->pointTransactions()->latest()->limit(20)->get(),
            ],
        ]);
    }
}
