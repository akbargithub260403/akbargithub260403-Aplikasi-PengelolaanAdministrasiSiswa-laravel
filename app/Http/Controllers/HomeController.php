<?php

namespace App\Http\Controllers;

use App\Student;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jumlah_siswa           = Student::all();
        $jumlah_administrasi    = DB::table('administrasi')->get();
        $jumlah_admin           = DB::table('users')->get();
        $RPL                    = Student::where('jurusan','RPL')->get();
        $TKJ                    = Student::where('jurusan','TKJ')->get();
        $BDP                    = Student::where('jurusan','BDP')->get();
        $KIMIA                  = Student::where('jurusan','KIMIA')->get();
        $ATPH                   = Student::where('jurusan','ATPH')->get();
        $TEI                    = Student::where('jurusan','TEI')->get();

        $data   = [
            'jumlah_siswa'              => $jumlah_siswa,
            'jumlah_administrasi'       => $jumlah_administrasi,
            'jumlah_admin'              => $jumlah_admin,
            'RPL'                       => $RPL,
            'TKJ'                       => $TKJ,
            'BDP'                       => $BDP,
            'KIMIA'                     => $KIMIA,
            'ATPH'                      => $ATPH,
            'TEI'                       => $TEI,
        ];

        return view('pages.dashboard',$data);
    }
}
