<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Establecer el idioma de Carbon a español
        Carbon::setLocale('es');

        // Establecer la zona horaria predeterminada
        date_default_timezone_set('America/Santiago');
    }

}
