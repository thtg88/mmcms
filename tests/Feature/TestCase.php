<?php

namespace Thtg88\MmCms\Tests\Feature;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Thtg88\MmCms\MmCms;
use Thtg88\MmCms\MmCmsServiceProvider;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use WithFaker;

    /**
     * The route URL.
     *
     * @var string
     */
    protected $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../../database/factories');

        MmCms::routes();

        $app = Container::getInstance();

        if (
            ! Schema::hasTable('users') ||
            ! Schema::hasTable('oauth_clients')
        ) {
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

            $this->artisan('mmcms:install');
        }


        $oauth_clients = DB::select(
            'select * from oauth_clients where password_client = 1'
        );

        $app['config']->set('mmcms.passport', [
            'oauth_url' => 'http://localhost',
            'password_client_id' => count($oauth_clients) === 0 ?
                null :
                $oauth_clients[0]->id,
            'password_client_secret' => count($oauth_clients) === 0 ?
                null :
                $oauth_clients[0]->secret,
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    protected function getEnvironmentSetUp($app)
    {
        // $app['config']->set('auth.defaults.provider', 'users');

        // $app['config']->set('auth.providers.users.model', User::class);

        // $app['config']->set('auth.guards.api', [
        //     'driver' => 'passport',
        //     'provider' => 'users',
        // ]);

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

    protected function passportActingAs(User $user): self
    {
        Passport::actingAs($user);

        return $this;
    }

    protected function passportAuthLogout(): void
    {
        Auth::user()->token()->revoke();
    }
}
