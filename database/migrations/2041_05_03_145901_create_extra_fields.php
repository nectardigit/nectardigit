<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    protected function changeVideoTable($table)
    {
        if (!Schema::hasColumn('videos', 'image'))
            $table->string('image')->nullable();
    }

    protected function changeTeams($table)
    {
        if (!Schema::hasColumn('teams', 'description')) {
            $table->longText('description')->nullable()->change();
        }
    }
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $this->changeVideoTable($table);
        });
        Schema::table('teams', function (Blueprint $table) {
            $this->changeTeams($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_fields');
    }
}
