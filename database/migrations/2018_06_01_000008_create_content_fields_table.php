<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('content_model_id');
            $table->unsignedInteger('content_type_id');
            $table->string('name');
            $table->string('display_name');
            $table->text('helper_text')->nullable();
            $table->boolean('is_resource_name')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('content_model_id');
            $table->index('content_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_fields');
    }
}
