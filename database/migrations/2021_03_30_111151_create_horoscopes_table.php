<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoroscopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horoscopes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['daily', 'weekly','monthly','yearly']);
            $table->string('mesh');
            $table->string('vrish');
            $table->string('mithun');
            $table->string('karkat');
            $table->string('simha');
            $table->string('kanya');
            $table->string('tula');
            $table->string('vrishchik');
            $table->string('dhanu');
            $table->string('makara');
            $table->string('kumba');
            $table->string('meen');
            $table->boolean('publish_status')->default(true);
            $table->dateTime('published_at')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->date('day')->nullable();
            $table->string('month',10)->nullable()->index();
            $table->year('year')->nullable();
            $table->dateTime('startWeekDay')->nullable();
            $table->dateTime('endWeekDay')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horoscopes');
    }
}
