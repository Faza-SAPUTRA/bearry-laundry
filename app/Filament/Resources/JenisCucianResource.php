<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisCucianResource\Pages;
use App\Models\JenisCucian;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class JenisCucianResource extends Resource
{
    protected static ?string $model = JenisCucian::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $activeNavigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $pluralLabel = 'Jenis Cucian';
    protected static ?string $label = 'Jenis Cucian';
    protected static ?string $navigationLabel = 'Jenis Cucian';
    protected static ?string $slug = 'cuci/jenis-cucian';
    protected static ?string $navigationGroup = 'Manajemen Pencucian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_jenis_cucian')
                    ->label('Nama Jenis Cucian')
                    ->placeholder('Contoh: Bedcover')
                    ->required()
                    ->maxLength(255),

                Select::make('id_jenis_timbangan')
                    ->label('Jenis Timbangan')
                    ->relationship('jenisTimbangan', 'nama_jenis_timbangan')
                    ->required()
                    ->placeholder('Pilih Jenis Timbangan')
                    ->searchable(),

                TextInput::make('harga_per_timbangan')
                    ->label('Harga per timbangan')
                    ->placeholder('Masukkan harga per timbangan (per kg)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->prefix('Rp')
                    ->columnStart(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_jenis_cucian')
                    ->label('Nama Jenis Cucian')
                    ->icon('heroicon-o-square-3-stack-3d')
                    ->iconColor('primary')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('harga_per_timbangan')
                    ->label('Harga')
                    ->icon('heroicon-o-banknotes')
                    ->iconColor('success')
                    ->money('IDR', true)
                    ->sortable()
                    ->tooltip('Harga per kg'),

                TextColumn::make('jenisTimbangan.nama_jenis_timbangan')
                    ->label('Timbangan')
                    ->icon('heroicon-o-scale')
                    ->iconColor('secondary')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at_date')
                    ->label('Tanggal Dibuat') // Label untuk kolom tanggal
                    ->icon('heroicon-o-calendar')
                    ->getStateUsing(fn($record) => $record->created_at?->format('d F Y')) // Format hanya tanggal
                    ->sortable(),

                // Kolom untuk waktu dari created_at
                TextColumn::make('created_at_time')
                    ->icon('heroicon-o-clock')
                    ->label('Waktu Dibuat') // Label untuk kolom waktu
                    ->getStateUsing(fn($record) => $record->created_at?->format('H:i')) // Format hanya waktu
                    ->sortable(),
            ])
            ->defaultSort('id_jenis_cucian', 'desc')
            ->filters([
                TrashedFilter::make(), // Filter data terhapus
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make('view_data')
                        ->label('Lihat Data')
                        ->icon('heroicon-o-eye'),

                    Tables\Actions\Action::make('edit')
                        ->label('Edit')
                        ->color('warning')
                        ->icon('heroicon-o-pencil')
                        ->modalHeading(fn(JenisCucian $record) => "Edit: {$record->nama_jenis_cucian}")
                        ->modalSubmitActionLabel('Simpan')
                        ->modalCancelActionLabel('Batal')
                        ->form([
                            TextInput::make('nama_jenis_cucian')
                                ->label('Nama Jenis Cucian')
                                ->default(fn(JenisCucian $record) => $record->nama_jenis_cucian)
                                ->required()
                                ->unique(ignoreRecord: true) // 🔥 Validasi unique dengan pengecualian record yang sedang diedit
                                ->validationMessages([
                                    'required' => 'Nama Jenis Cucian wajib diisi.',
                                    'unique' => 'Nama Jenis Cucian ini sudah ada.',
                                ]),

                            Select::make('id_jenis_timbangan')
                                ->label('Jenis Timbangan')
                                ->placeholder('Pilih jenis timbangan')
                                ->relationship('jenisTimbangan', 'nama_jenis_timbangan')
                                ->default(fn(JenisCucian $record) => $record->id_jenis_timbangan)
                                ->required()
                                ->validationMessages([
                                    'required' => 'Jenis Timbangan wajib dipilih.',
                                ]),

                            TextInput::make('harga_per_timbangan')
                                ->label('Harga per timbangan')
                                ->default(fn(JenisCucian $record) => $record->harga_per_timbangan)
                                ->required()
                                ->numeric()
                                ->prefix('Rp')
                                ->validationMessages([
                                    'required' => 'Harga wajib diisi.',
                                    'numeric' => 'Harga harus berupa angka.',
                                ]),
                            Tables\Actions\RestoreAction::make()
                                ->label('Pulihkan')
                                ->color('success')
                                ->icon('heroicon-o-arrow-path')
                                ->successNotificationTitle('Data berhasil dipulihkan'),

                            Tables\Actions\ForceDeleteAction::make()
                                ->label('Hapus Permanen')
                                ->color('danger')
                                ->icon('heroicon-o-trash')
                                ->successNotificationTitle('Data dihapus secara permanen'),
                        ])
                        ->action(function (JenisCucian $record, array $data) {
                            $record->update($data);
                            Notification::make()
                                ->title("Data Jenis Cucian {$record->nama_jenis_cucian} berhasil diperbarui 👍")
                                ->success()
                                ->sendToDatabase(auth()->user())
                                ->send();
                        }),

                    Tables\Actions\Action::make('hapus')
                        ->label('Hapus')
                        ->color('danger')
                        ->icon('heroicon-s-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Hapus')
                        ->modalSubheading(fn(JenisCucian $record) => "Apakah kamu yakin ingin menghapus {$record->nama_jenis_cucian}?")
                        ->modalSubmitActionLabel('Hapus')
                        ->modalCancelActionLabel('Batal')
                        ->action(function ($record) {
                            $recipient = auth()->user();
                            Notification::make()
                                ->title("Jenis Cucian berhasil dihapus.")
                                ->success()
                                ->sendToDatabase($recipient);
                            $record->delete();
                        })
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(
                null
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJenisCucians::route('/'),
            'create' => Pages\CreateJenisCucian::route('/create'),
            'edit' => Pages\EditJenisCucian::route('/{record}/edit'),
        ];
    }
}
