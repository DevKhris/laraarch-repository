<?php

namespace DevKhris\LaraArchRepository\Providers;

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
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../config/repository.php', 'repository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/repository.php' => config_path('repository.php'),
        ]);

        // Register command
        if ($this->app->runningInConsole()) {
            $this->commands([
                RepositoryMakeCommand::class,
            ]);
        }
    }
}
