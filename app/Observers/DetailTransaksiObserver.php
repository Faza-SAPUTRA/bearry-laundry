<?php

namespace App\Observers;

use App\Models\DetailTransaksi;

class DetailTransaksiObserver
{
    /**
     * Handle the DetailTransaksi "created" event.
     */
    public function created(DetailTransaksi $detailTransaksi): void
    {
        //
    }

    /**
     * Handle the DetailTransaksi "updated" event.
     */
    public function updated(DetailTransaksi $detailTransaksi): void
    {
        //
    }

    /**
     * Handle the DetailTransaksi "deleted" event.
     */
    public function deleted(DetailTransaksi $detailTransaksi): void
    {
        //
    }

    /**
     * Handle the DetailTransaksi "restored" event.
     */
    public function restored(DetailTransaksi $detailTransaksi): void
    {
        //
    }

    /**
     * Handle the DetailTransaksi "force deleted" event.
     */
    public function forceDeleted(DetailTransaksi $detailTransaksi): void
    {
        //
    }
}
