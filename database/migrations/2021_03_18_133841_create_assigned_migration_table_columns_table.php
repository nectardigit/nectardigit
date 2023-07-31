<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedMigrationTableColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_migration_table_columns', function (Blueprint $table) {
            $table->id();
            $table->string('internal_column')->nullable();
            $table->string('external_column')->nullable();
            $table->string('external_table')->nullable();
            $table->string('internal_table')->nullable();
            $table->unsignedBigInteger('external_table_id')->nullable();
            $table->unsignedBigInteger('internal_table_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->enum('is_primary_key', ['1', '0'])->default('0');
            $table->timestamps();
            $table->foreign('external_table_id')->references('id')->on('migration_assigned_tables')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('internal_table_id')->references('id')->on('migration_assigned_tables')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assigned_migration_table_columns');
    }
}
