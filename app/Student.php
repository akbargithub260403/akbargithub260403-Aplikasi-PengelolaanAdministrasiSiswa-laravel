<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table    = 'students';

    protected $fillable     = ['nama','NISN','kelas','jurusan','email','alamat','no_telp','gambar'];

    public function getAvatar()
    {
        if($this->gambar == null){
            return asset('img/default.png');
        }

        return asset('img/gambar-siswa/'.$this->gambar);
    }
}
