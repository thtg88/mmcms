<?php

namespace Thtg88\MmCms\Tests\Feature;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Thtg88\MmCms\MmCms;
use Thtg88\MmCms\MmCmsServiceProvider;
use Thtg88\MmCms\Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * The route URL.
     *
     * @var string
     */
    protected $url;

    protected function setUp(): void
    {
        parent::setUp();

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

        MmCms::routes();

        $this->artisan('mmcms:install');
    }

    protected function tearDown(): void
    {
        $this->artisan('db:wipe');

        parent::tearDown();
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
     *
     * @param \Illuminate\Foundation\Application $app
     * @return Thtg88\MmCms\MmCmsServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [MmCmsServiceProvider::class];
    }
}
