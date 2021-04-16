@extends('layouts.main')
@section('judul','Detail | Siswa')
@section('judulContent','Detail Siswa')
@section('halamanJurusan','active')

@section('content')

<!-- /.row -->
<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-green">
            <div class="panel-heading">
                Data Siswa
            </div>
            <div class="panel-body">
                <img src="{{ $student->getAvatar()}}" height="130px;" width="130px;" class="card-img-top"
                    style="border-radius: 50%;" alt="...">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">NISN : {{$student->NISN}} </li>
                    <li class="list-group-item">Nama : {{$student->nama}} </li>
                    <li class="list-group-item">Kelas : {{$student->kelas}} </li>
                    <li class="list-group-item">Jurusan : {{$student->jurusan}} </li>
                    <li class="list-group-item">Email : {{$student->email}} </li>
                    <li class="list-group-item">No Telepon : {{$student->no_telp}} </li>
                    <li class="list-group-item">Alamat : {{$student->alamat}} </li>
                </ul>
            </div>
            <div class="panel-footer">
                <a href="{{'/update-data/'.$student->id}}" style="margin-bottom: 10px;"
                    class=" d-inline btn btn-outline btn-warning ">Update Data</a>
                <form action="{{'/delete-data/'.$student->id}}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-outline btn-danger ">Delete Data</button>
                </form>
            </div>
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <div class="col-lg-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Administrasi Siswa
            </div>
            <div class="panel-body">

            <!-- Pesan Berhasil atau gagal -->
                @if (session('status'))
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&nbsp;</button>
                    {{ session('status') }} &nbsp; <a href="#" class="alert-link">Berhasil</a>.
                </div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($administrasi as $ad)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$ad->tanggal}}</td>
                            <td>
                                <form action="{{'/Hapus-Administrasi/'.$ad->id}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <a href="{{'/exportAdministrasi/'.$student->nama.'/'.$student->NISN}}" target="_blank"  class="btn btn-success">Export</a>
                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal">
                    Tambah Data Administrasi
                </button>
            </div>
        </div>
        <!-- /.col-lg-4 -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Administrasi</h4>
            </div>
            <div class="modal-body">
                <form action="{{'/tambahPembayaranAdministrasi/'.$student->NISN}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Pembayaran</label>
                        <input type="text" class="form-control" name="tanggal" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">Masukan Tanggal Sesuai Dengan Hari
                            ini.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection
