<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrasi extends Model
{
    protected $table  = 'administrasi';

    protected $fillable   = ['id_siswa','NISN','nama','kelas','tanggal','jurusan'];
}
