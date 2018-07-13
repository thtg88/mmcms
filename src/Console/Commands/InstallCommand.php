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

    protected $seedersPath = __DIR__.'/../../../database/seeds/';

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

        // Migrating the database tables into your application
        $this->info('Migrating the database tables into your application');
        $this->call('migrate');

        // Installing Laravel Passport
        $this->info('Installing Laravel Passport');
        $this->call('passport:install', [
            '--force' => true,
        ]);

        // Attempting to set mmCMS User model as parent to App\User
        $this->info('Attempting to set mmCMS User model as parent to App\User');
        $this->extendUserModel();

        // Dumping the autoloaded files and reloading all new files
        $this->info('Dumping the autoloaded files and reloading all new files');
        $this->dumpComposerAutoload();

        $this->info('Adding Exception renderers');
        $this->addExceptionRenderers();

        // // Adding routes to api.php
        // $this->info('Adding mmCMS routes to routes/api.php');
        // $this->addRoutes($filesystem);
        // \MmCms::routes();

        $this->info('Seeding data into the database');
        $this->seed('MmCmsDatabaseSeeder');

        $this->info('Adding the storage symlink to your public folder');
        $this->call('storage:link');

        $this->info('Successfully installed mmCMS, enjoy!');
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    private function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar'))
        {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
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
        if (file_exists(app_path('User.php')))
        {
            $str = file_get_contents(app_path('User.php'));

            if ($str !== false)
            {
                $str = str_replace('extends Authenticatable', "extends \Thtg88\MmCms\Models\User", $str);
                $str = str_replace('use Notifiable;', 'use HasApiTokens, Notifiable;', $str);

                file_put_contents(app_path('User.php'), $str);
            }
        }
        else
        {
            $this->warn('Unable to locate "app/User.php". Did you move this file?');
            $this->warn('You will need to update this manually. Change "extends Authenticatable" to "extends \Thtg88\MmCms\Models\User" in your User model');
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
     * Add JSON-specific exception renderers.
     *
     * @return  void
     */
    private function addExceptionRenderers()
    {
        // Adding Exception handlers
        $str = file_get_contents(app_path('Exceptions/Handler.php'));
        if (
            $str !== false
            && strpos($str, 'use Symfony\Component\HttpKernel\Exception\HttpException;') === false
            && strpos($str, 'use Exception;') !== false
            && strpos($str, 'return parent::render($request, $exception);') !== false
        )
        {
            // Adding imports
            $imports_str = "use Exception;\n";
            $imports_str .= "use Illuminate\Auth\AuthenticationException;\n";
            $imports_str .= "use Illuminate\Auth\Access\AuthorizationException;\n";
            $imports_str .= "use Symfony\Component\HttpKernel\Exception\HttpException;\n";
            $imports_str .= "use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;\n";
            $imports_str .= "use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;\n";
            $str = str_replace("use Exception;", $imports_str, $str);

            // Adding content
            $render_str = 'if($exception instanceof NotFoundHttpException)'."\n";
            $render_str .= "\t\t".'{'."\n";
            $render_str .= "\t\t\t".'$msg = $exception->getMessage() ?: "Resource not found.";'."\n";
            $render_str .= "\t\t\t".'return response()->json(["errors" => ["resource_not_found" => [$msg]]], 404);'."\n";
            $render_str .= "\t\t".'}'."\n";
            $render_str .= "\t\t".'else if($exception instanceof AuthorizationException)'."\n";
            $render_str .= "\t\t".'{'."\n";
            $render_str .= "\t\t\t".'$msg = $exception->getMessage() ?: "Forbidden.";'."\n";
            $render_str .= "\t\t\t".'return response()->json(["errors" => ["forbidden" => [$msg]]], 403);'."\n";
            $render_str .= "\t\t".'}'."\n";
            $render_str .= "\t\t".'else if($exception instanceof AuthenticationException)'."\n";
            $render_str .= "\t\t".'{'."\n";
            $render_str .= "\t\t\t".'$msg = $exception->getMessage() ?: "Unauthenticated.";'."\n";
            $render_str .= "\t\t\t".'return response()->json(["errors" => ["unauthenticated" => [$msg]]], 403);'."\n";
            $render_str .= "\t\t".'}'."\n";
            $render_str .= "\t\t".'else if($exception instanceof MethodNotAllowedHttpException)'."\n";
            $render_str .= "\t\t".'{'."\n";
            $render_str .= "\t\t\t".'return response()->json(["errors" => ["method_not_allowed" => ["Method not allowed."]]], 405);'."\n";
            $render_str .= "\t\t".'}'."\n";
            $render_str .= "\t\t".'else if($exception instanceof HttpException)'."\n";
            $render_str .= "\t\t".'{'."\n";
            $render_str .= "\t\t\t".'if($exception->getStatusCode() == 403)'."\n";
            $render_str .= "\t\t\t".'{'."\n";
            $render_str .= "\t\t\t\t".'$msg = $exception->getMessage() ?: "Forbidden.";'."\n";
            $render_str .= "\t\t\t\t".'return response()->json(["errors" => ["forbidden" => [$msg]]], 403);'."\n";
            $render_str .= "\t\t\t".'}'."\n";
            $render_str .= "\t\t\t".'if($exception->getStatusCode() == 401)'."\n";
            $render_str .= "\t\t\t".'{'."\n";
            $render_str .= "\t\t\t\t".'$msg = $exception->getMessage() ?: "Unauthorized.";'."\n";
            $render_str .= "\t\t\t\t".'return response()->json(["errors" => ["unauthorized" => [$msg]]], 403);'."\n";
            $render_str .= "\t\t\t".'}'."\n";
            $render_str .= "\t\t".'}'."\n";
            $render_str .= "\t\t".'return parent::render($request, $exception);';

            $str = str_replace('return parent::render($request, $exception);', $render_str, $str);

            file_put_contents(app_path('Exceptions/Handler.php'), $str);
        }
    }
}
