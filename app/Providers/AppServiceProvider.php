<?php

namespace App\Providers;

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
        $this->app->bind(
            'App\Services\Contracts\EtablissementServiceInterface',
            'App\Services\EtablissementService'
        );
        $this->app->bind(
            'App\Services\Contracts\GradeServiceInterface',
            'App\Services\GradeService'
        );
        $this->app->bind(
            'App\Services\Contracts\DemandeServiceInterface',
            'App\Services\DemandeService'
        );
        $this->app->bind(
            'App\Services\Contracts\DemandeurServiceInterface',
            'App\Services\DemandeurService'
        );

        $this->app->bind(
            'App\Services\Contracts\SoutienServiceInterface',
            'App\Services\SoutienService'
        );
        $this->app->bind(
            'App\Services\Contracts\FileServiceInterface',
            'App\Services\FileService'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
