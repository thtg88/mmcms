<?php

namespace Thtg88\MmCms\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ResourceRequestMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:resource-request
                            {name : The model name the class is targeting}
                            {--method= : The method name (e.g. store, update, destroy, etc.)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new request class from a given method';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/'.$this->option('method').'-request.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Requests';
    }

    /**
     * Get the destination class path.
     *
     * @param string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $path = $this->laravel['path'].'/'.str_replace('\\', '/', $name).'/'.
            ucfirst($this->option('method')).'Request.php';

        return $path;
    }

    /**
     * Build the class with the given name.
     *
     * @param string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceSuperNamespace($stub, $name)
            ->replaceRepository($stub, $name)
            ->replaceClass($stub, $name);
    }

    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\').
            '\\'.$this->argument('name');
    }

    /**
     * Replace the model sub namespace for the given stub.
     *
     * @param string  $stub
     * @param string  $name
     * @return string
     */
    protected function replaceSuperNamespace(&$stub, $name)
    {
        $namespace = str_replace('\\'.$this->argument('name'), '', $name);

        $stub = str_replace(
            'DummySuperNamespace',
            $namespace,
            $stub
        );

        return $this;
    }

    /**
     * Replace the model class name for the given stub.
     *
     * @param string  $stub
     * @param string  $name
     * @return string
     */
    protected function replaceRepository(&$stub, $name)
    {
        $stub = str_replace(
            'DummyRepository',
            $this->argument('name').'Repository',
            $stub
        );

        return $this;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['method', null, InputOption::VALUE_REQUIRED, 'The method name (e.g. store, update, destroy, etc.).'],
        ];
    }
}
