<?php

namespace Thtg88\MmCms;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
// Passport Commmands
use Laravel\Passport\Console\ClientCommand as PassportClientCommand;
use Laravel\Passport\Console\InstallCommand as PassportInstallCommand;
use Laravel\Passport\Console\KeysCommand as PassportKeysCommand;
// MmCms Imports
use Thtg88\MmCms\Console\Commands\InstallCommand;
use Thtg88\MmCms\Console\Commands\PublishModuleCommand;
use Thtg88\MmCms\Console\Commands\RepositoryMakeCommand;
use Thtg88\MmCms\Helpers\JournalEntryHelper;
use Thtg88\MmCms\MmCms as MmCmsFacade;
use Thtg88\MmCms\Providers\CurrentTimeServiceProvider;

class MmCmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('MmCms', MmCmsFacade::class);

        $this->app->singleton('mmcms', function () {
            return new MmCms();
        });

        // Config
        $this->publishes([
            __DIR__.'/../config/mmcms.php' => config_path('mmcms.php'),
        ], 'mmcms-config');

        // Routes
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'mmcms-migrations');

        // Translations
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'mmcms');
        // $this->publishes([
        //     __DIR__.'/../resources/lang' => resource_path('lang/vendor/mmcms'),
        // ], 'translations');

        // Views
        // $this->loadViewsFrom(__DIR__.'/../views', 'mmcms');
        // $this->publishes([
        //     __DIR__.'/../reousrces/views' => resource_path('views/vendor/mmcms'),
        // ], 'views');

        // Commands
        if ($this->app->runningInConsole())
        {
            $this->commands([
                InstallCommand::class,
                PassportClientCommand::class,
                PassportInstallCommand::class,
                PassportKeysCommand::class,
                PublishModuleCommand::class,
                RepositoryMakeCommand::class,
            ]);
        }

        $this->commands([
            RepositoryMakeCommand::class,
        ]);

        // Assets
        // $this->publishes([
        //     __DIR__.'/../reousrces/assets' => public_path('vendor/mmcms'),
        // ], 'assets');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(CurrentTimeServiceProvider::class);

        $this->mergeConfigFrom( __DIR__.'/../config/mmcms.php', 'mmcms');

        $this->app->singleton(MmCms::class, function () {
            return new MmCms();
        });

        if(config('mmcms.journal.mode') === true)
	    {
		    // Register journal entry helper
	        $this->app->singleton('JournalEntryHelper', function($app) {
		        // Get current request IP
		        $ip = $app['request']->ip();

		        return new JournalEntryHelper($app->make('Thtg88\MmCms\Repositories\JournalEntryRepository'), $ip);
			});
	    }

        $this->app->alias(MmCms::class, 'mmcms');
    }

    public function provides()
    {
        return ['mmcms'];
    }
}
