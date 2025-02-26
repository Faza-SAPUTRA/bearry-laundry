<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Closure;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as RulesPassword;

class ListUsers extends ListRecords
{
    protected static ?string $breadcrumb = "List Akun";
    protected static string $resource = UserResource::class;

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }

    protected function getActions(): array
    {
        return [
            Action::make('create')
                ->label('Tambah Akun Baru')
                ->icon('heroicon-o-plus')
                ->modalHeading('Tambah Akun Baru')
                ->modalDescription('Silakan isi data akun baru')
                ->modalSubmitActionLabel('Tambah Akun')
                ->modalCancelActionLabel('Batal')
                ->modalWidth('md')
                ->form([
                    TextInput::make('name')
                        ->label('Nama User')
                        ->required()
                        ->unique(ignoreRecord:true)
                        ->maxLength(255)
                        ->validationMessages([
                            'required' => 'Nama akun wajib diisi.',
                            'unique' => 'Nama akun sudah ada.',
                            'max' => 'Nama tidak boleh lebih dari 255 karakter.',
                        ]),

                    TextInput::make('email')
                        ->label('Email User')
                        ->required()
                        ->unique(User::class, 'email')
                        ->validationMessages([
                            'required' => 'Email wajib diisi.',
                            'unique' => 'Email ini sudah terdaftar.',
                        ]),

                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->required()
                        ->rule(RulesPassword::min(8)->letters()->mixedCase()->numbers()->symbols())
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))
                        ->validationMessages([
                            'required' => 'Password wajib diisi.',
                            'min' => 'Password harus memiliki minimal 8 karakter.',
                        ]),

                    Select::make('roles')
                        ->relationship('roles', 'name')
                        ->label('Role')
                        ->placeholder('Pilih jabatan')
                        ->required()
                        ->preload()
                        ->searchable()
                        ->validationMessages([
                            'required' => 'Role wajib dipilih.',
                        ]),
                ])
                ->action(function (array $data) {
                    $user = User::create($data);
                    $user->assignRole($data['roles']); // Assign role setelah user dibuat
                    Notification::make()
                        ->title("Akun {$user->name} berhasil ditambahkan 🎉")
                        ->success()
                        ->sendToDatabase(auth()->user())
                        ->send();
                }),
        ];
    }
}
