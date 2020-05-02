<?php

namespace Thtg88\MmCms\Console\Commands\Scaffold;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ScaffoldMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mmcms:make:scaffold {model_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the necessary model classes to scaffold the application (migration, model, repository, seeder, HTTP Requests, controller, and service).';

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

        $this->call('make:model', [
            'name' => 'Models\\'.$model_name,
            '--migration' => true,
        ]);
        $this->call('make:seeder', [
            'name' => Str::plural($model_name).'TableSeeder',
        ]);
        $this->call('mmcms:make:repository', [
            'name' => $model_name.'Repository',
        ]);
        $this->call('mmcms:make:http-bundle', ['model_name' => $model_name]);
        $this->call('make:factory', ['name' => $model_name.'Factory']);

        $test_methods = [
            'Create',
            'Destroy',
            'Edit',
            'Index',
            'Paginate',
            'Store',
            'Update',
        ];
        $user_roles = [
            'Admin',
            'Dev',
            'User',
        ];
        foreach ($test_methods as $test_method) {
            foreach ($user_roles as $user_role) {
                $this->call('make:test', [
                    'name' => $model_name.'\\'.$test_method.'\\'.$user_role.
                        'Test',
                ]);
            }
        }
    }
}
