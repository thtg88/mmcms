<?php

namespace Thtg88\MmCms\Listeners;

use Thtg88\MmCms\Events\ContentFieldStored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\Filesystem;

class MakeContentFieldMigration
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
     * @param  ContentFieldStored  $event
     * @return void
     */
    public function handle(ContentFieldStored $event)
    {
        $table_name = $event->content_field->content_model->table_name;
        $migration_name = 'add_'.$event->content_field->name.'_column_to_'.$table_name.'_table';

        // We check if we have already a migration with the same name
        $migration = \DB::table('migrations')
            ->where('migration', 'like', '%'.$migration_name.'%')
            ->first();

        if($migration === null)
        {
            // If migration N/A we make it
            \Artisan::call('make:migration', [
                'name' => $migration_name,
                '--table' => $table_name,
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
                        $search_content = '';
                        $search_content .= "public function up()\n";
                        $search_content .= "    {\n";
                        $search_content .= "        Schema::table('blog_posts', function (Blueprint \$table) {\n";
                        $search_content .= "            //";

                        $replace_content = '';
                        $replace_content .= "public function up()\n";
                        $replace_content .= "    {\n";
                        $replace_content .= "         Schema::table('blog_posts', function (Blueprint \$table) {\n";
                        $replace_content .= "            \$table->".$event->content_field->content_type->content_migration_method->name;
                        $replace_content .= "('".$event->content_field->name."')->nullable();";

                        $last_migration_content = str_replace($search_content, $replace_content, $last_migration_content);

                        $search_content = '';
                        $search_content .= "public function down()\n";
                        $search_content .= "    {\n";
                        $search_content .= "        Schema::table('blog_posts', function (Blueprint \$table) {\n";
                        $search_content .= "            //";

                        $replace_content = '';
                        $replace_content .= "public function down()\n";
                        $replace_content .= "    {\n";
                        $replace_content .= "         Schema::table('blog_posts', function (Blueprint \$table) {\n";
                        $replace_content .= "            \$table->dropColumn('".$event->content_field->name."');";

                        $last_migration_content = str_replace($search_content, $replace_content, $last_migration_content);

                        file_put_contents($last_migration, $last_migration_content);
                    }
                }
            }
        }
    }
}
