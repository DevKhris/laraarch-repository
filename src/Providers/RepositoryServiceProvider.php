<?php

namespace DevKhris\LaraArchRepository\Providers;

use Illuminate\Support\ServiceProvider;
use DevKhris\LaraArchRepository\Console\Commands\RepositoryMakeCommand;

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
            __DIR__.'/../config/laraarch-repository.php', 'laraarch-repository'
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
            __DIR__.'/../config/laraarch-repository.php' => config_path('laraarch-repository.php'),
        ]);

        // Register command
        if ($this->app->runningInConsole()) {
            $this->commands([
                RepositoryMakeCommand::class,
            ]);
        }
    }
}
