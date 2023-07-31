<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddToReadThisNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_to_read_this_news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('newsId')->nullable();
            $table->unsignedBigInteger('addedNewsId')->nullable();
            $table->timestamps();
            $table->foreign('newsId')->references('id')->on('news')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('addedNewsId')->references('id')->on('news')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_to_read_this_news');
    }
}
