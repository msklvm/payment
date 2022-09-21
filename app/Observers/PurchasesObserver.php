<?php

namespace App\Observers;

use App\Models\Purchases;

class PurchasesObserver
{
    /**
     * Handle the purchases "created" event.
     *
     * @param  \App\Models\Purchases  $purchases
     * @return void
     */
    public function created(Purchases $purchases)
    {
    }
    /**
     * Handle the purchases "saved" event.
     *
     * @param  \App\Models\Purchases  $purchases
     * @return void
     */
    public function saved(Purchases $purchases)
    {
//        dd($purchases);
    }

    /**
     * Handle the purchases "updated" event.
     *
     * @param  \App\Models\Purchases  $purchases
     * @return void
     */
    public function updated(Purchases $purchases)
    {
        //
    }

    /**
     * Handle the purchases "deleted" event.
     *
     * @param  \App\Models\Purchases  $purchases
     * @return void
     */
    public function deleted(Purchases $purchases)
    {
        //
    }

    /**
     * Handle the purchases "restored" event.
     *
     * @param  \App\Models\Purchases  $purchases
     * @return void
     */
    public function restored(Purchases $purchases)
    {
        //
    }

    /**
     * Handle the purchases "force deleted" event.
     *
     * @param  \App\Models\Purchases  $purchases
     * @return void
     */
    public function forceDeleted(Purchases $purchases)
    {
        //
    }
}
