<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    // protected static bool $isLazy = false;
    protected function getStats(): array
    {
        // Ambil data pemasukan harian 7 hari terakhir
        $weeklyData = DB::table('transaksi')
            ->selectRaw('DATE(created_at) as date, SUM(total_harga) as income')
            ->whereBetween('created_at', [now()->subDays(6), now()]) // Ambil 7 hari terakhir
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        // Data pemasukan harian selama seminggu terakhir
        $weeklyData = DB::table('transaksi')
            ->selectRaw('DATE(created_at) as date, SUM(total_harga) as income')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Total transaksi harian selama seminggu terakhir
        $weeklyTransactionData = DB::table('transaksi')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as transactions')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $transactionChartData = $weeklyTransactionData->pluck('transactions')->toArray();

        // Jika $transactionChartData kosong, isi dengan nilai default
        if (empty($transactionChartData)) {
            $transactionChartData = array_fill(0, 7, 0); // Grafik dengan 7 titik bernilai 0
        }

        // Total pemasukan bulan ini
        $currentMonthIncome = DB::table('transaksi')
            ->whereMonth('created_at', now()->month)
            ->sum('total_harga');

        // Total pemasukan minggu ini
        $currentWeekIncome = DB::table('transaksi')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total_harga');

        // Total pemasukan minggu lalu
        $lastWeekIncome = DB::table('transaksi')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->sum('total_harga');

        // Persentase peningkatan pemasukan
        $percentageIncrease = $lastWeekIncome > 0
            ? (($currentWeekIncome - $lastWeekIncome) / $lastWeekIncome) * 100
            : null;

        $incomeDescription = $percentageIncrease !== null
            ? ($percentageIncrease > 0
                ? 'Peningkatan ' . number_format($percentageIncrease, 2) . '% minggu ini'
                : 'Tidak ada peningkatan minggu ini')
            : 'Belum ada data minggu lalu untuk membandingkan';

        // Total transaksi bulan ini
        $currentMonthTransactions = DB::table('transaksi')
            ->whereMonth('created_at', now()->month)
            ->count();

        // Total transaksi mingguan untuk chart
        $weeklyTransactionData = DB::table('transaksi')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as transactions')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $transactionChartData = $weeklyTransactionData->pluck('transactions')->toArray();

        // Total transaksi minggu ini
        $currentWeekTransactions = DB::table('transaksi')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Total transaksi minggu lalu
        $lastWeekTransactions = DB::table('transaksi')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();

        // Persentase peningkatan transaksi
        $percentageIncreaseTransactions = $lastWeekTransactions > 0
            ? (($currentWeekTransactions - $lastWeekTransactions) / $lastWeekTransactions) * 100
            : null;

        $transactionDescription = $percentageIncreaseTransactions !== null
            ? ($percentageIncreaseTransactions > 0
                ? 'Peningkatan ' . number_format($percentageIncreaseTransactions, 2) . '% minggu ini'
                : 'Tidak ada peningkatan minggu ini')
            : 'Belum ada data minggu lalu untuk membandingkan';

        // Kondisi untuk menentukan chart pemasukan
        $incomeChart = $lastWeekIncome > 0
            ? ($currentWeekIncome < $lastWeekIncome
                ? [5, 12, 7, 15, 10, 17, 8] // Turun
                : [3, 5, 4, 8, 7, 12, 10, 15, 14, 18]) // Naik
            : array_fill(0, 7, 0); // Jika tidak ada data minggu lalu, grafik datar

        // Kondisi untuk menentukan chart transaksi
        $transactionChart = $lastWeekTransactions > 0
            ? ($currentWeekTransactions < $lastWeekTransactions
                ? [5, 12, 7, 15, 10, 17, 8] // Turun
                : [3, 5, 4, 8, 7, 12, 10, 15, 14, 18]) // Naik
            : array_fill(0, 7, 0); // Jika tidak ada data minggu lalu, grafik datar
        // Buat array default dengan 7 hari terakhir
        $dates = collect(range(6, 0))->map(fn($day) => now()->subDays($day)->toDateString());
        $incomeData = $dates->map(fn($date) => $weeklyData->firstWhere('date', $date)->income ?? 0)->toArray();

        return [
            // Stat untuk Total Pemasukan Bulan Ini dengan chart
            Stat::make('Total Pemasukan Bulan Ini', 'Rp ' . number_format($currentMonthIncome, 0, ',', '.') . ' IDR')
                ->description($incomeDescription)
                ->icon('heroicon-o-banknotes')
                ->descriptionIcon($percentageIncrease > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-exclamation-circle')
                ->color($lastWeekIncome > 0 ? ($currentWeekIncome >= $lastWeekIncome ? 'success' : 'danger') : 'warning')  // Added condition for no previous week data
                ->chart($incomeChart),

            // Stat untuk Total Transaksi Bulan Ini dengan chart
            Stat::make('Total Transaksi Bulan Ini', number_format($currentMonthTransactions, 0, ',', '.'))
                ->description($transactionDescription)
                ->icon('heroicon-o-circle-stack')
                ->descriptionIcon($percentageIncreaseTransactions > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-exclamation-circle')
                ->color($lastWeekTransactions > 0 ? ($currentWeekTransactions >= $lastWeekTransactions ? 'success' : 'danger') : 'warning')
                ->chart($transactionChart),
            // Stat dengan chart batang pemasukan harian
            Stat::make('Pemasukan Harian (7 Hari Terakhir)', 'Rp ' . number_format(array_sum($incomeData), 0, ',', '.'))
                ->description('Total pemasukan dalam seminggu terakhir')
                ->chart($incomeData)
                ->color('primary')
                ->icon('heroicon-o-chart-bar'),
        ];
    }
}
