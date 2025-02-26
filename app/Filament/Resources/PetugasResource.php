<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PetugasResource\Pages;
use App\Filament\Resources\PetugasResource\RelationManagers;
use App\Models\Petugas;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class PetugasResource extends Resource
{
    protected static ?string $model = Petugas::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $activeNavigationIcon = 'heroicon-s-users';
    protected static ?string $pluralLabel = 'Petugas';
    protected static ?string $label = 'Petugas';
    protected static ?string $navigationLabel = 'Petugas';
    protected static ?string $slug = 'member/petugas';
    protected static ?string $navigationGroup = 'Manajemen Anggota';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_petugas')
                    ->label('Nama Petugas')
                    ->placeholder('Masukkan Nama Petugas')
                    ->rules(['required'])
                    ->unique(ignoreRecord: true),

                PhoneInput::make('no_telp')
                    ->label('Nomor Telepon')
                    ->required()
                    ->onlyCountries(['ID', 'SG', 'MY', 'TH'])
                    ->defaultCountry('ID')
                    ->countrySearch(true)
                    ->showFlags(true)
                    ->formatAsYouType(true)
                    ->rules(['regex:/^[0-9+]*$/']),

                Select::make('jk')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-Laki',
                        'P' => 'Perempuan',
                    ])
                    ->required()
                    ->placeholder('Pilih Jenis Kelamin')
                    ->native(false),

                Select::make('user_id')
                    ->label('Akun User')
                    ->relationship('user', 'name')
                    ->required()
                    ->placeholder('Pilih Akun User')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_petugas')
                    ->label('Nama Petugas')
                    ->sortable()
                    ->icon('heroicon-o-identification')
                    ->iconColor('primary-light')
                    ->searchable()
                    ->icon('heroicon-o-user-circle'),

                TextColumn::make('no_telp')
                    ->label('Nomor Telepon')
                    ->searchable()
                    ->icon('heroicon-o-phone')
                    ->iconColor('warning'),

                TextColumn::make('jk')
                    ->label('Jenis Kelamin')
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'L' => 'Laki-Laki',
                        'P' => 'Perempuan',
                        default => 'Tidak Diketahui'
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'L' => 'primary',
                        'P' => 'danger',
                        default => 'gray'
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'aktif' => 'success',
                        'nonaktif' => 'danger',
                        default => 'gray'
                    }),
                TextColumn::make('user.name')
                    ->label('Akun User')
                    ->sortable()
                    ->icon('heroicon-o-user'),
                TextColumn::make('deleted_at')
                    ->getStateUsing(fn($record) => $record->created_at?->format('H:i')) // Format hanya waktu
                    ->description(fn($record) => Carbon::parse($record->created_at)->locale('id')->diffForHumans()) // Deskripsi dalam bahasa Indonesia
                    ->label('Waktu')
                    ->sortable()
                    ->icon('heroicon-o-user'),
            ])
            ->defaultSort('id_petugas', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('jk')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Nonaktif',
                    ])
                    ->default('aktif'),
                Tables\Filters\TrashedFilter::make()
                    ->native(false)
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make('view_data')
                        ->label('Lihat Data')
                        ->icon('heroicon-o-eye'),

                    Tables\Actions\Action::make('edit')
                        ->color('warning')
                        ->label('Edit')
                        ->icon('heroicon-o-pencil')
                        ->modalHeading(fn(Petugas $record) => "Edit Petugas: {$record->nama_petugas}")
                        ->modalDescription('Silakan ubah data petugas sesuai kebutuhan')
                        ->modalSubmitActionLabel('Simpan Perubahan')
                        ->modalCancelActionLabel('Batal')
                        ->modalWidth('md')
                        ->form([
                            TextInput::make('nama_petugas')
                                ->required()
                                ->maxLength(255)
                                ->default(fn(Petugas $record) => $record->nama_petugas)
                                ->unique(table: 'petugas', column: 'nama_petugas', ignoreRecord: true) // Validasi unique saat edit
                                ->validationMessages([
                                    'required' => 'Nama Petugas wajib diisi.',
                                    'max' => 'Nama Petugas tidak boleh lebih dari 255 karakter.',
                                    'unique' => 'Nama Petugas ini sudah ada.',
                                ]),

                            PhoneInput::make('no_telp')
                                ->label("Nomor Telepon")
                                ->required()
                                ->onlyCountries(['ID', 'SG', 'MY', 'TH'])
                                ->defaultCountry('ID')
                                ->default(fn(Petugas $record) => $record->no_telp)
                                ->unique(table: 'petugas', column: 'no_telp', ignoreRecord: true) // Validasi unique saat edit
                                ->validationMessages([
                                    'required' => 'Nomor Telepon wajib diisi.',
                                    'unique' => 'Nomor Telepon ini sudah digunakan.',
                                ]),

                            Select::make('jk')
                                ->options([
                                    'L' => 'Laki-Laki',
                                    'P' => 'Perempuan',
                                ])
                                ->required()
                                ->default(fn(Petugas $record) => $record->jk)
                                ->validationMessages([
                                    'required' => 'Jenis Kelamin wajib dipilih.',
                                ]),
                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'aktif' => 'Aktif',
                                    'nonaktif' => 'Nonaktif',
                                ])
                                ->default(fn(Petugas $record) => $record->status)
                                ->required()
                                ->native(false),

                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->required()
                                ->default(fn(Petugas $record) => $record->user_id)
                                ->unique(table: 'petugas', column: 'user_id', ignoreRecord: true) // Validasi agar user_id tidak dipakai oleh petugas lain
                                ->validationMessages([
                                    'required' => 'Akun Petugas wajib dipilih.',
                                    'unique' => 'Akun ini sudah digunakan oleh petugas lain.',
                                ]),
                        ])
                        ->action(function (Petugas $record, array $data) {
                            $record->update($data);
                            $recipient = auth()->user();
                            Notification::make()
                                ->title("Data Petugas bernama {$record->nama_petugas} berhasil diperbarui 👍")
                                ->success()
                                ->sendToDatabase($recipient)
                                ->send();
                        }),
                    Tables\Actions\Action::make('nonaktifkan')
                        ->label('Nonaktifkan')
                        ->color('danger')
                        ->icon('heroicon-s-x-circle')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Nonaktifkan')
                        ->modalSubheading(fn(Petugas $record) => "Apakah kamu yakin ingin menonaktifkan {$record->nama_petugas}?")
                        ->modalSubmitActionLabel('Nonaktifkan')
                        ->modalCancelActionLabel('Batal')
                        ->action(function (Petugas $record) {
                            $record->update(['status' => 'nonaktif']);

                            Notification::make()
                                ->title("Petugas {$record->nama_petugas} telah dinonaktifkan.")
                                ->danger()
                                ->send();
                        }),

                    // Tables\Actions\Action::make('hapus')
                    //     ->label('Hapus')
                    //     ->color('danger')
                    //     ->icon('heroicon-s-trash')
                    //     ->requiresConfirmation()
                    //     ->modalHeading('Konfirmasi Hapus')
                    //     ->modalSubheading(fn(Petugas $record) => "Apakah kamu yakin ingin menghapus {$record->nama_petugas}?")
                    //     ->modalSubmitActionLabel('Hapus')
                    //     ->modalCancelActionLabel('Batal')
                    //     ->action(function ($record) {
                    //         $recipient = auth()->user();
                    //         Notification::make()
                    //             ->title("Petugas berhasil dihapus.")
                    //             ->success()
                    //             ->sendToDatabase($recipient);
                    //         $record->delete();
                    //     }),
                    Tables\Actions\RestoreAction::make()
                        ->label('Kembalikan Data Petugas'), // Tindakan untuk memulihkan data
                    // Tables\Actions\ForceDeleteAction::make()
                    // ->label('Hapus Permanen'), // Tindakan untuk menghapus permanen
                ])
                    ->label('Aksi')
                    ->icon('heroicon-o-ellipsis-vertical')
            ])

            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make()
                //     ->label('Hapus Data')
                //     ->icon('heroicon-o-trash')
                //     ->color('danger')
                //     ->requiresConfirmation()
                //     ->modalDescription('Apakah kamu yakin ingin menghapus semua data petugas terpilih?')
                //     ->modalSubmitActionLabel('Hapus')
                //     ->modalCancelActionLabel('Batal'),
            ])
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
            'index' => Pages\ListPetugas::route('/'),
            'create' => Pages\CreatePetugas::route('/create'),
            'edit' => Pages\EditPetugas::route('/{record}/edit'),
        ];
    }
}
