<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTagsTable extends Migration
{
    public function up()
    {
        Schema::create('news_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('newsId')->nullable();
            $table->unsignedBigInteger('tagId')->nullable();
            $table->timestamps();
            $table->foreign('newsId')->references('id')->on('news')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('tagId')->references('id')->on('tags')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_tags');
    }
}
