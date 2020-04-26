<?php

namespace Thtg88\MmCms\Listeners\Concerns;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;

trait WithExistingMigrationCheck
{
    protected function getMigrationPaths(string $migration_name): array
    {
        $format = 'Y_m_d_His';
        $datetime = new Carbon();
        $formatted_date = date($format);
        $date_string = $datetime->format($format);
        $migrations_path = Container::getInstance()->databasePath('migrations');

        $migration_path = $migrations_path.DIRECTORY_SEPARATOR.
            trim(str_replace('Created Migration: ', '', Artisan::output())).
            '.php';

        $migrations = app()->make(Filesystem::class)->files($migrations_path);

        $new_migration_path = $migration_path;

        foreach ($migrations as $_migration) {
            $migration_filename = $_migration->getFilename();

            if ($migration_path === $migration_filename) {
                continue;
            }

            while (strpos($migration_filename, $date_string) !== false) {
                $datetime = $datetime->copy()->addSeconds(1);
                $date_string = $datetime->format($format);
                $new_migration_path = $migrations_path.DIRECTORY_SEPARATOR.
                    $date_string.'_'.$migration_name.'.php';
            }
        }

        return [
            'migration_path' => $migration_path,
            'new_migration_path' => $new_migration_path,
        ];
    }
}
