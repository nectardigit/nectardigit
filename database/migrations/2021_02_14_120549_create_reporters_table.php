<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
           
            $table->string('phone')->nullable();
            $table->bigInteger('oldId')->nullable();
            $table->enum('isOldData', ['0', '1'])->default('0');
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('address')->nullable();
            $table->string('slug_url')->nullable();
            $table->string('designation')->nullable();
            $table->string('caption')->nullable();
            $table->text('description')->nullable();
            $table->string('profile_image_url')->nullable();
            $table->boolean('allow_to_login')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('publish_status')->default(false)->index();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes()->index();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reporters');
    }
}
