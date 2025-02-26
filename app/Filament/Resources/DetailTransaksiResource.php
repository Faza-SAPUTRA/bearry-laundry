<?php

namespace App\Filament\Resources;

use App\Filament\Exports\DetailTransaksiExporter;
use App\Filament\Resources\DetailTransaksiResource\Pages;
use Filament\Tables\Filters\RangeFilter;
use App\Models\DetailTransaksi;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetailTransaksiResource extends Resource
{
    protected static ?string $model = DetailTransaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shopping-bag';
    protected static ?string $pluralLabel = 'Detail Transaksi';
    protected static ?string $label = 'Detail Transaksi';
    protected static ?string $navigationLabel = 'Detail Transaksi';
    protected static ?string $slug = 'kasir/detail-transaksi';
    protected static ?string $navigationGroup = 'Manajemen Keuangan';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_transaksi')
                    ->relationship('transaksi', 'id_transaksi')
                    ->label('ID Transaksi')
                    ->required()
                    ->native(false),

                Select::make('id_jenis_cucian')
                    ->relationship('jenisCucian', 'nama_jenis_cucian')
                    ->label('Jenis Cucian')
                    ->required()
                    ->native(false),

                TextInput::make('berat')
                    ->label('Berat (kg)')
                    ->numeric()
                    ->required()
                    ->minValue(0.1)
                    ->step(0.1),

                TextInput::make('sub_total')
                    ->label('Sub Total')
                    ->numeric()
                    ->required()
                    ->prefix('Rp')
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_detail_transaksi')
                    ->label('ID Detail Transaksi')
                    ->sortable()
                    ->iconColor('primary-light')
                    ->searchable()
                    ->toggleable()
                    ->icon('heroicon-o-hashtag'),

                TextColumn::make('transaksi.id_transaksi')
                    ->label('ID Transaksi')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->iconColor('primary-light')
                    ->icon('heroicon-o-document-text'),

                TextColumn::make('jenisCucian.nama_jenis_cucian')
                    ->label('Jenis Cucian')
                    ->sortable()
                    ->toggleable()
                    ->searchable()
                    ->iconColor('warning')
                    ->icon('heroicon-o-tag'),

                TextColumn::make('berat')
                    ->label('Berat (kg)')
                    ->sortable()
                    ->toggleable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => number_format($state, 1) . ' kg')
                    ->icon('heroicon-o-scale'),

                TextColumn::make('sub_total')
                    ->label('Sub Total')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->iconColor('success')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->icon('heroicon-o-currency-dollar'),

                // Kolom untuk tanggal dari created_at
                TextColumn::make('created_at_date')
                    ->icon('heroicon-o-calendar')
                    ->toggleable()
                    ->label('Tanggal Dibuat') // Label untuk kolom tanggal
                    ->getStateUsing(fn($record) => $record->created_at?->format('d F Y')),

                // Kolom untuk waktu dari created_at
                TextColumn::make('created_at_time')
                    ->label('Waktu Dibuat') // Label untuk kolom waktu
                    ->getStateUsing(fn($record) => $record->created_at?->format('H:i')) // Format hanya waktu
                    ->description(fn($record) => Carbon::parse($record->created_at)->locale('id')->diffForHumans()) // Deskripsi dalam bahasa Indonesia
                    ->toggleable(),
            ])
            ->defaultSort('id_detail_transaksi', 'desc')
            ->filters([
                // Filter berdasarkan Tanggal Dibuat
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

                // Filter berdasarkan Jenis Cucian
                SelectFilter::make('id_jenis_cucian')
                    ->label('Jenis Cucian')
                    ->relationship('jenisCucian', 'nama_jenis_cucian')
                    ->searchable()
                    ->preload(),

                // Filter berdasarkan Berat
                Filter::make('berat')
                    ->form([
                        TextInput::make('min_berat')
                            ->label('Berat Minimal (kg)')
                            ->numeric()
                            ->minValue(0.1)
                            ->step(0.1),
                        TextInput::make('max_berat')
                            ->label('Berat Maksimal (kg)')
                            ->numeric()
                            ->minValue(0.1)
                            ->step(0.1),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_berat'],
                                fn(Builder $query, $minBerat): Builder => $query->where('berat', '>=', $minBerat),
                            )
                            ->when(
                                $data['max_berat'],
                                fn(Builder $query, $maxBerat): Builder => $query->where('berat', '<=', $maxBerat),
                            );
                    }),
                // Filter berdasarkan Jenis Cucian
                SelectFilter::make('id_jenis_cucian')
                    ->label('Jenis Cucian')
                    ->relationship('jenisCucian', 'nama_jenis_cucian')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make('view_data')
                        ->label('Lihat Data') // Label for button
                        ->icon('heroicon-o-eye'), // Eye icon)
                    // Tables\Actions\Action::make('hapus')
                    //     ->label('Hapus')
                    //     ->color('danger')
                    //     ->icon('heroicon-s-trash')
                    //     ->requiresConfirmation()
                    //     ->modalHeading('Konfirmasi Hapus')
                    //     ->modalSubheading(fn(DetailTransaksi $record) => "Apakah kamu yakin ingin menghapus detail transaksi {$record->id_detail_transaksi}?")
                    //     ->modalSubmitActionLabel('Hapus')
                    //     ->modalCancelActionLabel('Batal')
                    //     ->action(function ($record) {
                    //         $recipient = auth()->user();
                    //         Notification::make()
                    //             ->title("Detail Transaksi berhasil dihapus.")
                    //             ->success()
                    //             ->sendToDatabase($recipient);
                    //         $record->delete();
                    //     })
                ])
                    ->label('Aksi')
                    ->icon('heroicon-o-ellipsis-vertical')
            ])
            ->bulkActions(array_filter([
                auth()->user()->hasRole('super_admin') ? ExportBulkAction::make()
                    ->label('Export Data Laporan Pekerjaan')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-on-square-stack')
                    ->exporter(DetailTransaksiExporter::class) : null,
                // Tables\Actions\DeleteBulkAction::make()
                //     ->label('Hapus Data')
                //     ->icon('heroicon-o-trash')
                //     ->color('danger')
                //     ->requiresConfirmation()
                //     ->modalDescription('Apakah kamu yakin ingin menghapus semua data detail transaksi terpilih?')
                //     ->modalSubmitActionLabel('Hapus')
                //     ->modalCancelActionLabel('Batal'),
            ]))
            ->recordUrl(
                null
            );
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDetailTransaksis::route('/'),
            'create' => Pages\CreateDetailTransaksi::route('/create'),
            'edit' => Pages\EditDetailTransaksi::route('/{record}/edit'),
        ];
    }
}
