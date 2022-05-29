<?php

namespace DevKhris\LaravelRepository\Console\Commands;

use Illuminate\Console\Command;

class RepositoryMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repository:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make repository from model';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // TODO: stub creation process
        return 0;
    }
}
