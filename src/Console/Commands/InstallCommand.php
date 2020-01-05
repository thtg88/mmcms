<?php

namespace Thtg88\MmCms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Thtg88\MmCms\MmCmsServiceProvider;
use Thtg88\MmCms\Traits\Seedable;
use Laravel\Passport\PassportServiceProvider;

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

    public function fire(Filesystem $filesystem)
    {
        return $this->handle($filesystem);
    }

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        // Publish only relevant resources on install
        $this->info('Publishing the mmCMS assets, database, and config files');
        $this->publishVendorTags();

        if (empty(config('app.key'))) {
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
        $this->addPassportRoutes($filesystem);

        $this->info('Configuring Anhskohbo NoCaptcha');
        $this->call('vendor:publish', [
            '--provider' => 'Anhskohbo\NoCaptcha\NoCaptchaServiceProvider'
        ]);

        $this->info('Configuring Barryvdh Laravel CORS');
        $this->call('vendor:publish', [
            '--provider' => 'Barryvdh\Cors\ServiceProvider'
        ]);
        $this->addLaravelCorsMiddleware($filesystem);

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
     * @return  void
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
        $this->call('vendor:publish', ['--provider' => MmCmsServiceProvider::class, '--tag' => $tags]);
        $this->call('vendor:publish', ['--provider' => PassportServiceProvider::class, '--tag' => 'passport-migrations']);
    }

    /**
     * Extend the User model to mmCMS's.
     *
     * @return  void
     */
    private function extendUserModel()
    {
        // Check that file exists
        if (file_exists(app_path('User.php'))) {
            // Get model's content as string
            $str = file_get_contents(app_path('User.php'));

            if ($str !== false) {
                // Replace inherited class
                if (
                    strpos($str, 'extends \Thtg88\MmCms\Models\User') === false
                    && strpos($str, 'extends Authenticatable') !== false
                ) {
                    $str = str_replace('extends Authenticatable', "extends \Thtg88\MmCms\Models\User", $str);
                }
                // Replace traits
                if (
                    strpos($str, 'use \Laravel\Passport\HasApiTokens, Notifiable;') === false
                    && strpos($str, 'use Notifiable;') !== false
                ) {
                    $str = str_replace('use Notifiable;', 'use \Laravel\Passport\HasApiTokens, Notifiable;', $str);
                }

                file_put_contents(app_path('User.php'), $str);
            }
        } else {
            // Warn the user to do changes manually
            $this->warn('Unable to locate "app'.DIRECTORY_SEPARATOR.'User.php". Did you move this file?');
            $this->warn('You will need to update this manually.');
            $this->warn('Change "extends Authenticatable" to "extends \Thtg88\MmCms\Models\User",');
            $this->warn('and "use Notifiable;" to "use \Laravel\Passport\HasApiTokens, Notifiable;" in your User model');
        }
    }

    /**
     * Run "composer dump-autoload".
     *
     * @return  void
     */
    private function dumpComposerAutoload()
    {
        $composer = $this->findComposer();
        $process = new Process($composer.' dump-autoload');
        // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setTimeout(null);
        $process->setWorkingDirectory(base_path())->run();
    }

    /**
     * Add Laravel Passport routes.
     *
     * @param   \Illuminate\Filesystem\Filesystem   $filesystem
     * @return  void
     */
    private function addPassportRoutes(FileSystem $filesystem)
    {
        // Check that Auth service provider exists
        if (file_exists(app_path('Providers'.DIRECTORY_SEPARATOR.'AuthServiceProvider.php'))) {
            // Get Auth service provider content as string
            $str = file_get_contents(app_path('Providers'.DIRECTORY_SEPARATOR.'AuthServiceProvider.php'));

            if ($str !== false) {
                // Add Passport routes
                if (
                    strpos($str, 'Passport::routes();') === false
                    && strpos($str, '$this->registerPolicies();') !== false
                ) {
                    $passport_str = '$this->registerPolicies();'.PHP_EOL.PHP_EOL;
                    $passport_str .= "\t\t\Laravel\Passport\Passport::routes();";
                    $str = str_replace('$this->registerPolicies();', $passport_str, $str);
                }

                file_put_contents(app_path('Providers'.DIRECTORY_SEPARATOR.'AuthServiceProvider.php'), $str);
            }
        } else {
            // Warn the user to do changes manually
            $this->warn('Unable to locate "app'.DIRECTORY_SEPARATOR.'Providers'.DIRECTORY_SEPARATOR.'AuthServiceProvider.php". Did you move this file?');
            $this->warn('You will need to update this manually.');
            $this->warn('Add "\Laravel\Passport\Passport::routes();" after "$this->registerPolicies();" in the Auth service provider.');
        }
    }

    /**
     * Add Barryvdh Laravel CORS middleware.
     *
     * @param   \Illuminate\Filesystem\Filesystem   $filesystem
     * @return  void
     */
    private function addLaravelCorsMiddleware(FileSystem $filesystem)
    {
        // Check that HTTP Kernel exists
        if (file_exists(app_path('Http'.DIRECTORY_SEPARATOR.'Kernel.php'))) {
            // Get HTTP kernel content as string
            $str = file_get_contents(app_path('Http'.DIRECTORY_SEPARATOR.'Kernel.php'));

            // Replace middleware import for all routes
            if (
                $str !== false
                && strpos($str, '\Barryvdh\Cors\HandleCors::class,') === false
                && strpos($str, 'protected $middleware = [') !== false
            ) {
                $middleware_str = 'protected $middleware = ['.PHP_EOL;
                $middleware_str .= "\t\t\Barryvdh\Cors\HandleCors::class,";
                $str = str_replace('protected $middleware = [', $middleware_str, $str);

                file_put_contents(app_path('Http'.DIRECTORY_SEPARATOR.'Kernel.php'), $str);
            }
        } else {
            // Warn the suer of the manual change needed
            $this->warn('Unable to locate "app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Kernel.php". Did you move this file?');
            $this->warn('You will need to update this manually.');
            $this->warn('Add "\Barryvdh\Cors\HandleCors::class," after "protected $middleware = [" in the HTTP kernel.');
        }
    }

    /**
     * Add JSON-specific exception renderers.
     *
     * @return  void
     */
    private function addExceptionRenderers()
    {
        // Check that exception handler is in the standard Laravel place
        if (file_exists(app_path('Exceptions'.DIRECTORY_SEPARATOR.'Handler.php'))) {
            // Get exceptions handler content as string
            $str = file_get_contents(app_path('Exceptions'.DIRECTORY_SEPARATOR.'Handler.php'));

            if (
                $str !== false
                && strpos($str, 'if($exception->getStatusCode() == 403)') === false
                && strpos($str, 'return parent::render($request, $exception);') !== false
            ) {
                // Adding content
                $render_str = 'if($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)'.PHP_EOL;
                $render_str .= "\t\t".'{'.PHP_EOL;
                $render_str .= "\t\t\t".'$msg = $exception->getMessage() ?: "Resource not found.";'.PHP_EOL;
                $render_str .= "\t\t\t".'return response()->json(["errors" => ["resource_not_found" => [$msg]]], 404);'.PHP_EOL;
                $render_str .= "\t\t".'}'.PHP_EOL;
                $render_str .= "\t\t".'else if($exception instanceof \Illuminate\Auth\Access\AuthorizationException)'.PHP_EOL;
                $render_str .= "\t\t".'{'.PHP_EOL;
                $render_str .= "\t\t\t".'$msg = $exception->getMessage() ?: "Forbidden.";'.PHP_EOL;
                $render_str .= "\t\t\t".'return response()->json(["errors" => ["forbidden" => [$msg]]], 403);'.PHP_EOL;
                $render_str .= "\t\t".'}'.PHP_EOL;
                $render_str .= "\t\t".'else if($exception instanceof \Illuminate\Auth\AuthenticationException)'.PHP_EOL;
                $render_str .= "\t\t".'{'.PHP_EOL;
                $render_str .= "\t\t\t".'$msg = $exception->getMessage() ?: "Unauthenticated.";'.PHP_EOL;
                $render_str .= "\t\t\t".'return response()->json(["errors" => ["unauthenticated" => [$msg]]], 403);'.PHP_EOL;
                $render_str .= "\t\t".'}'.PHP_EOL;
                $render_str .= "\t\t".'else if($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException)'.PHP_EOL;
                $render_str .= "\t\t".'{'.PHP_EOL;
                $render_str .= "\t\t\t".'return response()->json(["errors" => ["method_not_allowed" => ["Method not allowed."]]], 405);'.PHP_EOL;
                $render_str .= "\t\t".'}'.PHP_EOL;
                $render_str .= "\t\t".'else if($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException)'.PHP_EOL;
                $render_str .= "\t\t".'{'.PHP_EOL;
                $render_str .= "\t\t\t".'if($exception->getStatusCode() == 403)'.PHP_EOL;
                $render_str .= "\t\t\t".'{'.PHP_EOL;
                $render_str .= "\t\t\t\t".'$msg = $exception->getMessage() ?: "Forbidden.";'.PHP_EOL;
                $render_str .= "\t\t\t\t".'return response()->json(["errors" => ["forbidden" => [$msg]]], 403);'.PHP_EOL;
                $render_str .= "\t\t\t".'}'.PHP_EOL;
                $render_str .= "\t\t\t".'if($exception->getStatusCode() == 401)'.PHP_EOL;
                $render_str .= "\t\t\t".'{'.PHP_EOL;
                $render_str .= "\t\t\t\t".'$msg = $exception->getMessage() ?: "Unauthorized.";'.PHP_EOL;
                $render_str .= "\t\t\t\t".'return response()->json(["errors" => ["unauthorized" => [$msg]]], 403);'.PHP_EOL;
                $render_str .= "\t\t\t".'}'.PHP_EOL;
                $render_str .= "\t\t".'}'.PHP_EOL;
                $render_str .= "\t\t".'return parent::render($request, $exception);';

                $str = str_replace('return parent::render($request, $exception);', $render_str, $str);

                file_put_contents(app_path('Exceptions'.DIRECTORY_SEPARATOR.'Handler.php'), $str);
            }
        } else {
            // Warn user of the manual changes needed
            $this->warn('Unable to locate "app'.DIRECTORY_SEPARATOR.'Exceptions'.DIRECTORY_SEPARATOR.'Handler.php". Did you move this file?');
            $this->warn('You will need to update this manually in order for the exceptions to be caught and converted into JSON.');
        }
    }

    /**
     * Set Auth driver as Passport in config.
     *
     * @return  void
     */
    private function setPassportAuthDriver(Filesystem $filesystem)
    {
        // Check that auth config is in the standard Laravel place
        if (file_exists(config_path('auth.php'))) {
            // Get auth config content as string
            $str = file_get_contents(config_path('auth.php'));

            if (
                $str !== false
                && (
                    strpos($str, "'api' => [".PHP_EOL."            'driver' => 'token',") !== false
                    || strpos($str, "'api' => [".PHP_EOL."\t\t\t'driver' => 'token',") !== false
                )
                && strpos($str, "'api' => [".PHP_EOL."            'driver' => 'passport',") === false
                && strpos($str, "'api' => [".PHP_EOL."\t\t\t'driver' => 'passport',") === false
            ) {
                $replace_str = "'api' => [".PHP_EOL."\t\t\t'driver' => 'passport',";

                $str = str_replace("'api' => [".PHP_EOL."            'driver' => 'token',", $replace_str, $str);
                $str = str_replace("'api' => [".PHP_EOL."\t\t\t'driver' => 'token',", $replace_str, $str);

                file_put_contents(config_path('auth.php'), $str);
            }
        } else {
            // Warn user of the manual changes needed
            $this->warn('Unable to locate "config'.DIRECTORY_SEPARATOR.'auth.php". Did you move this file?');
            $this->warn("Make sure you have ['guards']['api']['driver'] set to 'passport'.");
        }
    }

    /**
     * Create .htaccess in root directory.
     *
     * @return  void
     */
    private function createHtaccess()
    {
        if (file_exists(base_path('.htaccess'))) {
            // Warn user that file already exists
            $this->info('htaccess file already exists, skipping...');
        } else {
            // Create .htaccess file
            $str = "";
            $str .= "<IfModule mod_rewrite.c>\n";
            $str .= "\tRewriteEngine on\n\n";
            $str .= "\tRewriteCond %{REQUEST_URI} !public/\n";
            $str .= "\tRewriteRule (.*) /public/$1 [L]\n";
            $str .= "</IfModule>\n";

            file_put_contents(base_path('.htaccess'), $str);
        }
    }
}
