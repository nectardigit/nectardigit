<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsCategoryCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_category_counters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('newsId')->nullable();
            $table->unsignedBigInteger('categoryId')->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('count')->nullable();
            $table->timestamps();
            $table->foreign('newsId')->references('id')->on('news')->onDelete("CASCADE")->onUpdate('CASCADE');
            $table->foreign('categoryId')->references('id')->on('menus')->onDelete("CASCADE")->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_category_counters');
    }
}
