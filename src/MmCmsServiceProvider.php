<?php

namespace Thtg88\MmCms;

use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
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
use Thtg88\MmCms\Models\ContentMigrationMethod;
use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Models\ImageCategory;
use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Models\SeoEntry;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Policies\ContentMigrationMethodPolicy;
use Thtg88\MmCms\Policies\ContentTypePolicy;
use Thtg88\MmCms\Policies\ImageCategoryPolicy;
use Thtg88\MmCms\Policies\RolePolicy;
use Thtg88\MmCms\Policies\SeoEntryPolicy;
use Thtg88\MmCms\Policies\UserPolicy;
use Thtg88\MmCms\Providers\CurrentTimeServiceProvider;

class MmCmsServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ContentMigrationMethod::class => ContentMigrationMethodPolicy::class,
        ContentType::class => ContentTypePolicy::class,
        ImageCategory::class => ImageCategoryPolicy::class,
        Role::class => RolePolicy::class,
        SeoEntry::class => SeoEntryPolicy::class,
        User::class => UserPolicy::class,
    ];

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

        // Commands
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

        // Assets
        // $this->publishes([
        //     __DIR__.'/../reousrces/assets' => public_path('vendor/mmcms'),
        // ], 'assets');

        $this->registerPolicies();
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

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies(): void
    {
        foreach ($this->policies() as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Get the policies defined on the provider.
     *
     * @return array
     */
    public function policies(): array
    {
        return $this->policies;
    }
}
