<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsMandatoryColumnToContentFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('content_fields', 'is_mandatory') === false) {
            Schema::table('content_fields', function (Blueprint $table) {
                $table->boolean('is_mandatory')->default(false)->before('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('content_fields', 'is_mandatory')) {
            Schema::table('content_fields', function (Blueprint $table) {
                $table->dropColumn('is_mandatory');
            });
        }
    }
}
