<?php

namespace Thtg88\MmCms\Listeners;

use Thtg88\MmCms\Events\ContentFieldDestroyed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\Filesystem;

class MakeContentFieldDropColumnMigration
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
     * @param  ContentFieldDestroyed  $event
     * @return void
     */
    public function handle(ContentFieldDestroyed $event)
    {
        $table_name = $event->content_field->content_model->table_name;
        $migration_name = 'remove_'.$event->content_field->name.'_column_from_'.$table_name.'_table';

        // If migration N/A we make it
        \Artisan::call('make:migration', [
            'name' => $migration_name,
            '--table' => $table_name,
        ]);

        // Then we get the last migration so we can insert our custom fields
        $migrations = $this->filesystem->files(database_path('migrations'));

        if(count($migrations) > 0)
        {
            // We append te value with an empty string
            // so the file gets cast to one
            $last_migration = $migrations[count($migrations) - 1].'';

            if(strpos($last_migration, $migration_name) !== FALSE)
            {
                $last_migration_content = file_get_contents($last_migration);

                if($last_migration_content !== false)
                {
                    $search_content = '';
                    $search_content .= "public function up()\n";
                    $search_content .= "    {\n";
                    $search_content .= "        Schema::table('".$table_name."', function (Blueprint \$table) {\n";
                    $search_content .= "            //";

                    if($event->force === true)
                    {
                        // If we force the migration to drop the column
                        $replace_content = '';
                        $replace_content .= "public function up()\n";
                        $replace_content .= "    {\n";
                        $replace_content .= "         Schema::table('".$table_name."', function (Blueprint \$table) {\n";
                        $replace_content .= "            \$table->dropColumn('".$event->content_field->name."');";
                    }
                    else
                    {
                        // Otherwise we simply rename the column to preserve the data
                        // But first we check that the same column starting with underscore (_)
                        // Doesn't exist already, and if so, we drop it
                        $replace_content = '';
                        $replace_content .= "public function up()\n";
                        $replace_content .= "    {\n";
                        $replace_content .= "        if(Schema::hasColumn('".$table_name."', '_".$event->content_field->name."'))\n";
                        $replace_content .= "        {\n";
                        $replace_content .= "            Schema::table('".$table_name."', function (Blueprint \$table) {\n";
                        $replace_content .= "                \$table->dropColumn('_".$event->content_field->name."');\n";
                        $replace_content .= "            });\n";
                        $replace_content .= "        }\n\n";
                        $replace_content .= "        Schema::table('".$table_name."', function (Blueprint \$table) {\n";
                        $replace_content .= "            \$table->renameColumn('".$event->content_field->name."', '_".$event->content_field->name."');";
                    }

                    $last_migration_content = str_replace($search_content, $replace_content, $last_migration_content);

                    $search_content = '';
                    $search_content .= "public function down()\n";
                    $search_content .= "    {\n";
                    $search_content .= "        Schema::table('".$table_name."', function (Blueprint \$table) {\n";
                    $search_content .= "            //";

                    if($event->force === true)
                    {
                        // If we force the migration to drop the column
                        // The down method will re-create it
                        $replace_content = '';
                        $replace_content .= "public function down()\n";
                        $replace_content .= "    {\n";
                        $replace_content .= "         Schema::table('".$table_name."', function (Blueprint \$table) {\n";
                        $replace_content .= "            \$table->".$event->content_field->content_type->content_migration_method->name;
                        $replace_content .= "('".$event->content_field->name."')->nullable();";
                    }
                    else
                    {
                        $replace_content = '';
                        $replace_content .= "public function down()\n";
                        $replace_content .= "    {\n";
                        $replace_content .= "        Schema::table('".$table_name."', function (Blueprint \$table) {\n";
                        $replace_content .= "            \$table->renameColumn('_".$event->content_field->name."', '".$event->content_field->name."');";
                    }

                    $last_migration_content = str_replace($search_content, $replace_content, $last_migration_content);

                    file_put_contents($last_migration, $last_migration_content);
                }
            }
        }
    }
}
