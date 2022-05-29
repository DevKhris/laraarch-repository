<?php

namespace DevKhris\LaravelRepository;

use Illuminate\Support\ServiceProvider;
use DevKhris\LaravelRepository\Console\Commands\RepositoryMakeCommand;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
        $this->commands([
            RepositoryMakeCommand::class,
        ]);
    }
    }
}
