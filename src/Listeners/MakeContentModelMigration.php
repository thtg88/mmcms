<?php

namespace Thtg88\MmCms\Listeners;

use Thtg88\MmCms\Events\ContentModelStored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\Filesystem;

class MakeContentModelMigration
{
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
     * @param  ContentModelStored  $event
     * @return void
     */
    public function handle(ContentModelStored $event)
    {
        $migration_name = 'create_'.$event->content_model->table_name.'_table';

        // We check if we have already a migration with the same name
        $migration = \DB::table('migrations')
            ->where('migration', 'like', '%'.$migration_name.'%')
            ->first();

        if($migration === null)
        {
            // If migration N/A we make it
            \Artisan::call('make:migration', [
                'name' => 'create_'.$event->content_model->table_name.'_table',
                '--create' => $event->content_model->table_name,
            ]);

            // The nwe get the last migration so we can insert our custom fields
            $migrations = $this->filesystem->files(database_path('migrations'));

            if(count($migrations) > 0)
            {
                $last_migration = $migrations[count($migrations) - 1].'';

                if(strpos($last_migration, $migration_name) !== FALSE)
                {
                    $last_migration_content = file_get_contents($last_migration);

                    if($last_migration_content !== false)
                    {
                        $replace_content = '';
                        $replace_content .= "\$table->timestamp('deleted_at')->nullable();\n";
                        $replace_content .= "            \$table->timestamp('created_at')->nullable();\n";
                        $replace_content .= "            \$table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));";

                        $last_migration_content = str_replace('$table->timestamps();', $replace_content, $last_migration_content);

                        file_put_contents($last_migration, $last_migration_content);
                    }
                }
            }
        }
    }
}
