<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->string('videoId')->nullable();
            $table->text('url')->nullable();
            $table->string('image')->nullable();
            $table->integer('position')->nullable();
            $table->enum('display_home', ['1', '0'])->nullable();
            $table->enum('origin', ['youtube', 'facebook'])->nullable();
            $table->longText('description')->nullable();
            $table->bigInteger('oldId')->nullable();
            $table->enum('isOldData', ['0', '1'])->default('0');



            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->boolean('publish_status')->default(true);
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
