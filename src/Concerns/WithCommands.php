<?php

namespace Thtg88\MmCms\Concerns;

use Laravel\Passport\Console\ClientCommand as PassportClientCommand;
use Laravel\Passport\Console\InstallCommand as PassportInstallCommand;
use Laravel\Passport\Console\KeysCommand as PassportKeysCommand;
use Thtg88\MmCms\Console\Commands\InstallCommand;
use Thtg88\MmCms\Console\Commands\PublishModuleCommand;
use Thtg88\MmCms\Console\Commands\SeedCommand;

trait WithCommands
{
    /**
     * Register the application's commands.
     *
     * @return void
     */
    public function bootCommands(): void
    {
        // Commands
        $this->commands([
            InstallCommand::class,
            PublishModuleCommand::class,
            SeedCommand::class,
            // The following need to be booted
            // to run the InstallCommand properly,
            // as the InstallCommand runs the passport install command
            PassportClientCommand::class,
            PassportInstallCommand::class,
            PassportKeysCommand::class,
        ]);
    }
}
