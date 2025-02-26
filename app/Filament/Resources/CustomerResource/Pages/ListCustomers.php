<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\CustomerResource\Widgets\CustomerStats;
use App\Models\Customer;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class ListCustomers extends ListRecords
{
    protected static ?string $breadcrumb = "List Customer";
    protected static string $resource = CustomerResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('create')
                ->label('Tambah Customer Baru')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Tambah Customer')
                ->modalWidth('md')
                ->modalSubmitActionLabel('Simpan Data')
                ->modalCancelActionLabel('Batal')
                ->form([
                    TextInput::make('nama_customer')
                        ->label('Nama Customer')
                        ->placeholder('Masukkan Nama Customer')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->validationMessages([
                            'required' => 'Nama Customer wajib diisi.',
                            'unique' => 'Nama Customer sudah ada.',
                        ]),

                    PhoneInput::make('no_telp')
                        ->label('Nomor Telepon')
                        ->required()
                        ->onlyCountries(['ID', 'SG', 'MY', 'TH'])
                        ->defaultCountry('ID')
                        ->countrySearch(true)
                        ->showFlags(true)
                        ->formatAsYouType(true)
                        ->unique(ignoreRecord: true)
                        ->validationMessages([
                            'required' => 'Nomor Telepon wajib diisi.',
                            'regex' => 'Nomor Telepon hanya boleh berisi angka dan simbol "+".',
                            'unique' => 'Nomor Telepon sudah digunakan.',
                        ]),

                    Textarea::make('alamat')
                        ->label('Alamat Customer')
                        ->placeholder('Masukkan Alamat Customer')
                        ->required()
                        ->validationMessages([
                            'required' => 'Alamat Customer wajib diisi.',
                        ]),

                    Select::make('tipe_customer')
                        ->label('Tipe Customer')
                        ->placeholder('Pilih tipe customer')
                        ->options([
                            'guest' => 'Guest',
                            'membership' => 'Membership',
                        ])
                        ->required()
                        ->validationMessages([
                            'required' => 'Tipe Customer wajib dipilih.',
                        ]),
                ])
                ->action(function (array $data) {
                    Customer::create($data);
                    $recipient = auth()->user();
                    Notification::make()
                        ->title("Customer baru berhasil ditambahkan 👍")
                        ->success()
                        ->send()
                        ->sendToDatabase($recipient);
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CustomerStats::class,
        ];
    }
}
