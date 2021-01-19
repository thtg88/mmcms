<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveContentMigrationMethodIdColumnFromContentValidationRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (
            Schema::hasColumn(
                'content_validation_rules',
                'content_migration_method_id'
            )
        ) {
            Schema::table(
                'content_validation_rules',
                function (Blueprint $table) {
                    $table->dropColumn('content_migration_method_id');
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (
            Schema::hasColumn(
                'content_validation_rules',
                'content_migration_method_id'
            ) === false
        ) {
            Schema::table(
                'content_validation_rules',
                function (Blueprint $table) {
                    $table->unsignedInteger('content_migration_method_id')
                        ->nullable()
                        ->before('name');

                    $table->index('content_migration_method_id');
                }
            );
        }
    }
}
