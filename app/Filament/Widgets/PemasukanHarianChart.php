<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class PemasukanHarianChart extends ChartWidget
{
    protected static ?string $heading = 'Total Pemasukan Harian (7 Hari Terakhir)';
    protected static bool $isHidden = true;

    protected function getData(): array
    {
        // Ambil data pemasukan per hari selama 7 hari terakhir
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $incomes = Transaksi::selectRaw('DATE(created_at) as date, SUM(total_harga) as income')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('income', 'date')
            ->toArray();

        // Siapkan data tanggal 7 hari terakhir dengan nilai default 0
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dates[$currentDate->format('Y-m-d')] = 0;
            $currentDate->addDay();
        }

        // Gabungkan dengan data aktual pemasukan
        foreach ($incomes as $date => $income) {
            $dates[$date] = $income;
        }

        // Format label dan data untuk chart
        $labels = [];
        $data = [];
        foreach ($dates as $dateStr => $income) {
            $date = Carbon::createFromFormat('Y-m-d', $dateStr);
            $labels[] = $date->translatedFormat('d M'); // Format tanggal (misal: 20 Feb)
            $data[] = $income;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan (IDR)',
                    'data' => $data,
                    'backgroundColor' => '#4CAF50', // Warna hijau
                    'borderColor' => '#388E3C', // Warna hijau tua
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'color' => '#4CAF50', // Warna hijau untuk legenda
                    ],
                ],
                'tooltip' => [
                    'backgroundColor' => '#4CAF50', // Warna hijau untuk tooltip
                    'bodyColor' => '#FFFFFF', // Warna teks tooltip
                    'titleColor' => '#E8F5E9', // Warna judul tooltip
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'color' => '#C8E6C9', // Warna hijau muda untuk grid
                    ],
                    'ticks' => [
                        'color' => '#2E7D32', // Warna hijau tua untuk label sumbu X
                    ],
                ],
                'y' => [
                    'grid' => [
                        'color' => '#C8E6C9', // Warna hijau muda untuk grid
                    ],
                    'ticks' => [
                        'color' => '#2E7D32', // Warna hijau tua untuk label sumbu Y
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
