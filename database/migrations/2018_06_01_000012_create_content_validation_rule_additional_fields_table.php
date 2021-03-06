<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentValidationRuleAdditionalFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_validation_rule_additional_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('content_validation_rule_id');
            $table->unsignedInteger('content_validation_rule_additional_field_type_id');
            $table->string('display_name');
            $table->string('name');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('content_validation_rule_id', 'content_validation_rule_id_index');
            $table->index('content_validation_rule_additional_field_type_id', 'content_validation_rule_additional_field_type_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_validation_rule_additional_fields');
    }
}
