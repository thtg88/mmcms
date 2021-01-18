<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentFieldContentValidationRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_field_content_validation_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('content_field_id');
            $table->unsignedInteger('content_validation_rule_id');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('content_field_id');
            $table->index('content_validation_rule_id', 'content_field_validation_rules_rule_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_field_content_validation_rules');
    }
}
