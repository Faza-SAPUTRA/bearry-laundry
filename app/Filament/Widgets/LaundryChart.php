<?php

namespace App\Filament\Widgets;

use App\Models\DetailTransaksi;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class LaundryChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Laundry';
    protected static bool $isHidden = true;

    protected function getData(): array
    {
        // Rentang waktu untuk 7 hari terakhir
        $last7Days = Carbon::now()->subDays(7)->startOfDay();
        $now = Carbon::now()->endOfDay();

        // Rentang waktu untuk 1 minggu kemarin
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek()->startOfDay();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek()->endOfDay();

        // Rentang waktu untuk minggu ini
        $thisWeekStart = Carbon::now()->startOfWeek()->startOfDay();
        $thisWeekEnd = Carbon::now()->endOfDay();

        // Query untuk 7 hari terakhir
        $incomeLast7Days = $this->getIncomeByDateRange($last7Days, $now);

        // Query untuk 1 minggu kemarin
        $incomeLastWeek = $this->getIncomeByDateRange($lastWeekStart, $lastWeekEnd);

        // Query untuk minggu ini
        $incomeThisWeek = $this->getIncomeByDateRange($thisWeekStart, $thisWeekEnd);

        // Gabungkan data untuk chart
        $datasets = [
            [
                'label' => '7 Hari Terakhir',
                'data' => $incomeLast7Days->pluck('total_income')->toArray(),
                'backgroundColor' => '#36A2EB', // Warna untuk 7 hari terakhir
                'borderColor' => '#36A2EB',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Minggu Ini',
                'data' => $incomeThisWeek->pluck('total_income')->toArray(),
                'backgroundColor' => '#2EB432', // Warna untuk minggu ini
                'borderColor' => '#2EB432',
                'borderWidth' => 1,
            ],
        ];

        $labels = $incomeLast7Days->pluck('category')->toArray();

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    /**
     * Helper function to get income by date range.
     */
    private function getIncomeByDateRange($startDate, $endDate)
    {
        return DetailTransaksi::join('jenis_cucian', 'detail_transaksi.id_jenis_cucian', '=', 'jenis_cucian.id_jenis_cucian')
            ->selectRaw('jenis_cucian.nama_jenis_cucian as category, SUM(detail_transaksi.sub_total) as total_income')
            ->whereBetween('detail_transaksi.created_at', [$startDate, $endDate])
            ->groupBy('category')
            ->orderBy('total_income', 'desc')
            ->get();
    }
}