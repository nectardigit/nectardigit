<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oldId')->nullable() ;
            $table->unsignedBigInteger('newsId')->nullable()->index();
            $table->unsignedBigInteger('categoryId')->nullable()->index();
            $table->timestamps();

            $table->foreign('newsId')->references('id')->on('news')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('categoryId')->references('id')->on('menus')->onUpdate('CASCADE')->onDelete('RESTRICT');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_categories');
    }
}
