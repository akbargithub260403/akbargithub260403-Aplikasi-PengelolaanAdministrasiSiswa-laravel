<?php

namespace App\Http\Controllers;

use App\Student;
use App\Administrasi;

use File;

use App\Imports\SiswaImport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StudentsController extends Controller
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
        return view('pages.tambah-siswa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = ([
            'nama'              => 'required',
            'NISN'              => 'required|max:13',
            'alamat'            => 'required',
            'email'             => 'required',
            'no_telp'           => 'required',
            'gambar'            => 'required|file|image|mimes:jpg,png,jpeg,JPG,PNG,JPEG|max:2048'
        ]);

        $pesan = ([
            'required'      => 'Kolom ini harus di isi',
            'max'           => 'maksimal kolom adalah 13 karakter',
            'image'         => 'ekstension gambar yang valid adalah ( jpg , png , jpeg , JPG , PNG , JPEG)'
        ]);

        $this->validate($request, $rules, $pesan);

        // menyimpan data file yang diupload ke variabel $file
        $gambar = $request->file('gambar');

        $nama_gambar = time() . "_" . $gambar->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'img/gambar-siswa';

        $gambar->move($tujuan_upload, $nama_gambar);

        Student::create([
            'nama'              => $request->nama,
            'NISN'              => $request->NISN,
            'kelas'             => $request->kelas,
            'jurusan'           => $request->jurusan,
            'alamat'            => $request->alamat,
            'email'             => $request->email,
            'no_telp'           => $request->no_telp,
            'gambar'            => $nama_gambar,
        ]);

        return back()->with('status', 'Data Siswa Berhasil Dimasukan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $administrasi   = Administrasi::where('NISN',$student->NISN)->get();

        return view('pages.detail-siswa', ['student' => $student , 'administrasi' => $administrasi]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('pages.updateData', ['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        if (empty($request->gambar)) {

            $rules = ([
                'nama'              => 'required',
                'NISN'              => 'required|max:13',
                'alamat'            => 'required',
                'email'             => 'required',
                'kelas'             => 'required|max:3',
                'jurusan'           => 'required|max:3',
                'no_telp'           => 'required'
            ]);

            $pesan = ([
                'required'      => 'Kolom ini harus di isi'
            ]);

            $this->validate($request, $rules, $pesan);

            $kelas      = strtoupper($request->kelas);
            $jurusan    = strtoupper($request->jurusan);


            Student::where('id', $student->id)
                ->update([
                    'NISN'      => $request->NISN,
                    'nama'      => $request->nama,
                    'alamat'    => $request->alamat,
                    'kelas'     => $kelas,
                    'jurusan'   => $jurusan,
                    'email'     => $request->email,
                    'no_telp'   => $request->no_telp
                ]);

            return back()->with('status', 'Data Siswa berhasil di Update');
        } else {

            $rules = ([
                'nama'              => 'required',
                'NISN'              => 'required|max:13',
                'alamat'            => 'required',
                'email'             => 'required',
                'kelas'             => 'required|max:3',
                'jurusan'           => 'required|max:3',
                'no_telp'           => 'required',
                'gambar'            => 'required|file|image|mimes:jpg,png,jpeg,JPG,PNG,JPEG|max:2048'
            ]);

            $pesan = ([
                'required'      => 'Kolom ini harus di isi',
                'image'         => 'ekstension gambar yang valid adalah ( jpg , png , jpeg , JPG , PNG , JPEG)'
            ]);

            $this->validate($request, $rules, $pesan);

            $kelas      = strtoupper($request->kelas);
            $jurusan    = strtoupper($request->jurusan);

            // menyimpan data file yang diupload ke variabel $file
            $gambar = $request->file('gambar');

            $nama_gambar = time() . "_" . $gambar->getClientOriginalName();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'img/gambar-siswa';

            $gambar->move($tujuan_upload, $nama_gambar);
            // *========================================================* //

            // menghapus gambar jika siswa sudah mempunyai avatar dan mengganti dengan avatar yang baru
            $gambar = Student::where('id', $student->id)->first();

            File::delete('img/gambar-siswa/' . $gambar->gambar);
            // *========================================================* //

            Student::where('id', $student->id)
                ->update([
                    'NISN'      => $request->NISN,
                    'nama'      => $request->nama,
                    'alamat'    => $request->alamat,
                    'kelas'     => $kelas,
                    'jurusan'   => $jurusan,
                    'email'     => $request->email,
                    'no_telp'   => $request->no_telp,
                    'gambar'    => $nama_gambar
                ]);

            return back()->with('status', 'Data Siswa berhasil di Update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $jurusan     = $student->jurusan;

        if ($jurusan == 'RPL') {

            $gambar = Student::where('id', $student->id)->first();

            File::delete('img/gambar-siswa/' . $gambar->gambar);

            Student::destroy($student->id);

            return redirect("/jurusan-students/RPL")->with('status', 'Data Siswa berhasil Di Hapus');
        } elseif ($jurusan == 'TKJ') {

            $gambar = Student::where('id', $student->id)->first();

            File::delete('img/gambar-siswa/' . $gambar->gambar);

            Student::destroy($student->id);

            return redirect("/jurusan-students/TKJ")->with('status', 'Data Siswa berhasil Di Hapus');
        } elseif ($jurusan == 'BDP') {

            $gambar = Student::where('id', $student->id)->first();

            File::delete('img/gambar-siswa/' . $gambar->gambar);

            Student::destroy($student->id);

            return redirect("/jurusan-students/BDP")->with('status', 'Data Siswa berhasil Di Hapus');
        } elseif ($jurusan == 'KIMIA') {

            $gambar = Student::where('id', $student->id)->first();

            File::delete('img/gambar-siswa/' . $gambar->gambar);

            Student::destroy($student->id);

            return redirect("/jurusan-students/KI")->with('status', 'Data Siswa berhasil Di Hapus');
        } elseif ($jurusan == 'ATPH') {

            $gambar = Student::where('id', $student->id)->first();

            File::delete('img/gambar-siswa/' . $gambar->gambar);

            Student::destroy($student->id);

            return redirect("/jurusan-students/ATPH")->with('status', 'Data Siswa berhasil Di Hapus');
        } elseif ($jurusan == 'TEI') {

            $gambar = Student::where('id', $student->id)->first();

            File::delete('img/gambar-siswa/' . $gambar->gambar);

            Student::destroy($student->id);

            return redirect("/jurusan-students/TEI")->with('status', 'Data Siswa berhasil Di Hapus');
        }
    }

    public function import(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file', $nama_file);

        // import data
        Excel::import(new SiswaImport, public_path('/file/' . $nama_file));

        DB::table('datas')->insert([
            'data_file'     => $nama_file,
            'keterangan'    => $request->keterangan,
            'created_at'    => now()->toDateTimeString()
        ]);

        // alihkan halaman kembali
        return back()->with('status', 'Data Siswa berhasil dimasukan');
    }


    public function dataSiswaExcel()
    {
        $data   = DB::table('datas')->get();

        return view('pages.dataSiswa',['data'=> $data]);
    }

    public function jurusan($jurusan)
    {
        if ($jurusan == 'RPL') {

            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();
            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();

            $data       = Student::where('jurusan', $jurusan)->get();


            $jurusan    = 'Rekayasa Perangkat Lunak';
            $namaJurusan = 'RPL';
            $gambar     =  asset('img/rpl.jpg');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Rekayasa Perangkat Lunak.';

            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
        } elseif ($jurusan == 'TKJ') {

            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();
            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();

            $data       = Student::where('jurusan', $jurusan)->get();

            $jurusan    = 'Teknik Komputer Jaringan';
            $namaJurusan = 'TKJ';
            $gambar     =  asset('img/tkj.png');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Teknik Komputer Jaringan.';

            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
        } elseif ($jurusan == 'KIMIA') {

            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();
            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();

            $data       = Student::where('jurusan', $jurusan)->get();

            $jurusan    = 'Kimia Industri';
            $namaJurusan = 'KIMIA';
            $gambar     =  asset('img/kimia.jpg');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Kimia Industri.';

            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
        } elseif ($jurusan == 'BDP') {

            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();
            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();

            $data       = Student::where('jurusan', $jurusan)->get();

            $jurusan    = 'Bisnis Dan Pemasaran';
            $namaJurusan = 'BDP';
            $gambar     =  asset('img/bdp.png');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Bisnis Daring Pemasaran.';

            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
        } elseif ($jurusan == 'ATPH') {

            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();
            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();

            $data       = Student::where('jurusan', $jurusan)->get();

            $jurusan    = 'Agribisnis Tanaman Pangan Dan Horticultura';
            $namaJurusan = 'ATPH';
            $gambar     =  asset('img/atph.png');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Agribisnis Tanaman Pangan dan Horticultura.';

            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
        } elseif ($jurusan == 'TEI') {

            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();
            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();

            $data       = Student::where('jurusan', $jurusan)->get();

            $jurusan    = 'Teknik Elektronik Industri';
            $namaJurusan = 'TEI';
            $gambar     =  asset('img/tei.jpg');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Teknik Elektronik Industri.';

            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
        }
    }

    public function search(Request $request, $jurusan)
    {

        if ($jurusan == 'RPL') {

            if ($request->keyword == null) {

                $data   = Student::where('jurusan', $jurusan)->get();
            } else {

                $data   = DB::table('students')
                    ->where('nama', 'LIKE', "%" . $request->keyword . "%")
                    ->where(function ($query) {
                        $query->where('jurusan', '=', 'RPL');
                    })
                    ->get();
            }


            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();

            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();


            $jurusan    = 'Rekayasa Perangkat Lunak';
            $namaJurusan = 'RPL';
            $gambar     =  asset('img/rpl.jpg');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Rekayasa Perangkat Lunak.';

            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
        } elseif ($jurusan == 'TKJ') {

            if ($request->keyword == null) {

                $data   = Student::where('jurusan', $jurusan)->get();
            } else {

                $data   = DB::table('students')
                    ->where('nama', 'LIKE', "%" . $request->keyword . "%")
                    ->where(function ($query) {
                        $query->where('jurusan', '=', 'TKJ');
                    })
                    ->get();
            }


            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();

            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();

            $jurusan    = 'Teknik Komputer Jaringan';
            $namaJurusan = 'TKJ';
            $gambar     =  asset('img/tkj.png');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Teknik Komputer Jaringan.';


            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
        } elseif ($jurusan == 'BDP') {

            if ($request->keyword == null) {

                $data   = Student::where('jurusan', $jurusan)->get();
            } else {

                $data   = DB::table('students')
                    ->where('nama', 'LIKE', "%" . $request->keyword . "%")
                    ->where(function ($query) {
                        $query->where('jurusan', '=', 'BDP');
                    })
                    ->get();
            }


            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();

            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();

            $jurusan    = 'Bisnis Dan Pemasaran';
            $namaJurusan = 'BDP';
            $gambar     =  asset('img/bdp.png');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Bisnis Daring Pemasaran.';


            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
            
        } elseif ($jurusan == 'KI') {

            if ($request->keyword == null) {

                $data   = Student::where('jurusan', $jurusan)->get();
            } else {

                $data   = DB::table('students')
                    ->where('nama', 'LIKE', "%" . $request->keyword . "%")
                    ->where(function ($query) {
                        $query->where('jurusan', '=', 'KI');
                    })
                    ->get();
            }


            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();

            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();

            $jurusan    = 'Kimia Industri';
            $namaJurusan = 'KIMIA';
            $gambar     =  asset('img/kimia.jpg');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Kimia Industri.';


            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
        } elseif ($jurusan == 'ATPH') {

            if ($request->keyword == null) {

                $data   = Student::where('jurusan', $jurusan)->get();
            } else {

                $data   = DB::table('students')
                    ->where('nama', 'LIKE', "%" . $request->keyword . "%")
                    ->where(function ($query) {
                        $query->where('jurusan', '=', 'ATPH');
                    })
                    ->get();
            }


            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();

            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();

            $jurusan    = 'Agribisnis Tanaman Pangan Dan Horticultura';
            $namaJurusan = 'ATPH';
            $gambar     =  asset('img/atph.png');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Agribisnis Tanaman Pangan dan Horticultura.';


            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
        } elseif ($jurusan == 'TEI') {

            if ($request->keyword == null) {

                $data   = Student::where('jurusan', $jurusan)->get();
            } else {

                $data   = DB::table('students')
                    ->where('nama', 'LIKE', "%" . $request->keyword . "%")
                    ->where(function ($query) {
                        $query->where('jurusan', '=', 'TEI');
                    })
                    ->get();
            }


            $dataX      = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'X');
                })->get();

            $dataXI     = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XI');
                })->get();
            $dataXII    = Student::where('jurusan', $jurusan)
                ->where(function ($query) {
                    $query->where('kelas', '=', 'XII');
                })->get();

            $jurusan    = 'Teknik Elektronik Industri';
            $namaJurusan = 'TEI';
            $gambar     =  asset('img/tei.jpg');
            $keterangan = 'Ini adalah halaman untuk setiap data Students yang memiliki jurusan Teknik Elektronik Industri.';


            return view('pages.halaman-jurusan', ['data' => $data, 'dataX' => $dataX, 'dataXI' => $dataXI, 'dataXII' => $dataXII, 'jurusan' => $jurusan, 'namaJurusan' => $namaJurusan,  'gambar' => $gambar, 'keterangan' => $keterangan]);
        }
    }

    public function exportExcel($jurusan , $kelas)
    {

// Rekayasa Perangkat Lunak

        if ($jurusan == "RPL") {

            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "RekayasaPerangkatLunak";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "RekayasaPerangkatLunak";


            return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "RekayasaPerangkatLunak";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "RekayasaPerangkatLunak";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);
            
            }

