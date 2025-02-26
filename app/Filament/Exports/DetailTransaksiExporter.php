<?php

namespace App\Filament\Exports;

use App\Models\DetailTransaksi;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class DetailTransaksiExporter extends Exporter
{
    protected static ?string $model = DetailTransaksi::class;
    protected static ?string $pluralLabel = 'Detail Transaksi'; // Override nama plural
    protected static ?string $label = 'Detail Transaksi'; // Override nama singular
    protected static ?string $title = 'Export';

    public function getFileName(Export $export): string
    {
        return "Laporan Detail Transaksi-{$export->getKey()}";
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('transaksi.user.name')
                ->label('Nama Petugas'),
            ExportColumn::make('id_transaksi')
                ->label('ID Transaksi'),
            ExportColumn::make('id_detail_transaksi')
                ->label('ID Detail Transaksi'),
            ExportColumn::make('created_at')
                ->label('Tanggal Dibuat')
                ->formatStateUsing(fn($state) => $state->format('d F Y H:i')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Laporan Detail Transaksi berhasil di export dan sebanyak ' . number_format($export->successful_rows) . ' ' . str('kolom')->plural($export->successful_rows) . ' di export.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('kolom')->plural($failedRowsCount) . ' Gagal export.';
        }

        return $body;
    }

    public static function getStartedNotificationBody(Export $export): string
    {
        return 'Proses ekspor telah dimulai dan sebanyak ' . number_format($export->total_rows) . ' baris akan diproses di latar belakang. Anda akan menerima notifikasi dengan tautan unduhan setelah selesai.';
    }

    public static function getTitle(): string
    {
        return 'Export'; // Change modal title here
    }

    public static function getModalHeading(): string
    {
        return 'Export';
    }
}