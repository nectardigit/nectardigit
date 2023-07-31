<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_guests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->enum('publish_status', ['0', '1'])->default('1')->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->bigInteger('oldId')->nullable();
            $table->enum('isOldData', ['0', '1'])->default('0');
            $table->string('image')->nullable();
            $table->string('path')->nullable();
            $table->string('organization')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('slug_url')->nullable()->index();
            
            $table->string('facebook')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('guest_description')->nullable();
            $table->string('guest_caption')->nullable();
            $table->string('slug')->nullable()->index();
            $table->string('twitter')->nullable();
            $table->timestamps();
            $table->softDeletes()->index();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_guests');
    }
}
