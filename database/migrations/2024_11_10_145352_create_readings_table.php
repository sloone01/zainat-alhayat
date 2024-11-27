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
        Schema::create('readings', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->date("start_date");
            $table->date("end_date");
            $table->unsignedBigInteger("created_by");
            $table->unsignedBigInteger("supervisor_id");
            $table->unsignedBigInteger("child_id");
            $table->enum("status",['N','Y'])->default('N');
            $table->foreign('supervisor_id')->references('id')->on('users');
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
        Schema::dropIfExists('readings');
    }
};
