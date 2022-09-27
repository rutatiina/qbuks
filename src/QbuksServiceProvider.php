<?php

namespace Rutatiina\Qbuks;

use Illuminate\Support\ServiceProvider;
use Rutatiina\Qbuks\Console\Commands\AfterUpdateCommand;

class QbuksServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes/routes.php';

        $this->loadViewsFrom(__DIR__.'/resources/views/limitless', 'admin');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                AfterUpdateCommand::class,
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Rutatiina\Qbuks\Http\Controllers\QbuksController');
    }
}
