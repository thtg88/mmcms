<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePriorityColumnFromContentValidationRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('content_validation_rules', 'priority')) {
            Schema::table(
                'content_validation_rules',
                function (Blueprint $table) {
                    $table->dropColumn('priority');
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
            Schema::hasColumn('content_validation_rules', 'priority') === false
        ) {
            Schema::table(
                'content_validation_rules',
                function (Blueprint $table) {
                    $table->unsignedInteger('priority')
                        ->nullable()
                        ->before('name');
                }
            );
        }
    }
}
