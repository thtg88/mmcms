<?php

namespace Thtg88\MmCms\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class ServiceMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/service.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Services';
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
            ->replaceRepository($stub, $name)
            ->replaceClass($stub, $name);
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
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        $class = str_replace('Service', 'Repository', $class);

        $stub = str_replace('DummyRepository', $class, $stub);

        return $this;
    }
}
