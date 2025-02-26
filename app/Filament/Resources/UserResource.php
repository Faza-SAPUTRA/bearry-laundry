<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Models\Petugas;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as RulesPassword;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user-circle';
    protected static ?int $navigationSort = -1;
    protected static ?string $pluralLabel = 'Akun'; // Override nama plural
    protected static ?string $label = 'Akun Petugas'; // Override nama singular
    protected static ?string $navigationLabel = 'Akun Petugas';
    protected static ?string $slug = 'account/petugas';
    protected static ?string $navigationGroup = 'Manajemen Akun';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Details')
                    ->collapsible()
                    ->description('Masukkan detail user yang akan dibuat')
                    ->icon('heroicon-m-user-circle')
                    ->iconColor('primary')
                    ->schema([
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
                    ])
                    ->columns(1),

                Section::make('User New Password')
                    ->collapsible()
                    ->description('Masukkan password baru jika ingin mengubah password')
                    ->icon('heroicon-m-lock-closed')
                    ->iconColor('warning')
                    ->schema([
                        TextInput::make('new_password')
                            ->nullable()
                            ->password()
                            ->rule(RulesPassword::min(8)->letters()->mixedCase()->numbers()->symbols())
                            ->label('Password Baru'),
                        TextInput::make('new_password_confirmation')
                            ->password()
                            ->same('new_password')
                            ->requiredWith('new_password')
                            ->label('Konfirmasi Password Baru'),
                    ])
                    ->visible(fn($livewire) => $livewire instanceof EditUser)
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama User')
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->iconColor('primary')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email User')
                    ->icon('heroicon-o-envelope')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->icon('heroicon-o-check-circle')
                    ->iconColor('warning')
                    ->label('Jabatan')
                    ->sortable()
                    ->formatStateUsing(fn($state): string => is_array($state) ? implode(', ', $state) : ($state ?? 'Tidak Ada')),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->icon('heroicon-o-calendar')
                    ->dateTime('d F Y')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->label('Jabatan')
                    ->multiple()
                    ->preload(),
                Tables\Filters\TrashedFilter::make() // Tambahkan filter untuk menampilkan data yang dihapus
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    // View Action
                    Tables\Actions\ViewAction::make('view_data')
                        ->label('Lihat Data')
                        ->icon('heroicon-o-eye'),

                    // Edit Action (Modal)
                    Tables\Actions\Action::make('edit')
                        ->label('Edit')
                        ->icon('heroicon-o-pencil')
                        ->color('warning')
                        ->modalHeading(fn(User $record) => "Edit Akun: {$record->name}")
                        ->modalDescription('Silakan ubah data akun sesuai kebutuhan')
                        ->modalSubmitActionLabel('Simpan Perubahan')
                        ->modalCancelActionLabel('Batal')
                        ->modalWidth('md')
                        ->form([
                            TextInput::make('name')
                                ->label('Nama User')
                                ->required()
                                ->maxLength(255)
                                ->default(fn(User $record) => $record->name)
                                ->validationMessages([
                                    'required' => 'Nama user wajib diisi.',
                                ]),

                            TextInput::make('email')
                                ->label('Email User')
                                ->required()
                                ->email()
                                ->unique(User::class, 'email', ignoreRecord: true)
                                ->default(fn(User $record) => $record->email)
                                ->validationMessages([
                                    'required' => 'Email wajib diisi.',
                                    'unique' => 'Email ini sudah digunakan oleh pengguna lain.',
                                    'email' => 'Format email tidak valid.',
                                ]),

                            Select::make('roles')
                                ->relationship('roles', 'name')
                                ->label('Role')
                                ->required()
                                ->preload()
                                ->searchable()
                                ->default(fn(User $record) => $record->roles->pluck('id')->toArray())
                                ->validationMessages([
                                    'required' => 'Role wajib dipilih.',
                                ]),

                            TextInput::make('new_password')
                                ->label('Password Baru')
                                ->nullable()
                                ->password()
                                ->rule(RulesPassword::min(8)->letters()->mixedCase()->numbers()->symbols())
                                ->validationMessages([
                                    'min' => 'Password minimal 8 karakter.',
                                    'letters' => 'Password harus mengandung huruf.',
                                    'mixedCase' => 'Password harus mengandung huruf besar dan kecil.',
                                    'numbers' => 'Password harus mengandung angka.',
                                    'symbols' => 'Password harus mengandung simbol.',
                                ]),

                            TextInput::make('new_password_confirmation')
                                ->label('Konfirmasi Password Baru')
                                ->password()
                                ->same('new_password')
                                ->requiredWith('new_password')
                                ->validationMessages([
                                    'same' => 'Konfirmasi password harus sama dengan password baru.',
                                    'required_with' => 'Konfirmasi password wajib diisi jika password baru diisi.',
                                ]),
                        ])
                        ->action(function (User $record, array $data) {
                            if (!empty($data['new_password'])) {
                                $data['password'] = Hash::make($data['new_password']);
                            }
                            unset($data['new_password'], $data['new_password_confirmation']);

                            $record->update($data);
                            Notification::make()
                                ->title("Akun {$record->name} berhasil diperbarui 👍")
                                ->sendToDatabase(auth()->user())
                                ->success()
                                ->send();
                        }),


                        Tables\Actions\Action::make('hapus')
                        ->label('Hapus')
                        ->color('danger')
                        ->icon('heroicon-s-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Hapus')
                        ->modalSubheading(function (User $record) {
                            // Cek apakah ada transaksi terkait
                            $transaksiTerkait = \App\Models\Transaksi::where('user_id', $record->id)->exists();
                            
                            $message = "Apakah kamu yakin ingin menghapus {$record->name}?";
                            
                            // Tambahkan peringatan jika ada transaksi
                            if ($transaksiTerkait) {
                                $message .= "\n\n⚠️ PERINGATAN: Akun ini memiliki transaksi terkait!";
                            }
                            
                            return $message;
                        })
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal')
                        ->action(function (User $record) {
                            // Proses penghapusan
                            $record->delete();
                            
                            // Notifikasi sukses
                            Notification::make()
                                ->title("Akun berhasil dihapus")
                                ->success()
                                ->sendToDatabase(auth()->user());
                        }),

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
                    ->label('Aksi')
                    ->icon('heroicon-o-ellipsis-vertical')
            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Hapus Data') // Opsional: Menyesuaikan label
                    ->icon('heroicon-o-trash')
                    ->color('danger') // Warna merah untuk indikasi penghapusan
                    ->requiresConfirmation()
                    ->modalDescription(fn(User $record) => "Apakah kamu yakin ingin menghapus data akun terpilih ?")
                    ->modalSubmitActionLabel('Hapus')
                    ->modalCancelActionLabel('Batal'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
