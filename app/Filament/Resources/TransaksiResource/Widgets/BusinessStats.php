<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;

class BusinessStats extends BaseWidget
{
    protected function getStats(): array
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        // =====================
        // Statistik Pelanggan
        // =====================
        $currentWeekCustomers = DB::table('transaksi')
            ->selectRaw('COUNT(DISTINCT id_customer) as total_customers')
            ->whereBetween('created_at', values: [$startOfWeek, $endOfWeek])
            ->value('total_customers') ?? 0;

        $lastWeekCustomers = DB::table('transaksi')
            ->selectRaw('COUNT(DISTINCT id_customer) as total_customers')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->value('total_customers') ?? 0;

        $percentageIncreaseCustomers = $lastWeekCustomers > 0
            ? (($currentWeekCustomers - $lastWeekCustomers) / $lastWeekCustomers) * 100
            : 0;

        $customerDescription = $percentageIncreaseCustomers > 0
            ? 'Peningkatan ' . number_format($percentageIncreaseCustomers, 2) . '% minggu ini'
            : 'Tidak ada peningkatan minggu ini';

        $customerColor = $percentageIncreaseCustomers > 0 ? 'success' : 'warning';
        $customerChart = $percentageIncreaseCustomers > 0 ? [5, 8, 6, 10, 7, 12, 9] : array_fill(0, 7, 7);

        // =====================
        // Statistik Pendapatan Mingguan
        // =====================
        $lastWeekPendapatan = DB::table('transaksi')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->sum('total_harga_setelah_diskon');

        $currentWeekPendapatan = DB::table('transaksi')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('total_harga_setelah_diskon');

        $percentageIncreasePendapatan = $lastWeekPendapatan > 0
            ? (($currentWeekPendapatan - $lastWeekPendapatan) / $lastWeekPendapatan) * 100
            : 0;

        $pendapatanDescription = $percentageIncreasePendapatan != 0
            ? 'Pendapatan Harian ' . ($percentageIncreasePendapatan > 0 ? 'meningkat' : 'menurun') . ' sebanyak ' . number_format(abs($percentageIncreasePendapatan), 2) . '%'
            : 'Tidak ada peningkatan untuk hari ini';

        $pendapatanColor = $percentageIncreasePendapatan > 0 ? 'success' : ($percentageIncreasePendapatan == 0 ? 'warning' : 'danger');
        $pendapatanChart = $percentageIncreasePendapatan != 0 ? [10, 15, 12, 18, 14, 20, 16] : array_fill(0, 7, 12);

        // =====================
        // Statistik Petugas Terbanyak Transaksi
        // =====================
        $topPetugas = DB::table('transaksi')
            ->join('users', 'transaksi.user_id', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.name', DB::raw('COUNT(transaksi.id_transaksi) as total_transaksi'))
            ->where('roles.name', 'petugas')
            ->whereBetween('transaksi.created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_transaksi')
            ->first();

        return [
            Stat::make('Total Customer Menyuci Minggu Ini', number_format($currentWeekCustomers, 0, ',', '.'))
                ->description($customerDescription)
                ->icon('heroicon-o-user-group')
                ->color($customerColor)
                ->chart($customerChart),

            auth()->user()->hasRole('super_admin') ? Stat::make('Pendapatan Minggu Ini', 'Rp ' . number_format($currentWeekPendapatan, 0, ',', '.'))
                ->description($pendapatanDescription)
                ->icon('heroicon-o-chart-bar')
                ->color($pendapatanColor)
                ->chart($pendapatanChart) : null,

            auth()->user()->hasRole('super_admin') ? Stat::make('Petugas Teraktif Minggu Ini', $topPetugas ? $topPetugas->name : 'Tidak ada data')
                ->description($topPetugas ? "{$topPetugas->total_transaksi} transaksi" : 'Belum ada transaksi minggu ini')
                ->icon('heroicon-o-user-group')
                ->color($topPetugas ? 'success' : 'warning')
                ->chart($topPetugas ? [3, 5, 4, 6, 5, 7, 6] : array_fill(0, 7, 4)) : null,
        ];
    }
}
