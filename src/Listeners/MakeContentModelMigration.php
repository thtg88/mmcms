<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Support\Facades\Artisan;
use Thtg88\MmCms\Events\ContentModelStored;

class MakeContentModelMigration
{
    use Concerns\WithExistingMigrationCheck;

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

        // If migration N/A we make it
        Artisan::call('make:migration', [
            'name' => $migration_name,
            '--create' => $table_name,
        ]);

        $migration_paths = $this->getMigrationPaths($migration_name);

        if (
            $migration_paths['migration_path'] !== $migration_paths['new_migration_path'] &&
            rename(
                $migration_paths['migration_path'],
                $migration_paths['new_migration_path']
            ) === false
        ) {
            return;
        }

        $last_migration = $migration_paths['new_migration_path'];

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
