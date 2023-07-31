<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->string('columnType')->nullable();
            $table->string('page')->nullable();
            $table->unsignedBigInteger('section')->nullable();
            $table->unsignedBigInteger('order')->nullable();
            $table->string('organization')->nullable();
            $table->enum('show_on', ['app', 'web', 'all'])->default('all');
            $table->string('url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('path')->nullable()->comment('image path after uploads');
            $table->dateTime('from_date')->nullable();
            $table->dateTime('to_date')->nullable();
            $table->string('direction', 20)->nullable()->comment('top, right, bottom, left');
            $table->unsignedBigInteger('position')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->integer('view_count')->nullable();
            $table->enum('publish_status', ['0', '1'])->default('1')->index();

            $table->bigInteger('oldId')->nullable();
            $table->enum('isOldData', ['0', '1'])->default('0');
            $table->string('img_url')->nullable();
          

            $table->string('img_url_app')->nullable();
            
        


            $table->softDeletes()->index();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
        DB::update("ALTER TABLE advertisements AUTO_INCREMENT= 10000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
}
