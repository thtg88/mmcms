<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Thtg88\MmCms\Events\ContentFieldStored;

class MakeContentFieldMigration
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
     * @param \Thtg88\MmCms\Events\ContentFieldStored $event
     * @return void
     */
    public function handle(ContentFieldStored $event)
    {
        $table_name = $event->content_field->content_model->table_name;
        $migration_name = 'add_'.$event->content_field->name.'_column_to_'.
            $table_name.'_table';

        // If migration N/A we make it
        Artisan::call('make:migration', [
            'name' => $migration_name,
            '--table' => $table_name,
        ]);

        // Then we get the last migration so we can insert our custom fields
        $migrations = $this->filesystem
            ->files(Container::getInstance()->databasePath('migrations'));

        if (count($migrations) === 0) {
            return;
        }

        // Cast to string by appending an empty string
        $last_migration = $migrations[count($migrations) - 1].'';

        if (strpos($last_migration, $migration_name) === false) {
            return;
        }

        $last_migration_content = file_get_contents($last_migration);

        if ($last_migration_content === false) {
            return;
        }

        $search_content = '';
        $search_content .= "public function up()".PHP_EOL;
        $search_content .= "    {".PHP_EOL;
        $search_content .= "        Schema::table('".$table_name."', function (Blueprint \$table) {".PHP_EOL;
        $search_content .= "            //";

        $replace_content = '';
        $replace_content .= "public function up()".PHP_EOL;
        $replace_content .= "    {".PHP_EOL;
        $replace_content .= "         Schema::table('".$table_name."', function (Blueprint \$table) {".PHP_EOL;
        $replace_content .= "            \$table->".$event->content_field->content_type->content_migration_method->name;
        $replace_content .= "('".$event->content_field->name."')->nullable();";

        $last_migration_content = str_replace(
            $search_content,
            $replace_content,
            $last_migration_content
        );

        $search_content = '';
        $search_content .= "public function down()".PHP_EOL;
        $search_content .= "    {".PHP_EOL;
        $search_content .= "        Schema::table('".$table_name."', function (Blueprint \$table) {".PHP_EOL;
        $search_content .= "            //";

        $replace_content = '';
        $replace_content .= "public function down()".PHP_EOL;
        $replace_content .= "    {".PHP_EOL;
        $replace_content .= "         Schema::table('".$table_name."', function (Blueprint \$table) {".PHP_EOL;
        $replace_content .= "            \$table->dropColumn('".$event->content_field->name."');";

        $last_migration_content = str_replace(
            $search_content,
            $replace_content,
            $last_migration_content
        );

        file_put_contents($last_migration, $last_migration_content);
    }
}
