<?php

/**
 * Repository Design Pattern implementation for Laravel
 * 
 * @category Design_Pattern
 * @package  LoaraArch
 * @author   Khris H. <contact@devkhris.com>
 * @license  MIT https://mit-license.org/
 * @version  GIT: 1.2
 * @link     https://github.com/DevKhris/laraarch-repository
 */

namespace DevKhris\LaraArchRepository\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;

/**
 * Repisitory command console implementation for Artisan CLI
 * 
 * @category Design_Pattern
 * @package  LoaraArch
 * @author   Khris H. <contact@devkhris.com>
 * @license  MIT https://mit-license.org/
 * @link     https://github.com/DevKhris/laraarch-repository
 */
class RepositoryMakeCommand extends Command
{
    /**
     * Filesystem instance
     * 
     * @var Filesystem $fs
     */
    protected Filesystem $fs;

    /**
     * Create a new command instance.
     * 
     * @param Filesystem $fs filesystem path
     */
    public function __construct(Filesystem $fs)
    {
        parent::__construct();

        $this->fs = $fs;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {model_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make repository from model';

    /**
     * Execute the console command.
     *
     * @return bool|int
     */
    public function handle()
    {
        // Start the build process
        return $this->buildStubs();
    }

    /**
     * Return the Singular Capitalize Name
     * 
     * @param $model_name model name
     *
     * @return string
     */
    public function getSingularClassName($model_name)
    {
        return ucwords(Pluralizer::singular($model_name));
    }

    /**
     * Return model instance using namespace
     *
     * @return void
     */
    public function getModelsInstance()
    {
        return 'App\\Models\\' . $this
            ->getSingularClassName($this->argument('model_name'));
    }

    /**
     * Return the stub repository file path
     *
     * @return string
     */
    public function getRepositoryStubPath()
    {
        return __DIR__ . './../../Repositories/Models/repository.stub';
    }

    /**
     * Return the stub interface file path
     *
     * @return string
     */
    public function getInterfaceStubPath()
    {
        return __DIR__ . './../../Repositories/Contracts/interface.stub';
    }

    /**
     * Return stub values for repository creation
     *
     * @return array
     */
    public function getStubVariables()
    {
        return [
            'REPOSITORIES_NAMESPACE' => config(
                'repositories_namespace',
                'App\Repositories\Models'
            ),
            'CONTRACTS_NAMESPACE' => config(
                'contracts_namespace',
                'App\Repositories\Contracts'
            ),
            'CLASS_NAME' => $this
                ->getSingularClassName($this->argument('model_name')),
            'INTERFACE_NAME' => $this
                ->getSingularClassName($this->argument('model_name')),
            'MODEL_NAMESPACE' => $this
                ->getModelsInstance(),
            'MODEL_NAME' => $this
                ->getSingularClassName($this->argument('model_name')),
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|array
     */
    public function getSourceFiles()
    {
        $stubVars = $this->getStubVariables();

        $repositoryStub = $this->getStubContents(
            $this->getRepositoryStubPath(),
            $stubVars
        );

        $interfaceStub = $this->getStubContents(
            $this->getInterfaceStubPath(),
            $stubVars
        );

        return [
            'repositoryStub' => $repositoryStub,
            'interfaceStub' => $interfaceStub
        ];
    }

    /**
     * Replace the stub variables with value
     *
     * @param string      $stubFile      stub file used for creation of repository
     * @param array|mixed $stubVariables variables to replace with
     * 
     * @return bool|mixed|string
     */
    public function getStubContents($stubFile, $stubVariables = [])
    {
        $contents = file_get_contents($stubFile);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace("$${search}$", $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path for generated classes
     *
     * @return array
     */
    public function getSourceFilesPaths(): array
    {
        $repositoryPath = config(
            'repositories_namespace',
            'App\Repositories\Models'
        );
        $interfacePath = config(
            'contracts_namespace',
            'App\Repositories\Contracts'
        );

        $realRepositoryPath = base_path(
            $repositoryPath . '\\' . $this->getSingularClassName($this->argument('model_name')) . 'Repository.php'
        );
        $realInterfacePath = base_path(
            $interfacePath . '\\' . $this->getSingularClassName($this->argument('model_name')) . 'RepositoryInterface.php'
        );

        return [
            'repositoryPath' => $realRepositoryPath,
            'interfacePath' => $realInterfacePath
        ];
    }

    /**
     * Build the directory for the files.
     *
     * @param string $path create path with permissions
     * 
     * @return string
     */
    protected function makePath($path): string
    {
        if (!$this->fs->isDirectory($path)) {
            $this->fs->makeDirectory($path, 0755, true, true);
        }

        return $path;
    }

    /**
     * Build stubs to final result
     *
     * @return bool|int
     */
    public function buildStubs()
    {
        // Get stubs paths
        $paths = $this->getSourceFilesPaths();

        // Get stubs contents
        $contents = $this->getSourceFiles();

        // Make correspondent dirs
        $this->makePath(dirname($paths['repositoryPath']));
        $this->makePath(dirname($paths['interfacePath']));

        // Check if file exists
        if (!$this->fs->exists($paths['repositoryPath']) && !$this->fs->exists($paths['interfacePath'])) {

            // Create repository from stub
            $this->fs->put($paths['repositoryPath'], $contents['repositoryStub']);
            $this->info("Repository succesfully created");
            // Create contract from stub
            $this->fs->put($paths['interfacePath'], $contents['interfaceStub']);
            $this->info("Contract succesfully created");
            return true;
        } else {
            $this->info('Files already exists');
            return false;
        }

        return false;
    }
}
