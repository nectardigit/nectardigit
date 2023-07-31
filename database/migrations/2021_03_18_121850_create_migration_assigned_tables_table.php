<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMigrationAssignedTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('migration_assigned_tables', function (Blueprint $table) {
            $table->id();
            $table->string('internal_table')->nullable();
            $table->string('external_table')->nullable();
            $table->string('content_type')->nullable();
            $table->string('model_name')->nullable();
            $table->string('aspected_table', 100)->nullable();

            $table->string('framework')->nullable()->comment('wordpress, laravel, codingter');
            $table->enum('migrated', ['0', '1', '2', '-1'])->default('0');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('migrated_by')->nullable();
            $table->timestamp('migrated_at')->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('migrated_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('migration_assigned_tables');
    }
}
