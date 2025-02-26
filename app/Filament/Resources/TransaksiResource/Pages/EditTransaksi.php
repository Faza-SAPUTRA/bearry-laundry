<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTransaksi extends EditRecord
{

    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label(__('Tambah Transaksi'))
            ->submit('create')
            ->color('secondary')
            ->keyBindings(['mod+s'])
            ->hidden();
    }
    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('Simpan'))
            ->submit('save')
            ->color('secondary')
            ->keyBindings(['mod+s'])
            ->hidden();
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return Action::make('createAnother')
            ->label(__('Simpan dan Buat Transaksi lagi'))
            ->submit('createAnother')
            ->color('primary')
            ->keyBindings(['mod+shift+s'])
            ->hidden();
    }
protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label(__('Batal'))
            ->url($this->getResource()::getUrl('index'))
            ->color('gray')
            ->keyBindings(['mod+b'])
            ->hidden();
    }

    public function getHeading(): string
    {
        return 'Ubah Transaksi 
        ' . $this->getRecord()->id_transaksi;
    }
    protected static string $resource = TransaksiResource::class;

    protected function getRedirectUrl(): string
    {
        return
            $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification {
        $transaksi = $this->getRecord();
        return Notification::make()
        ->success()
        ->title('Transaksi berhasil diubah')
        ->body("ID Transaksi {$transaksi->id_transaksi} berhasil diubah.");
    }
}
