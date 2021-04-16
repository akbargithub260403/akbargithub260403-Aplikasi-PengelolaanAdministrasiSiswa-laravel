<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministrasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrasi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_siswa');
            $table->bigInteger('NISN');
            $table->string('nama');
            $table->string('kelas');
            $table->string('tanggal');
            $table->string('jurusan');
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
        Schema::dropIfExists('administrasi');
    }
}
