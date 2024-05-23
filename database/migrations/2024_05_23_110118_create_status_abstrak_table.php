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
        Schema::create('status_abstrak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_abstrak');
            $table->foreignId('id_staff');
            $table->string('status');
            $table->timestamps();

            $table->foreign('id_abstrak')->references('id')->on('abstrak');
            $table->foreign('id_staff')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_abstrak');
    }
};
