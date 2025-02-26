<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Exports\TransaksiExporter;
use App\Filament\Resources\TransaksiResource;
use App\Filament\Resources\TransaksiResource\Widgets\TransaksiChart;
use App\Filament\Resources\TransaksiResource\Widgets\TransaksiPendapatanMingguan;
use App\Filament\Resources\TransaksiResource\Widgets\BusinessStats;
use App\Models\Transaksi;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Contracts\Database\Query\Builder;
use Filament\Pages\Actions\Action;
use Filament\Actions\ExportAction;

class ListTransaksis extends ListRecords
{

    protected static ?string $breadcrumb = "List Transaksi";
    protected static string $resource = TransaksiResource::class;

    protected function getActions(): array
    {
        return [

            ExportAction::make()
                ->label('Export Data Transaksi')
                ->exporter(TransaksiExporter::class),
            Action::make('create')
                ->label('Tambah Transaksi Baru')
                ->icon('heroicon-o-plus')
                ->url(static::getResource()::getUrl('create'))
                ->color('primary'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()
                ->label('Semua')
                ->badge(fn() => Transaksi::count() ?: null) // Menampilkan jumlah semua transaksi, sembunyikan jika 0
                ->modifyQueryUsing(fn(Builder $query) => $query), // Tidak ada filter khusus untuk tab "All"

            'Diterima' => Tab::make()
                ->label('Diterima')
                ->badge(fn() => Transaksi::where('status', 'diterima')->count() ?: null) // Sembunyikan badge jika 0
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'diterima')), // Filter status diterima

            'Diproses' => Tab::make()
                ->label('Diproses')
                ->badge(fn() => Transaksi::where('status', 'diproses')->count() ?: null) // Sembunyikan badge jika 0
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'diproses')), // Filter status diproses

            'Selesai' => Tab::make()
                ->label('Selesai')
                ->badge(fn() => Transaksi::where('status', 'selesai')->count() ?: null) // Sembunyikan badge jika 0
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'selesai')), // Filter status selesai

            'Diambil' => Tab::make()
                ->label('Diambil')
            ->badge(fn() => Transaksi::where('status', 'diambil')->count() ?: null) // Sembunyikan badge jika 0
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'diambil')), // Filter status diambil
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BusinessStats::class,
            TransaksiChart::class,
            TransaksiPendapatanMingguan::class,
        ];
    }
}
