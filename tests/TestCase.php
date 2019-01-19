<?php

namespace Thtg88\MmCms\Test;

use Thtg88\MmCms\MmCmsFacade;
use Thtg88\MmCms\MmCmsServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (!is_dir(base_path('routes'))) {
            mkdir(base_path('routes'));
        }

        if (!file_exists(base_path('routes/api.php')))
        {
            file_put_contents(
                base_path('routes/api.php'),
                "<?php\n\n"
            );
        }

        // $this->app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('Illuminate\Session\Middleware\StartSession');
        // $this->app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('Illuminate\View\Middleware\ShareErrorsFromSession');

        $migrator = app('migrator');

        // if (!$migrator->repositoryExists()) {
            $this->artisan('migrate:install');
        // }

        $migrator->run([realpath(__DIR__.'/migrations')]);

        $this->artisan('migrate', ['--path' => realpath(__DIR__.'/migrations')]);

        $this->artisan('migrate', ['--path' => realpath('vendor/laravel/passport/database/migrations')]);

        $this->artisan('mmcms:install');

        if (file_exists(base_path('routes/api.php')))
        {
            require base_path('routes/api.php');
        }
    }

    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return Thtg88\MmCms\MmCmsServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [MmCmsServiceProvider::class];
    }

    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'MmCms' => MmCmsFacade::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
