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
        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->date("start_date");
            $table->unsignedBigInteger("criteria_id");
            $table->unsignedBigInteger("created_by");
            $table->unsignedBigInteger("child_id");
            $table->enum("status",['N','Y'])->default('N');
            $table->foreign('criteria_id')->references('id')->on('criterias');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('child_id')->references('id')->on('users');
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
        Schema::dropIfExists('performances');
    }
};
