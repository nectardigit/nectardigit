<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOldDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('old_databases', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('api_url')->nullable();
            $table->string('content_type')->nullable();
            $table->string('aspected_table', 100)->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            // $table->unsignedBigInteger('contentType')->nullable();
            $table->string('model_name')->nullable();
            $table->string('framework')->nullable()->comment('wordpress, laravel, codingter');
            $table->timestamp('migrated_at')->nullable();
            $table->timestamps();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
            // $table->foreign('contentType')->references('id')->on('menus')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_databases');
    }
}
