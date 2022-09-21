<?php

namespace App\Providers;

use App\Models\Acquiring\AcquiringPaymentCustom;
use Illuminate\Support\ServiceProvider;
use App\Observers\AcquiringPaymentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        AcquiringPaymentCustom::observe(AcquiringPaymentObserver::class);
    }
}
