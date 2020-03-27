<?php

namespace Thtg88\MmCms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Config;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class PublishModuleCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mmcms:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish a module from mmCMS.';

    /**
     * The Filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        parent::__construct();
    }

    public function fire()
    {
        return $this->handle();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $module_name = $this->argument('module');

        if (empty($module_name)) {
            return $this->error('Module argument is mandatory.');
        }

        $this->copyAllFiles($module_name, $this->option('force'));
    }

    /**
     * Copy all the files from the given module name.
     *
     * @param $module_name
     * @param $force
     *
     * @return mixed
     */
    protected function copyAllFiles($module_name, $force = false)
    {
        $module_directory = Container::getInstance()->basePath('vendor/thtg88/mmcms/'.$module_name);

        if (! $this->filesystem->isDirectory($module_directory)) {
            return $this->error('Module '.$module_name.' not found.');
        }

        $all_files = $this->filesystem->allFiles($module_directory, true);

        foreach ($all_files as $source_file) {
            $namespace = Config::get(
                'mmcms.modules.namespace',
                'Thtg88\\MmCms\\Modules'
            );

            $appNamespace = app()->getNamespace();

                return $this->error('The modules namespace must start with your application namespace: '.$appNamespace);
            if (! Str::startsWith($namespace, $appNamespace)) {
            }

            $location = str_replace(
                '\\',
                DIRECTORY_SEPARATOR,
                substr($namespace, strlen($appNamespace))
            );

            if (
                ! $this->filesystem
                    ->isDirectory(Container::getInstance()->path($location))
            ) {
                $this->filesystem
                    ->makeDirectory(Container::getInstance()->path($location));
            }

            $parts = explode(DIRECTORY_SEPARATOR, $source_file);
            $filename = end($parts);

            $destination_path = Container::getInstance()
                ->path($location.DIRECTORY_SEPARATOR.$filename);

            if (
                ! $this->filesystem->exists($destination_path) ||
                $this->option('force')
            ) {
                $this->filesystem->put(
                    $destination_path,
                    $this->filesystem->get($source_file)
                );
            } else {
                $this->warn($source_file.' of module '.$this->argument('module').' already exists. Run the command with option --force to overwrite.');
            }
        }
    }
}
