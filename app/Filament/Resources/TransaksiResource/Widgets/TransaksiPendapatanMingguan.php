<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class TransaksiPendapatanMingguan extends ChartWidget
{
    protected static ?string $heading = 'Persentase Pendapatan Harian';

    protected function getData(): array
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        // Ambil total pendapatan per hari
        $pendapatanPerHari = Transaksi::selectRaw('DATE(created_at) as date, SUM(total_harga_setelah_diskon) as total')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('total', 'date')
            ->toArray();

        // Ambil total pendapatan selama seminggu
        $totalPendapatanMinggu = array_sum($pendapatanPerHari);

        // Generate semua tanggal dalam minggu ini dengan nilai default 0
        $dates = [];
        $currentDate = $startOfWeek->copy();
        while ($currentDate <= $endOfWeek) {
            $dates[$currentDate->format('Y-m-d')] = 0;
            $currentDate->addDay();
        }

        // Gabungkan dengan data aktual
        foreach ($pendapatanPerHari as $date => $total) {
            $dates[$date] = $total;
        }

        // Hitung persentase pendapatan harian
        $labels = [];
        $data = [];
        foreach ($dates as $dateStr => $total) {
            $date = Carbon::createFromFormat('Y-m-d', $dateStr);
            $labels[] = $date->translatedFormat('d M');
            $data[] = $totalPendapatanMinggu > 0 ? number_format(($total / $totalPendapatanMinggu) * 100, 1) : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Persentase Pendapatan Harian',
                    'data' => $data,
                    'borderColor' => '#4CAF50',
                    'fill' => false,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#2E7D32',
                    'pointBorderColor' => '#4CAF50',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'color' => '#4CAF50',
                    ],
                ],
                'tooltip' => [
                    'backgroundColor' => '#4CAF50',
                    'bodyColor' => '#FFFFFF',
                    'titleColor' => '#C8E6C9',
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'color' => '#C8E6C9',
                    ],
                    'ticks' => [
                        'color' => '#4CAF50',
                    ],
                ],
                'y' => [
                    'grid' => [
                        'color' => '#C8E6C9',
                    ],
                    'ticks' => [
                        'stepSize' => 10,
                        'color' => '#4CAF50',
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
            ],
        ];
    }
}
