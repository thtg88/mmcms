<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Thtg88\MmCms\Events\ContentModelStored;

class MakeContentModelMigration
{
    /**
     * The file system implementation.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Handle the event.
     *
     * @param \Thtg88\MmCms\Events\ContentModelStored $event
     * @return void
     */
    public function handle(ContentModelStored $event)
    {
        $table_name = $event->content_model->table_name;
        $migration_name = 'create_'.$table_name.'_table';

        // We check if we have already a migration with the same name
        $migration = DB::table('migrations')
            ->where('migration', 'like', '%'.$migration_name.'%')
            ->first();

        if ($migration !== null) {
            return;
        }

        // If migration N/A we make it
        Artisan::call('make:migration', [
            'name' => $migration_name,
            '--create' => $table_name,
        ]);

        // Then we get the last migration so we can insert our custom fields
        $migrations = $this->filesystem
            ->files(Container::getInstance()->databasePath('migrations'));

        if (count($migrations) === 0) {
            return;
        }

        // Force it to string by appending an empty one at the end
        $last_migration = $migrations[count($migrations) - 1].'';

        if (strpos($last_migration, $migration_name) === false) {
            return;
        }

        $last_migration_content = file_get_contents($last_migration);

        if ($last_migration_content === false) {
            return;
        }

        $replace_content = '';
        $replace_content .= "\$table->timestamp('deleted_at')->nullable();\n";
        $replace_content .= "            \$table->timestamp('created_at')->nullable();\n";
        $replace_content .= "            \$table->timestamp('updated_at')->nullable();";

        $last_migration_content = str_replace(
            '$table->timestamps();',
            $replace_content,
            $last_migration_content
        );

        file_put_contents(
            $last_migration,
            $last_migration_content
        );
    }
}
