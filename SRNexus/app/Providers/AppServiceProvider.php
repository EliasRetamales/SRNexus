<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //registrar servicio para uso de influx
        $this->app->singleton(\App\Services\InfluxdbService::class, function ($app) {
            return new \App\Services\InfluxdbService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if ($view->getName() !== 'adminlte::page') {
                $view->extends('adminlte::page');
            }
        });
    }
}
