<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            'NISN'      => $row[1],
            'nama'      => $row[2],
            'kelas'     => $row[3],
            'jurusan'   => $row[4],
            'email'     => $row[5],
            'alamat'    => $row[6],
            'no_telp'   => $row[7]
        ]);
    }
}
