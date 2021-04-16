@extends('layouts.main')
@section('judul',$jurusan)
@section('judulContent',$jurusan)
@section('halamanJurusan','active')

@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <center><img src="{{$gambar}}" style="border-radius: 50%;" width="150px;" height="150px;" alt=""></center>
        <h2 class="display-4">{{$jurusan}}</h2>
        <p style="font-size:15px;">{{$keterangan}}</p>
        @if (session('status'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&nbsp;</button>
            {{ session('status') }} &nbsp; <a href="#" class="alert-link">Berhasil</a>.
        </div>
        @endif
    </div>
</div>
<!-- /.col-lg-6 -->


<!-- Button trigger modal -->
<div style="float:right; margin-bottom:10px;">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
        <i class="glyphicon glyphicon-print"></i> &nbsp; Export Data Siswa
    </button>
</div><br>
<hr>


<div class="col">
    <div class="panel tabbed-panel panel-primary">
        <div class="panel-heading clearfix">
            <div class="panel-title pull-left">Tabel Data Siswa</div>
            <div class="pull-right">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-primary-4" data-toggle="tab">Semua Kelas</a></li>
                    <li><a href="#tab-primary-1" data-toggle="tab">Kelas X</a></li>
                    <li><a href="#tab-primary-2" data-toggle="tab">Kelas XI</a></li>
                    <li><a href="#tab-primary-3" data-toggle="tab">Kelas XII</a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab-primary-4">
                    <form action="{{'/search-dataSiswa/'.$namaJurusan}}" method="post" style="margin-bottom:10px;"
                        class="d-inline col-md-6">
                        @csrf
                        <label for=""><i>Cari Data Siswa</i></label>
                        <input type="text" name="keyword" class="form-control" autocomplete="off"
                            placeholder="Search Engine">
                    </form>
                    <table class="table">
                        <thead>
                            <tr style="background-color: #228B22;">
                                <th style="color:white;">#</th>
                                <th style="color:white;">NISN</th>
                                <th style="color:white;">Nama Siswa</th>
                                <th style="color:white;">Kelas</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $dt)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dt->NISN}}</td>
                                <td>{{$dt->nama}}</td>
                                <td>{{$dt->kelas}}</td>
                                <td><a href="{{'/detail/'.$dt->id.'/'.$dt->NISN}}"
                                        class="btn btn-outline btn-info btn-xs">Detail</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade " id="tab-primary-1">
                    <table class="table">
                        <thead>
                            <tr style="background-color: #228B22;">
                                <th style="color:white;">#</th>
                                <th style="color:white;">NISN</th>
                                <th style="color:white;">Nama Siswa</th>
                                <th style="color:white;">Kelas</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataX as $dt)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dt->NISN}}</td>
                                <td>{{$dt->nama}}</td>
                                <td>{{$dt->kelas}}</td>
                                <td><a href="{{'/detail/'.$dt->id.'/'.$dt->NISN}}"
                                        class="btn btn-outline btn-info btn-xs">Detail</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tab-primary-2">
                    <table class="table">
                        <thead>
                            <tr style="background-color: #228B22;">
                                <th style="color:white;">#</th>
                                <th style="color:white;">NISN</th>
                                <th style="color:white;">Nama Siswa</th>
                                <th style="color:white;">Kelas</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataXI as $dt)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dt->NISN}}</td>
                                <td>{{$dt->nama}}</td>
                                <td>{{$dt->kelas}}</td>
                                <td><a href="{{'/detail/'.$dt->id.'/'.$dt->NISN}}"
                                        class="btn btn-outline btn-info btn-xs">Detail</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tab-primary-3">
                    <table class="table">
                        <thead>
                            <tr style="background-color: #228B22;">
                                <th style="color:white;">#</th>
                                <th style="color:white;">NISN</th>
                                <th style="color:white;">Nama Siswa</th>
                                <th style="color:white;">Kelas</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataXII as $dt)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dt->NISN}}</td>
                                <td>{{$dt->nama}}</td>
                                <td>{{$dt->kelas}}</td>
                                <td><a href="{{'/detail/'.$dt->id.'/'.$dt->NISN}}"
                                        class="btn btn-outline btn-info btn-xs">Detail</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.panel -->
</div>
<!-- /.col-lg-6 -->



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Export data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="{{'/exportDataSiswa/'.$namaJurusan.'/'.$kelas='all'.'/XLS'}}" class="btn btn-success d-inline">Export Excel Semua Kelas</a>
                <a href="{{'/exportDataSiswa/'.$namaJurusan.'/'.$kelas='all'.'/PDF'}}" target="_blank" class="btn btn-danger">Export PDF Semua Kelas</a>
                <br><hr>
                <a href="{{'/exportDataSiswa/'.$namaJurusan.'/'.$kelas='X'.'/XLS'}}" class="btn btn-success d-inline">Export Excel Kelas X</a>
                <a href="{{'/exportDataSiswa/'.$namaJurusan.'/'.$kelas='X'.'/PDF'}}" target="_blank" class="btn btn-danger">Export PDF Kelas X</a>
                <br><hr>
                <a href="{{'/exportDataSiswa/'.$namaJurusan.'/'.$kelas='XI'.'/XLS'}}" class="btn btn-success d-inline">Export Excel Kelas XI</a>
                <a href="{{'/exportDataSiswa/'.$namaJurusan.'/'.$kelas='XI'.'/PDF'}}" target="_blank" class="btn btn-danger">Export PDF Kelas XI</a>
                <br><hr>
                <a href="{{'/exportDataSiswa/'.$namaJurusan.'/'.$kelas='XII'.'/XLS'}}" class="btn btn-success d-inline">Export Excel Kelas XII</a>
                <a href="{{'/exportDataSiswa/'.$namaJurusan.'/'.$kelas='XII'.'/PDF'}}" target="_blank" class="btn btn-danger">Export PDF Kelas XII</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
