<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
{
    private function manager(Request $request): bool
    {
        return in_array($request->user()->role, ['Pengelola', 'Guru'], true);
    }

    public function index(Request $request)
    {
        abort_unless($this->manager($request), 403);
        $vouchers = Voucher::latest()->get();
        return view('app.vouchers', compact('vouchers'));
    }

    public function store(Request $request)
    {
        abort_unless($this->manager($request), 403);
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'type' => ['required', Rule::in(['wifi','koperasi'])],
            'code' => ['required','string','max:100','unique:vouchers,code'],
            'points_cost' => ['required','integer','min:1'],
            'stock' => ['required','integer','min:0'],
            'expires_at' => ['nullable','date'],
            'description' => ['nullable','string','max:1000'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        Voucher::create($data);
        return back()->with('success', 'Voucher berhasil ditambahkan.');
    }

    public function update(Request $request, Voucher $voucher)
    {
        abort_unless($this->manager($request), 403);
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'type' => ['required', Rule::in(['wifi','koperasi'])],
            'code' => ['required','string','max:100', Rule::unique('vouchers','code')->ignore($voucher->id)],
            'points_cost' => ['required','integer','min:1'],
            'stock' => ['required','integer','min:0'],
            'expires_at' => ['nullable','date'],
            'description' => ['nullable','string','max:1000'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $voucher->update($data);
        return back()->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy(Request $request, Voucher $voucher)
    {
        abort_unless($this->manager($request), 403);
        if ($voucher->redemptions()->exists()) {
            $voucher->update(['is_active' => false, 'stock' => 0]);
        } else {
            $voucher->delete();
        }
        return back()->with('success', 'Voucher berhasil dinonaktifkan/dihapus.');
    }

    public function api(Request $request)
    {
        abort_unless($this->manager($request), 403);
        return response()->json(['success' => true, 'data' => Voucher::latest()->get()]);
    }
}
