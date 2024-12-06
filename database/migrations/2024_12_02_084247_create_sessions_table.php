<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('day');
            $table->integer('order');
            $table->string('title');
            $table->string('description');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('status');
            $table->unsignedBigInteger("timetable_id");
            $table->foreign('timetable_id')->references('id')->on('timetables');
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
        Schema::dropIfExists('sessions');
    }
};
