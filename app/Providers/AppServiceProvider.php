<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route as FacadesRoute;
use Illuminate\Support\ServiceProvider;

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
        //
        FacadesRoute::resourceVerbs([
            'create' => 'novo',
            'edit' => 'editar'
        ]);
    }
}
