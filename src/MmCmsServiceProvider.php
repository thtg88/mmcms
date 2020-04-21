<?php

namespace Thtg88\MmCms;

use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Thtg88\MmCms\Helpers\JournalEntryHelper;
use Thtg88\MmCms\MmCms as MmCmsFacade;
use Thtg88\MmCms\Providers\CurrentTimeServiceProvider;

class MmCmsServiceProvider extends ServiceProvider
{
    use Concerns\WithCommands,
        Concerns\WithProvidedEvents,
        Concerns\WithProvidedPolicies;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('MmCms', MmCmsFacade::class);

        $this->app->singleton('mmcms', function () {
            return new MmCms();
        });

        $this->app->bind('OauthHttpClient', function () {
            return new Client([
                'base_uri' => Config::get('mmcms.passport.oauth_url'),
                'verify' => Config::get('app.env') !== 'local' &&
                    Config::get('app.env') !== 'testing',
            ]);
        });

        // Config
        $this->publishes([
            __DIR__.'/../config/mmcms.php' => Container::getInstance()
                ->configPath('mmcms.php'),
        ], 'mmcms-config');

        // Routes
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../database/migrations' => Container::getInstance()
                ->databasePath('migrations'),
        ], 'mmcms-migrations');

        // Translations
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'mmcms');
        $this->publishes(
            [
                __DIR__.'/../resources/lang' => Container::getInstance()
                    ->resourcePath('lang/vendor/mmcms'),
            ],
            'mmcms-translations'
        );

        // Views
        // $this->loadViewsFrom(__DIR__.'/../views', 'mmcms');
        // $this->publishes([
        //     __DIR__.'/../reousrces/views' => resource_path('views/vendor/mmcms'),
        // ], 'views');

        // Assets
        // $this->publishes([
        //     __DIR__.'/../reousrces/assets' => public_path('vendor/mmcms'),
        // ], 'assets');

        $this->bootCommands();
        $this->bootEvents();
        $this->bootPolicies();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(CurrentTimeServiceProvider::class);

        $this->mergeConfigFrom(__DIR__.'/../config/mmcms.php', 'mmcms');

        $this->app->singleton(MmCms::class, function () {
            return new MmCms();
        });

        if (Config::get('mmcms.journal.mode') === true) {
            // Register journal entry helper
            $this->app->singleton('JournalEntryHelper', function ($app) {
                // Get current request IP
                $ip = $app['request']->ip();

                return new JournalEntryHelper($app->make('Thtg88\MmCms\Repositories\JournalEntryRepository'), $ip);
            });
        }

        $this->app->alias(MmCms::class, 'mmcms');
    }

    public function provides(): array
    {
        return ['mmcms'];
    }
}
