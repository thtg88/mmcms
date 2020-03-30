<?php

namespace Thtg88\MmCms;

use Illuminate\Container\Container;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Console\ClientCommand as PassportClientCommand;
use Laravel\Passport\Console\InstallCommand as PassportInstallCommand;
use Laravel\Passport\Console\KeysCommand as PassportKeysCommand;
use Thtg88\MmCms\Console\Commands\CreateDatabaseCommand;
use Thtg88\MmCms\Console\Commands\InstallCommand;
use Thtg88\MmCms\Console\Commands\PublishModuleCommand;
use Thtg88\MmCms\Console\Commands\Scaffold\RepositoryMakeCommand;
use Thtg88\MmCms\Helpers\JournalEntryHelper;
use Thtg88\MmCms\MmCms as MmCmsFacade;
use Thtg88\MmCms\Providers\CurrentTimeServiceProvider;
use Thtg88\MmCms\Validators\CustomValidator;

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

        // Register custom validator
        Validator::resolver(
            static function ($translator, $data, $rules, $messages) {
                return new CustomValidator(
                    $translator,
                    $data,
                    $rules,
                    $messages
                );
            }
        );

        // Config
        $this->publishes([
            __DIR__.'/../config/mmcms.php' => Container::getInstance()->configPath('mmcms.php'),
        ], 'mmcms-config');

        // Routes
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../database/migrations' => Container::getInstance()->databasePath('migrations'),
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
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateDatabaseCommand::class,
                InstallCommand::class,
                PublishModuleCommand::class,
                RepositoryMakeCommand::class,
                // The following need to be booted
                // to run the InstallCommand properly,
                // as the InstallCommand runs the passport install command
                PassportClientCommand::class,
                PassportInstallCommand::class,
                PassportKeysCommand::class,
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

    public function provides()
    {
        return ['mmcms'];
    }
}
