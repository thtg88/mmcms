<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentValidationRuleAdditionalFieldValueOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_validation_rule_additional_field_value_options', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('content_validation_rule_additional_field_id');
            $table->string('text');
            $table->string('value')->nullable();
            $table->boolean('is_empty_option')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->index('content_validation_rule_additional_field_id', 'content_validation_rule_additional_field_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_validation_rule_additional_field_value_options');
    }
}
