<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->text('full_name')->nullable();
            $table->string('image')->nullable();
            $table->text('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('slug')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('description')->nulslable();
            $table->bigInteger('oldId')->nullable();
            $table->enum('isOldData', ['0', '1'])->default('0');

            $table->enum('publish_status', ['0', '1'])->default(1)->index();
            $table->bigInteger('view_count')->default(0);
            $table->boolean('show_footer')->default(false)->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreignId('designation_id')->nullable()->constrained('designations')->onUpdate('cascade')->onDelete('cascade');;
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
