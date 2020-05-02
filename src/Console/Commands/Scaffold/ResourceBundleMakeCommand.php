<?php

namespace Thtg88\MmCms\Console\Commands\Scaffold;

use Illuminate\Console\Command;

class ResourceBundleMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mmcms:make:resource-bundle {model_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the resource bundle classes (model, repository, HTTP Requests, Controller, and Service).';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get model name from arguments
        $model_name = $this->argument('model_name');

        $this->call('make:model', ['name' => 'Models\\'.$model_name]);
        $this->call('mmcms:make:repository', ['name' => $model_name.'Repository']);
        $this->call('mmcms:make:http-bundle', ['model_name' => $model_name]);
    }
}