// Teknik Komputer Jaringan 

        }elseif ($jurusan == "TKJ") {
            
            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "TeknikKomputerJaringan";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "TeknikKomputerJaringan";


            return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "TeknikKomputerJaringan";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "TeknikKomputerJaringan";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);
            
            }

// Bisnis Daring Dan Pemsaran 

        }elseif ($jurusan == "BDP") {
            
            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "BisnisDanPemasaran";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "BisnisDanPemasaran";


                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "BisnisDanPemasaran";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "BisnisDanPemasaran";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);
            
            }

// Kimia Industri

        }elseif ($jurusan == "KIMIA") {
            
            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "KimiaIndustri";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "KimiaIndustri";


                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "KimiaIndustri";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "KimiaIndustri";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);
            
            }

// AgribisnisTanamanPanganHorticultura
        }elseif ($jurusan == "ATPH") {
            
            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "AgribisnisTanamanPanganHorticultura";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "AgribisnisTanamanPanganHorticultura";


            return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "AgribisnisTanamanPanganHorticultura";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "AgribisnisTanamanPanganHorticultura";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);
            
            }

// Teknik Elektronik Industri

        }elseif ($jurusan == "TEI") {
            
            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "TeknikElektronikIndustri";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "TeknikElektronikIndustri";


            return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "TeknikElektronikIndustri";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "TeknikElektronikIndustri";

                return view('export.exportdataSiswaXLS',['data' => $data , 'jurusan' => $jurusan]);
            
            }
            
        }
    }


    public function exportPDF($jurusan , $kelas)
    {

// Rekayasa Perangkat Lunak

        if ($jurusan == "RPL") {

            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "RekayasaPerangkatLunak";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "RekayasaPerangkatLunak";


            return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "RekayasaPerangkatLunak";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "RekayasaPerangkatLunak";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);
            
            }

