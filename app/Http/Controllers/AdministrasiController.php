<?php

namespace App\Http\Controllers;

use App\Student;
use App\Administrasi;

use PDF;

use Illuminate\Http\Request;


class AdministrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $NISN)
    {
        $data   =  Student::where('NISN',$NISN)->get();

        foreach ($data as $dt) {
            
            $id         = $dt->id;
            $NISN       = $dt->NISN;
            $nama       = $dt->nama;
            $kelas      = $dt->kelas;
            $jurusan    = $dt->jurusan;
            $tanggal    = $request->tanggal;

        };

        $administrasi   = ([
            'id_siswa'      => $id,
            'NISN'          => $NISN,
            'nama'          => $nama,
            'kelas'         => $kelas,
            'tanggal'       => $tanggal,
            'jurusan'       => $jurusan
        ]);

        Administrasi::create($administrasi);

        return back()->with('status', 'Data Administrasi Siswa berhasil di Update');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Administrasi  $administrasi
     * @return \Illuminate\Http\Response
     */
    public function show(Administrasi $administrasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Administrasi  $administrasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Administrasi $administrasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Administrasi  $administrasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Administrasi $administrasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Administrasi  $administrasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrasi $administrasi)
    {
        Administrasi::destroy($administrasi->id);

        return back()->with('status','Data Administrasi Siswa Berhasil dihapus');
    }

    public function exportAdministrasi($nama , $NISN)
    {
        $dataAdministrasi   = Administrasi::where('NISN',$NISN)->get();
        $dataSiswa          = Student::where('NISN',$NISN)->get();

        foreach ($dataSiswa as $dt) {
            $namaSiswa      = $dt->nama;
        }

        return view('export/exportdataSiswaPDF',['dataAdministrasi' => $dataAdministrasi , 'dataSiswa' => $dataSiswa , 'namaSiswa' => $namaSiswa]);

    }
}
