<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WasteReport;
use App\Models\WasteTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    private function isManager(User $user): bool
    {
        return in_array($user->role, ['Pengelola', 'Guru'], true);
    }

    private function reportQuery(User $user)
    {
        return $this->isManager($user)
            ? WasteReport::query()
            : WasteReport::where('user_id', $user->id);
    }

    public function ranking()
    {
        $users = User::where('role', 'Siswa')->with('wasteReports')->get();

        $ranking = $users->map(function (User $user) {
            $reports = $user->wasteReports;
            return [
                'user' => $user,
                'class' => $user->class_name ?: 'Belum diatur',
                'weight' => (float) $reports->sum(fn ($r) => $r->effective_weight),
                'income' => (float) $reports->sum(fn ($r) => $r->effective_value),
                'transactions' => $reports->count(),
            ];
        })->sortByDesc('weight')->values();

        $classes = $ranking->groupBy('class')->map(function ($items, $class) {
            return [
                'class' => $class,
                'weight' => (float) $items->sum('weight'),
                'income' => (float) $items->sum('income'),
                'students' => $items->count(),
            ];
        })->sortByDesc('weight')->values();

        return view('app.ranking', compact('ranking', 'classes'));
    }

    public function income()
    {
        $user = Auth::user();
        $isManager = $this->isManager($user);
        $records = $this->reportQuery($user)->with(['user', 'category', 'transaction'])->latest()->get();

        $transactions = $records->pluck('transaction')->filter();
        $gross = (float) $transactions->sum('gross_value');
        $processing = (float) $transactions->sum('processing_cost');
        $selling = (float) $transactions->sum('selling_value');
        $netProfit = (float) $transactions->sum('net_profit');
        $weight = (float) $records->sum(fn ($r) => $r->effective_weight);
        $count = $records->count();
        $average = $count ? ($selling ?: $records->sum(fn ($r) => $r->effective_value)) / $count : 0;

        $monthly = $transactions->groupBy(fn ($t) => $t->transaction_date?->format('Y-m'))
            ->map(fn ($items) => [
                'selling' => (float) $items->sum('selling_value'),
                'profit' => (float) $items->sum('net_profit'),
            ])->sortKeys();

        return view('app.income', compact(
            'records', 'gross', 'processing', 'selling', 'netProfit',
            'weight', 'count', 'average', 'monthly', 'isManager'
        ));
    }

    public function dashboardData(User $user): array
    {
        $reports = $this->reportQuery($user)->with(['user', 'category', 'transaction'])->get();
        $transactions = $reports->pluck('transaction')->filter();

        $category = $reports->groupBy(fn ($r) => $r->category?->name ?: 'Lainnya')
            ->map(fn ($items) => (float) $items->sum(fn ($r) => $r->effective_weight))
            ->sortDesc();

        $monthly = $reports->groupBy(fn ($r) => $r->created_at?->format('Y-m'))
            ->map(fn ($items) => (float) $items->sum(fn ($r) => $r->effective_weight))
            ->sortKeys();

        $classes = $reports->filter(fn ($r) => $r->user?->role === 'Siswa')
            ->groupBy(fn ($r) => $r->user?->class_name ?: 'Belum diatur')
            ->map(fn ($items) => (float) $items->sum(fn ($r) => $r->effective_weight))
            ->sortDesc();

        return [
            'summary' => [
                'weight' => (float) $reports->sum(fn ($r) => $r->effective_weight),
                'value' => (float) $reports->sum(fn ($r) => $r->effective_value),
                'reports' => $reports->count(),
                'transactions' => $transactions->count(),
                'selling' => (float) $transactions->sum('selling_value'),
                'profit' => (float) $transactions->sum('net_profit'),
            ],
            'category' => ['labels' => $category->keys()->values(), 'values' => $category->values()],
            'monthly' => ['labels' => $monthly->keys()->values(), 'values' => $monthly->values()],
            'classes' => ['labels' => $classes->keys()->values(), 'values' => $classes->values()],
        ];
    }

    public function apiDashboard(Request $request): JsonResponse
    {
        $user = $request->user();
        $data = $this->dashboardData($user);
        if ($this->isManager($user)) {
            $data['summary']['users'] = User::count();
        }
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function apiRanking(): JsonResponse
    {
        $users = User::where('role', 'Siswa')->with('wasteReports')->get();
        $ranking = $users->map(fn (User $user) => [
            'name' => $user->name,
            'class' => $user->class_name ?: 'Belum diatur',
            'weight' => round((float) $user->wasteReports->sum(fn ($r) => $r->effective_weight), 2),
            'value' => round((float) $user->wasteReports->sum(fn ($r) => $r->effective_value), 2),
        ])->sortByDesc('weight')->values()->map(function ($row, $index) {
            $row['rank'] = $index + 1;
            return $row;
        })->values();

        return response()->json(['success' => true, 'data' => $ranking]);
    }

    public function apiIncome(Request $request): JsonResponse
    {
        $user = $request->user();
        $reports = $this->reportQuery($user)->with('transaction')->get();
        $transactions = $reports->pluck('transaction')->filter();
        return response()->json(['success' => true, 'data' => [
            'weight' => (float) $reports->sum(fn ($r) => $r->effective_weight),
            'selling' => (float) $transactions->sum('selling_value'),
            'net_profit' => (float) $transactions->sum('net_profit'),
            'processing_cost' => (float) $transactions->sum('processing_cost'),
            'transactions' => $transactions->count(),
        ]]);
    }
}
