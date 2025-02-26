<?php

namespace App\Filament\Resources\JenisTimbanganResource\Pages;

use App\Filament\Resources\JenisTimbanganResource;
use App\Models\JenisTimbangan;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class ListJenisTimbangans extends ListRecords
{
    protected static string $resource = JenisTimbanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Tambah Jenis Satuan')
                ->icon('heroicon-o-plus')
                ->modalHeading('Tambah Jenis Satuan Baru')
                ->modalDescription('Silakan isi data jenis satuan baru')
                ->modalSubmitActionLabel('Tambah Jenis Satuan')
                ->modalCancelActionLabel('Batal')
                ->modalWidth('md')
                ->form([
                    TextInput::make('nama_jenis_timbangan')
                        ->label('Nama Jenis Timbangan')
                        ->required()
                        ->unique(JenisTimbangan::class, 'nama_jenis_timbangan') // ✅ Cegah duplikasi
                        ->maxLength(50)
                        ->validationMessages([
                            'required' => 'Nama Jenis Satuan wajib diisi.',
                            'unique' => 'Nama ini sudah digunakan oleh satuan lain.',
                        ]),
                ])
                ->action(function (array $data) {
                    $jenistimbangan = JenisTimbangan::create($data);
                    Notification::make()
                        ->title("Jenis Satuan {$jenistimbangan->nama_jenis_timbangan} berhasil ditambahkan👍")
                        ->success()
                        ->sendToDatabase(auth()->user())
                        ->send();
                }),
        ];
    }
}
