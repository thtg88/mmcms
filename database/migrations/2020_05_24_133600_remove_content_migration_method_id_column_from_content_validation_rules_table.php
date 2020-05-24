<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
