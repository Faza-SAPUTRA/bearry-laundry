<?php

namespace App\Filament\Resources\DetailTransaksiResource\Widgets;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MostActivePetugasStats extends BaseWidget
{
    protected function getStats(): array
    {
        // Query untuk mendapatkan petugas paling aktif
        $activePetugas = DetailTransaksi::query()
            ->join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id_transaksi')
            ->join('petugas', 'transaksi.user_id', '=', 'petugas.user_id')
            ->selectRaw('petugas.nama_petugas, COUNT(detail_transaksi.id_detail_transaksi) as total_transaksi')
            ->groupBy('petugas.nama_petugas')
            ->orderByDesc('total_transaksi')
            ->first();

        return [
            Stat::make('Petugas Paling Aktif',
                $activePetugas ? $activePetugas->nama_petugas : '-'
            )
            ->description($activePetugas ? $activePetugas->total_transaksi . ' transaksi' : 'Belum ada data')
            ->icon('heroicon-o-user-circle')
            ->color('success'),
        ];
    }
}
