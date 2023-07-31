<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_counters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('newsId')->nullable();
            $table->unsignedBigInteger('tagId')->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('count')->nullable();
            $table->timestamps();
            $table->foreign('newsId')->references('id')->on('news')->onDelete("CASCADE")->onUpdate('CASCADE');
            $table->foreign('tagId')->references('id')->on('tags')->onDelete("CASCADE")->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_counters');
    }
}
