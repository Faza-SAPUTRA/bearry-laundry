<?php

namespace App\Filament\Resources\JenisCucianResource\Pages;

use App\Filament\Resources\JenisCucianResource;
use App\Models\JenisCucian;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class ListJenisCucians extends ListRecords
{
    protected static ?string $breadcrumb = "List Jenis Cucian";
    protected static string $resource = JenisCucianResource::class;

    protected function getActions(): array
{
    return [
        Action::make('create')
            ->label('Tambah Jenis Cucian Baru')
            ->icon('heroicon-o-plus')
            ->modalHeading('Tambah Jenis Cucian Baru')
            ->modalDescription('Silakan isi data jenis cucian baru')
            ->modalSubmitActionLabel('Tambah Jenis Cucian')
            ->modalCancelActionLabel('Batal')
            ->modalWidth('md')
            ->form([
                TextInput::make('nama_jenis_cucian')
                    ->label('Nama Jenis Cucian')
                    ->required()
                    ->unique('jenis_cucian', 'nama_jenis_cucian') // 🔥 Pastikan unik di database
                    ->validationMessages([
                        'required' => 'Nama Jenis Cucian wajib diisi.',
                        'unique' => 'Nama Jenis Cucian ini sudah ada.',
                    ]),

                Select::make('id_jenis_timbangan')
                    ->label('Jenis Timbangan')
                    ->placeholder('Pilih jenis timbangan')
                    ->relationship('jenisTimbangan', 'nama_jenis_timbangan')
                    ->required()
                    ->validationMessages([
                        'required' => 'Jenis Timbangan wajib dipilih.',
                    ]),

                TextInput::make('harga_per_timbangan')
                    ->label('Harga per timbangan')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->validationMessages([
                        'required' => 'Harga wajib diisi.',
                        'numeric' => 'Harga harus berupa angka.',
                    ]),
            ])
            ->action(function (array $data) {
                $jeniscucian = JenisCucian::create($data);

                Notification::make()
                    ->title("Jenis Cucian {$jeniscucian->nama_jenis_cucian} berhasil ditambahkan 🎉")
                    ->success()
                    ->sendToDatabase(auth()->user())
                    ->send(); // 🔥 Notifikasi langsung muncul tanpa refresh
            }),
    ];
}

}
