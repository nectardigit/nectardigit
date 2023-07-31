<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryAdvertisementPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_advertisement_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adPositionId')->nullable();
            $table->unsignedBigInteger('categoryId')->nullable();
            $table->timestamps();

            $table->foreign('adPositionId')->references('id')->on('advertisement_positions')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
        Schema::dropIfExists('category_advertisement_positions');
    }
}
