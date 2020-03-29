<?php

namespace Thtg88\MmCms\Tests;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Thtg88\MmCms\MmCmsFacade;
use Thtg88\MmCms\MmCmsServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // if (!is_dir(base_path('routes'))) {
        //     mkdir(base_path('routes'));
        // }

        // if (!file_exists(base_path('routes/api.php'))) {
        //     file_put_contents(
        //         base_path('routes/api.php'),
        //         "<?php\n\n"
        //     );
        // }

        // $this->app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('Illuminate\Session\Middleware\StartSession');
        // $this->app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('Illuminate\View\Middleware\ShareErrorsFromSession');

        // $migrator = Container::getInstance()->make('migrator');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->index('email');
        });

        // In the context of TestBench,
        // migrations get run in the TestBench core folder
        $this->artisan('migrate', [
            '--path' => [
                '../../../../database/migrations',
                '../../../laravel/passport/database/migrations',
            ],
        ]);

        MmCmsFacade::routes();

        $this->artisan('mmcms:install');

        // if (file_exists(base_path('routes/api.php'))) {
        //     require base_path('routes/api.php');
        // }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->artisan('db:wipe');
    }

    protected function getEnvironmentSetUp($app)
    {
        $config = $app->make(Repository::class);

        // $config->set('auth.defaults.provider', 'users');
        //
        // if (($userClass = $this->getUserClass()) !== null) {
        //     $config->set('auth.providers.users.model', $userClass);
        // }

        // $config->set('auth.guards.api', ['driver' => 'passport', 'provider' => 'users']);

        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Load package service provider
     * @param \Illuminate\Foundation\Application $app
     * @return Thtg88\MmCms\MmCmsServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [MmCmsServiceProvider::class];
    }

    /**
     * Load package alias
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    // protected function getPackageAliases($app)
    // {
    //     return [
    //         'MmCms' => MmCmsFacade::class,
    //     ];
    // }
}
