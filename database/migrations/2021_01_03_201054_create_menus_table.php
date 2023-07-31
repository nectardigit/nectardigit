<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->string('slug')->nullable();
            $table->bigInteger('oldId')->nullable();
            $table->mediumInteger('position')->default(100);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->enum('isOldData', ['0', '1'])->default('0');
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('external_url')->nullable();
            $table->string('featured_img')->nullable();
            // $table->string('featured_img_path')->nullable();
            $table->string('parallex_img')->nullable();
            // $table->string('parallex_img_path')->nullable();
            $table->string('show_on')->nullable()->index();
            $table->string('content_type')->nullable();
            $table->string('news_section')->nullable();
            $table->enum('publish_status', ['0', '1'])->default(1)->index();
            $table->mediumInteger('side_position')->default(100);
            $table->text('meta_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyphrase')->nullable();
            $table->timestamps();
            $table->softDeletes()->index();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