// Teknik Komputer Jaringan 

        }elseif ($jurusan == "TKJ") {
            
            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "TeknikKomputerJaringan";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "TeknikKomputerJaringan";


            return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "TeknikKomputerJaringan";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "TeknikKomputerJaringan";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);
            
            }

// Bisnis Daring Dan Pemsaran 

        }elseif ($jurusan == "BDP") {
            
            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "BisnisDanPemasaran";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "BisnisDanPemasaran";


                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "BisnisDanPemasaran";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "BisnisDanPemasaran";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);
            
            }

// Kimia Industri

        }elseif ($jurusan == "KIMIA") {
            
            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "KimiaIndustri";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "KimiaIndustri";


                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "KimiaIndustri";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "KimiaIndustri";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);
            
            }

// AgribisnisTanamanPanganHorticultura
        }elseif ($jurusan == "ATPH") {
            
            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "AgribisnisTanamanPanganHorticultura";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "AgribisnisTanamanPanganHorticultura";


            return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "AgribisnisTanamanPanganHorticultura";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "AgribisnisTanamanPanganHorticultura";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);
            
            }

// Teknik Elektronik Industri

        }elseif ($jurusan == "TEI") {
            
            if ($kelas == 'all') {

                $data       = Student::where('jurusan',$jurusan)->get();

                $jurusan    = "TeknikElektronikIndustri";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'X') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','X');
                                })->get();
                $jurusan    = "TeknikElektronikIndustri";


            return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XI') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XI');
                                })->get();
                $jurusan    = "TeknikElektronikIndustri";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);

            }elseif ($kelas == 'XII') {
                
                $data       = Student::where('jurusan',$jurusan)
                                ->where(function ($query){
                                    $query->where('kelas','=','XII');
                                })->get();
                $jurusan    = "TeknikElektronikIndustri";

                return view('export.exportdataSiswaPDF2',['data' => $data , 'jurusan' => $jurusan]);
            
            }
            
        }
    }
}
