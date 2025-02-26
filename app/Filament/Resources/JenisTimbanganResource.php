<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisTimbanganResource\Pages;
use App\Models\JenisTimbangan;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JenisTimbanganResource extends Resource
{
    protected static ?string $model = JenisTimbangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $activeNavigationIcon = 'heroicon-s-scale';
    protected static ?string $pluralLabel = 'Jenis Satuan Kuantitas';
    protected static ?string $label = 'Jenis Satuan Kuantitas';
protected static ?string $navigationLabel = 'Jenis Satuan';
    protected static ?string $slug = 'cuci/jenis-satuan';
    protected static ?string $navigationGroup = 'Manajemen Pencucian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_jenis_timbangan')
                    ->label('Nama Jenis Satuan Kuantitas')
                    ->required()
                    ->unique()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_jenis_timbangan')
                    ->label('Nama Jenis Satuan Kuantitas')
                    ->icon('heroicon-o-scale') // Ikon untuk kolom
                    ->iconColor('primary') // Warna ikon
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at_date')
                    ->label('Tanggal Dibuat')
                    ->icon('heroicon-o-calendar')
                    ->getStateUsing(fn($record) => $record->created_at?->format('d F Y')) // Format tanggal
                    ->sortable(),

                TextColumn::make('created_at_time')
                    ->label('Waktu Dibuat')
                    ->icon('heroicon-o-clock')
                    ->getStateUsing(fn($record) => $record->created_at?->format('H:i')) // Format waktu
                    ->sortable(),
            ])
            ->defaultSort('id_jenis_timbangan', 'desc')
            ->actions([
                Tables\Actions\ActionGroup::make([
                    // View Action
                    Tables\Actions\ViewAction::make('view_data')
                        ->label('Lihat Data')
                        ->icon('heroicon-o-eye'),

                    // Edit Action (Modal)
                    Tables\Actions\Action::make('edit')
                        ->label('Edit')
                        ->color('warning')
                        ->icon('heroicon-o-pencil')
                        ->modalHeading(fn(JenisTimbangan $record) => "Edit Jenis Timbangan: {$record->nama_jenis_timbangan}")
                        ->modalDescription('Silakan ubah data jenis timbangan sesuai kebutuhan')
                        ->modalSubmitActionLabel('Simpan Perubahan')
                        ->modalCancelActionLabel('Batal')
                        ->modalWidth('md')
                        ->form([
                            TextInput::make('nama_jenis_timbangan')
                                ->label('Nama Jenis Timbangan')
                                ->required()
                                ->unique(JenisTimbangan::class, 'nama_jenis_timbangan', ignoreRecord: true) // ✅ Abaikan record saat ini
                                ->maxLength(255)
                                ->validationMessages([
                                    'required' => 'Nama Jenis Timbangan wajib diisi.',
                                    'unique' => 'Nama ini sudah digunakan oleh timbangan lain.',
                                ])
                                ->default(fn(JenisTimbangan $record) => $record->nama_jenis_timbangan), // Default value
                        ])
                        ->action(function (JenisTimbangan $record, array $data) {
                            $record->update($data);
                            Notification::make()
                                ->title('Jenis Timbangan berhasil diperbarui 🎉')
                                ->success()
                                ->sendToDatabase(auth()->user())
                                ->send();
                        }),

                    // Delete Action
                    Tables\Actions\Action::make('hapus')
                        ->label('Hapus')
                        ->color('danger')
                        ->icon('heroicon-s-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Hapus')
                        ->modalSubheading(fn(JenisTimbangan $record) => "Apakah kamu yakin ingin menghapus {$record->nama_jenis_timbangan}?")
                        ->modalSubmitActionLabel('Hapus')
                        ->modalCancelActionLabel('Batal')
                        ->action(function ($record) {
                            Notification::make()
                                ->title("Jenis Timbangan berhasil dihapus.")
                                ->success()
                                ->send();
                            $record->delete();
                        }),
                ]),
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
            'index' => Pages\ListJenisTimbangans::route('/'),
            'create' => Pages\CreateJenisTimbangan::route('/create'),
            'edit' => Pages\EditJenisTimbangan::route('/{record}/edit'),
        ];
    }
}
