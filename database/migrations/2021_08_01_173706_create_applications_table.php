<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('careerId');
            $table->string('mobile');
            $table->string('email');
            $table->string('verificationCode')->nullable();
            $table->boolean('verified')->default(false);
            $table->longText('description')->nullable();
            $table->string('documents')->nullable();
            $table->timestamps();
            $table->foreign('careerId')->on('careers')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
