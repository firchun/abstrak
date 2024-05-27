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
        Schema::create('file_abstrak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_abstrak');
            $table->string('file');
            $table->boolean('status')->comment('0 : menunggu pemeriksaan, 1 : disetujui, 2 : revisi')->default(0);
            $table->timestamps();

            $table->foreign('id_abstrak')->references('id')->on('abstrak');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_abstrak');
    }
};
