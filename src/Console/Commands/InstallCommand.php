<?php

namespace Thtg88\MmCms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Config;
use Laravel\Passport\PassportServiceProvider;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Thtg88\MmCms\MmCmsServiceProvider;
use Thtg88\MmCms\Traits\Seedable;

class InstallCommand extends Command
{
    use Seedable;

    protected $seedersPath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'seeds'.DIRECTORY_SEPARATOR.'';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mmcms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the mmCMS package';

    public function fire(): void
    {
        $this->handle();
    }

    /**
     * Execute the console command.
     *
     *
     * @return void
     */
    public function handle(): void
    {
        // Publish only relevant resources on install
        $this->info('Publishing the mmCMS assets, database, and config files');
        $this->publishVendorTags();

        if (empty(Config::get('app.key'))) {
            // Generate app key
            $this->info('Generating app key');
            $this->call('key:generate');
        } else {
            $this->info('App key already exists, skipping...');
        }

        // Migrating the database tables into your application
        // We force it for production server to work properly
        $this->info('Migrating the database tables into your application');
        $this->call('migrate', [
            '--force' => true,
        ]);

        // Installing Laravel Passport
        $this->info('Installing Laravel Passport');
        $this->call('passport:install', [
            '--force' => true,
        ]);

        $this->info('Configuring Laravel Passport');
        $this->addPassportRoutes();

        $this->info('Configuring Anhskohbo NoCaptcha');
        $this->call('vendor:publish', [
            '--provider' => 'Anhskohbo\NoCaptcha\NoCaptchaServiceProvider',
        ]);

        // Attempting to set mmCMS User model as parent to App\User
        $this->info('Attempting to set mmCMS User model as parent to App\User');
        $this->extendUserModel();

        $this->info('Adding Exception renderers');
        $this->addExceptionRenderers();

        $this->info('Seeding data into the database');
        $this->seed('MmCmsDatabaseSeeder');

        $this->info('Adding the storage symlink to your public folder');
        $this->call('storage:link');

        $this->info('Creating .htaccess for project root folder');
        $this->createHtaccess();

        // Dumping the autoloaded files and reloading all new files
        $this->info('Dumping the autoloaded files and reloading all new files');
        $this->dumpComposerAutoload();

        $this->info('Successfully installed mmCMS, enjoy!');
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    private function findComposer()
    {
        if (file_exists(getcwd().DIRECTORY_SEPARATOR.'composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().''.DIRECTORY_SEPARATOR.'composer.phar';
        }

        return 'composer';
    }

    /**
     * Publish the package vendor tags.
     *
     * @return void
     */
    private function publishVendorTags()
    {
        $tags = [
            'config',
            'migrations',
            'translations',
            'views',
            'assets'
        ];
        $this->call('vendor:publish', [
            '--provider' => MmCmsServiceProvider::class,
            '--tag' => $tags,
        ]);
        $this->call('vendor:publish', [
            '--provider' => PassportServiceProvider::class,
            '--tag' => 'passport-migrations',
        ]);
    }

    /**
     * Extend the User model to mmCMS's.
     *
     * @return void
     */
    private function extendUserModel()
    {
        // Check that file exists
        if (! file_exists(Container::getInstance()->path('User.php'))) {
            // Warn the user to do changes manually
            $this->warn('Unable to locate "app'.DIRECTORY_SEPARATOR.'User.php". Did you move this file?');
            $this->warn('You will need to update this manually.');
            $this->warn('Change "extends Authenticatable" to "extends \Thtg88\MmCms\Models\User",');
            $this->warn('and "use Notifiable;" to "use \Laravel\Passport\HasApiTokens, Notifiable;" in your User model');

            return;
        }

        // Get model's content as string
        $str = file_get_contents(Container::getInstance()->path('User.php'));

        if ($str === false) {
            return;
        }

        // Replace inherited class
        if (
            strpos($str, 'extends \Thtg88\MmCms\Models\User') === false
            && strpos($str, 'extends Authenticatable') !== false
        ) {
            $str = str_replace(
                'extends Authenticatable',
                "extends \Thtg88\MmCms\Models\User",
                $str
            );
        }

        // Replace traits
        if (
            strpos(
                $str,
                'use \Laravel\Passport\HasApiTokens, Notifiable;'
            ) === false
            && strpos($str, 'use Notifiable;') !== false
        ) {
            $str = str_replace(
                'use Notifiable;',
                'use \Laravel\Passport\HasApiTokens, Notifiable;',
                $str
            );
        }

        file_put_contents(Container::getInstance()->path('User.php'), $str);
    }

    /**
     * Run "composer dump-autoload".
     *
     * @return void
     */
    private function dumpComposerAutoload()
    {
        $composer = $this->findComposer();
        $process = new Process([$composer.' dump-autoload']);
        // Setting timeout to null
        // to prevent installation from stopping at a certain point in time
        $process->setTimeout(null);
        $process->setWorkingDirectory(Container::getInstance()->basePath())->run();
    }

    /**
     * Add Laravel Passport routes.
     *
     * @return void
     */
    private function addPassportRoutes()
    {
        // Check that Route service provider exists
        if (! file_exists(
            Container::getInstance()->path('Providers'.DIRECTORY_SEPARATOR.'RouteServiceProvider.php')
        )) {
            // Warn the user to do changes manually
            $this->warn('Unable to locate "app'.DIRECTORY_SEPARATOR.'Providers'.DIRECTORY_SEPARATOR.'RouteServiceProvider.php". Did you move this file?');
            $this->warn('You will need to update this manually.');
            $this->warn('Add "\Laravel\Passport\Passport::routes();" after "$this->registerPolicies();" in the Route service provider.');

            return;
        }

        // Get Route service provider content as string
        $str = file_get_contents(
            Container::getInstance()->path('Providers'.DIRECTORY_SEPARATOR.'RouteServiceProvider.php')
        );

        if ($str === false) {
            return;
        }

        // Add Passport routes
        if (
            strpos($str, 'Passport::routes();') === false
            && strpos($str, '$this->mapWebRoutes();') !== false
        ) {
            $passport_str = '$this->mapWebRoutes();'.PHP_EOL.PHP_EOL;
            $passport_str .= "        \Laravel\Passport\Passport::routes();";
            $str = str_replace('$this->mapWebRoutes();', $passport_str, $str);
        }

        file_put_contents(
            Container::getInstance()->path(
                'Providers'.DIRECTORY_SEPARATOR.'RouteServiceProvider.php'
            ),
            $str
        );
    }

    /**
     * Add JSON-specific exception renderers.
     *
     * @return void
     */
    private function addExceptionRenderers()
    {
        // Check that exception handler is in the standard Laravel place
        if (! file_exists(
            Container::getInstance()->path('Exceptions'.DIRECTORY_SEPARATOR.'Handler.php')
        )) {
            // Warn user of the manual changes needed
            $this->warn('Unable to locate "app'.DIRECTORY_SEPARATOR.'Exceptions'.DIRECTORY_SEPARATOR.'Handler.php". Did you move this file?');
            $this->warn('You will need to update this manually in order for the exceptions to be caught and converted into JSON.');

            return;
        }

        // Get exceptions handler content as string
        $str = file_get_contents(
            Container::getInstance()->path('Exceptions'.DIRECTORY_SEPARATOR.'Handler.php')
        );

        if (
            $str === false ||
            strpos(
                $str,
                'use Thtg88\MmCms\Exceptions\Handler as ExceptionHandler;'
            ) !== false
        ) {
            return;
        }

        // Adding content
        $str = str_replace(
            'use Throwable;',
            'use Thtg88\MmCms\Exceptions\Handler as ExceptionHandler;'.PHP_EOL.
                'use Throwable;',
            $str
        );
        $str = str_replace(
            'use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;',
            '',
            $str
        );

        file_put_contents(
            Container::getInstance()->path('Exceptions'.DIRECTORY_SEPARATOR.'Handler.php'),
            $str
        );
    }

    /**
     * Set Auth driver as Passport in config.
     *
     * @return void
     */
    private function setPassportAuthDriver()
    {
        // Check that auth config is in the standard Laravel place
        if (! file_exists(Container::getInstance()->configPath('auth.php'))) {
            // Warn user of the manual changes needed
            $this->warn('Unable to locate "config'.DIRECTORY_SEPARATOR.'auth.php". Did you move this file?');
            $this->warn("Make sure you have ['guards']['api']['driver'] set to 'passport'.");

            return;
        }

        // Get auth config content as string
        $str = file_get_contents(Container::getInstance()->configPath('auth.php'));

        if (
            $str === false ||
            strpos(
                $str,
                "'api' => [".PHP_EOL."            'driver' => 'token',"
            ) === false ||
            strpos(
                $str,
                "'api' => [".PHP_EOL."            'driver' => 'passport',"
            ) !== false
        ) {
            return;
        }

        $replace_str = "'api' => [".PHP_EOL.
            "            'driver' => 'passport',";

        $str = str_replace(
            "'api' => [".PHP_EOL."            'driver' => 'token',",
            $replace_str,
            $str
        );

        file_put_contents(Container::getInstance()->configPath('auth.php'), $str);
    }

    /**
     * Create .htaccess in root directory.
     *
     * @return void
     */
    private function createHtaccess()
    {
        if (file_exists(Container::getInstance()->basePath('.htaccess'))) {
            // Warn user that file already exists
            $this->info('htaccess file already exists, skipping...');

            return;
        }

        // Create .htaccess file
        $str = "";
        $str .= "<IfModule mod_rewrite.c>".PHP_EOL;
        $str .= "    RewriteEngine on".PHP_EOL.PHP_EOL;
        $str .= "    RewriteCond %{REQUEST_URI} !public/".PHP_EOL;
        $str .= "    RewriteRule (.*) /public/$1 [L]".PHP_EOL;
        $str .= "</IfModule>".PHP_EOL;

        file_put_contents(Container::getInstance()->basePath('.htaccess'), $str);
    }
}
