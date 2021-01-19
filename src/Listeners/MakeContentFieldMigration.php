<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Support\Facades\Artisan;
use Thtg88\MmCms\Events\ContentFieldStored;

class MakeContentFieldMigration
{
    use Concerns\WithExistingMigrationCheck;

    /**
     * Handle the event.
     *
     * @param \Thtg88\MmCms\Events\ContentFieldStored $event
     *
     * @return void
     */
    public function handle(ContentFieldStored $event)
    {
        $table_name = $event->content_field->content_model->table_name;
        $migration_name = 'add_'.$event->content_field->name.'_column_to_'.
            $table_name.'_table';

        // If migration N/A we make it
        Artisan::call('make:migration', [
            'name'    => $migration_name,
            '--table' => $table_name,
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

        $search_content = '';
        $search_content .= 'public function up()'.PHP_EOL;
        $search_content .= '    {'.PHP_EOL;
        $search_content .= "        Schema::table('".$table_name."', function (Blueprint \$table) {".PHP_EOL;
        $search_content .= '            //';

        $replace_content = '';
        $replace_content .= 'public function up()'.PHP_EOL;
        $replace_content .= '    {'.PHP_EOL;
        $replace_content .= "        Schema::table('".$table_name."', function (Blueprint \$table) {".PHP_EOL;
        $replace_content .= '            $table->'.$event->content_field->content_type->content_migration_method->name;
        $replace_content .= "('".$event->content_field->name."')->nullable();";

        $last_migration_content = str_replace(
            $search_content,
            $replace_content,
            $last_migration_content
        );

        $search_content = '';
        $search_content .= 'public function down()'.PHP_EOL;
        $search_content .= '    {'.PHP_EOL;
        $search_content .= "        Schema::table('".$table_name."', function (Blueprint \$table) {".PHP_EOL;
        $search_content .= '            //';

        $replace_content = '';
        $replace_content .= 'public function down()'.PHP_EOL;
        $replace_content .= '    {'.PHP_EOL;
        $replace_content .= "        Schema::table('".$table_name."', function (Blueprint \$table) {".PHP_EOL;
        $replace_content .= "            \$table->dropColumn('".$event->content_field->name."');";

        $last_migration_content = str_replace(
            $search_content,
            $replace_content,
            $last_migration_content
        );

        file_put_contents($last_migration, $last_migration_content);
    }
}
