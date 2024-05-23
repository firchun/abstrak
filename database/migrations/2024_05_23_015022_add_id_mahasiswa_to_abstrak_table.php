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
        Schema::table('abstrak', function (Blueprint $table) {
            $table->foreignId('id_mahasiswa')->after('id');

            $table->foreign('id_mahasiswa')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abstrak', function (Blueprint $table) {
            //
        });
    }
};
