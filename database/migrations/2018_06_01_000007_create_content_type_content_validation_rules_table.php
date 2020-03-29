<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTypeContentValidationRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_type_content_validation_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('content_type_id');
            $table->unsignedInteger('content_validation_rule_id');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('content_type_id');
            $table->index('content_validation_rule_id', 'content_type_validation_rules_rule_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_type_content_validation_rules');
    }
}
