<?php

namespace App\Filament\Resources\PetugasResource\Pages;

use App\Filament\Resources\PetugasResource;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Models\Petugas;
use Closure;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\PhoneInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as RulesPassword;

class ListPetugas extends ListRecords
{
    protected static ?string $breadcrumb = "List Petugas";
    protected static string $resource = PetugasResource::class;
    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }

    protected function getActions(): array
    {
        return [
            Action::make('create')
                ->label('Tambah Petugas Baru')
                ->icon('heroicon-o-plus')
                ->modalHeading('Tambah Petugas Baru')
                ->modalDescription('Silakan isi data petugas baru')
                ->modalSubmitActionLabel('Tambah Petugas')
                ->modalCancelActionLabel('Batal')
                ->modalWidth('md')
                ->form([
                    TextInput::make('nama_petugas')
                        ->label('Nama Petugas')
                        ->required()
                        ->maxLength(100)
                        ->unique()
                        ->validationMessages([
                            'required' => 'Nama Petugas wajib diisi.',
                            'max' => 'Nama Petugas tidak boleh lebih dari 100 karakter.',
                            'unique' => 'Nama Petugas ini sudah ada.',
                        ]),

                    \Ysfkaya\FilamentPhoneInput\Forms\PhoneInput::make('no_telp')
                        ->label('Nomor Telepon')
                        ->required()
                        ->onlyCountries(['ID', 'SG', 'MY', 'TH'])
                        ->defaultCountry('ID')
                        ->unique()
                        ->validationMessages([
                            'required' => 'Nomor Telepon wajib diisi.',
                            'unique' => 'Nomor Telepon ini sudah digunakan.',
                        ]),

                    Select::make('jk')
                        ->label('Jenis Kelamin')
                        ->placeholder('Pilih jenis kelamin')
                        ->options([
                            'L' => 'Laki-Laki',
                            'P' => 'Perempuan',
                        ])
                        ->required()
                        ->validationMessages([
                            'required' => 'Jenis Kelamin wajib dipilih.',
                        ]),
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'aktif' => 'Aktif',
                            'nonaktif' => 'Nonaktif',
                        ])
                        ->default('aktif')
                        ->required()
                        ->native(false),

                    Select::make('user_id')
                        ->placeholder('Pilih akun petugas')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->required()
                        ->unique(table: 'petugas', column: 'user_id') // Pastikan user_id unik
                        ->validationMessages([
                            'required' => 'Akun Petugas wajib dipilih.',
                            'unique' => 'Akun ini sudah digunakan oleh petugas lain.',
                        ])
                        ->createOptionForm([
                            TextInput::make('name')
                                ->required()
                                ->label('Nama User'),
                            TextInput::make('email')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->label('Email User'),
                            TextInput::make('password')
                                ->required()
                                ->password()
                                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                ->visible(fn($livewire) => $livewire instanceof CreateUser)
                                ->rule(RulesPassword::min(8)->letters()->mixedCase()->numbers()->symbols())
                                ->label('Password'),
                            Select::make('roles')
                                ->relationship('roles', 'name')
                                ->label('Role')
                                ->required()
                                ->preload()
                                ->searchable(),
                        ]),
                ])
                ->action(function (array $data) {
                    $petugas = Petugas::create($data);
                    $recipient = auth()->user();
                    Notification::make()
                        ->title("Petugas bernama {$petugas->nama_petugas} berhasil ditambahkan 👍")
                        ->success()
                        ->sendToDatabase($recipient);
                }),
        ];
    }
}
