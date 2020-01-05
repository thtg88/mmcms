<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('target_id');
            $table->string('target_table');
            $table->string('facebook_description')->nullable();
            $table->string('facebook_image')->nullable();
            $table->string('facebook_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_robots_follow')->nullable();
            $table->string('meta_robots_index')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('page_title')->nullable();
            $table->string('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->string('twitter_title')->nullable();
            $table->text('json_schema')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->index('target_id');
            $table->index('target_table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_entries');
    }
}
