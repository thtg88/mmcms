<?php

namespace Thtg88\MmCms\Console\Commands;

use Illuminate\Console\Command;

class HttpBundleMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:http-bundle {model_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the HTTP bundle classes (HTTP Requests, Controller, and Service).';

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

        $this->call('make:service', ['name' => $model_name.'Service']);
        $this->call('make:http-requests', ['model_name' => $model_name]);
        $this->call('make:controller', [
            'name' => $model_name.'Controller',
            '--resource' => true,
        ]);
    }
}
