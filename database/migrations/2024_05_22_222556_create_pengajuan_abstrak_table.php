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
        Schema::create('abstrak', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('file');
            $table->enum('status', ['Pengajuan', 'Pemeriksaan', 'Revisi', 'Selesai'])->default('Pengajuan');
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
        Schema::dropIfExists('pengajuan_abstrak');
    }
};
