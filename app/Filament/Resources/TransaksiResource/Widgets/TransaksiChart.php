<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class TransaksiChart extends ChartWidget
{
    protected static ?string $heading = 'Total Transaksi Minggu Ini';

    protected function getData(): array
    {
        // Ambil awal dan akhir minggu
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        // Query data transaksi per hari
        $transactions = Transaksi::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date')
            ->toArray();

        // Generate semua tanggal dalam minggu ini
        $dates = [];
        $currentDate = $startOfWeek->copy();
        while ($currentDate <= $endOfWeek) {
            $dates[$currentDate->format('Y-m-d')] = 0;
            $currentDate->addDay();
        }

        // Gabungkan dengan data aktual
        foreach ($transactions as $date => $count) {
            $dates[$date] = $count;
        }

        // Format label dan data
        $labels = [];
        $data = [];
        foreach ($dates as $dateStr => $count) {
            $date = Carbon::createFromFormat('Y-m-d', $dateStr);
            $labels[] = $date->translatedFormat('d M'); // Format tanggal dengan nama hari
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Transaksi',
                    'data' => $data,
                    'borderColor' => '#BFA58A', // Warna primary
                    // 'backgroundColor' => '#F2E1C9', // Warna primary-light
                    'fill' => false,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#D9C2A6', // Warna secondary
                    'pointBorderColor' => '#BFA58A', // Warna primary
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
                        'color' => '#BFA58A', // Warna primary untuk legenda
                    ],
                ],
                'tooltip' => [
                    'backgroundColor' => '#BFA58A', // Warna primary untuk tooltip
                    'bodyColor' => '#FFFFFF', // Warna teks tooltip
                    'titleColor' => '#F2E1C9', // Warna judul tooltip
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'color' => '#D9C2A6', // Warna secondary untuk grid
                    ],
                    'ticks' => [
                        'color' => '#BFA58A', // Warna primary untuk ticks
                    ],
                ],
                'y' => [
                    'grid' => [
                        'color' => '#D9C2A6', // Warna secondary untuk grid
                    ],
                    'ticks' => [
                        'stepSize' => 1,
                        'color' => '#BFA58A', // Warna primary untuk ticks
                    ],
                ],
            ],
        ];
    }
}