@extends('layouts.main')
@section('judul','Halaman | Update Data Siswa')
@section('judulContent','Edit Data Siswa')
@section('content')

@if (session('status'))
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&nbsp;</button>
    {{ session('status') }} &nbsp; <a href="#" class="alert-link">Berhasil</a>.
</div>
@endif

<hr>

    <form role="form" method="post" action="{{'/update-data/progress/'.$student->id}}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="inputEmail4">Nama Siswa</label>
            <input type="text" name="nama" autocomplete="off" value="{{$student->nama}}" class="form-control @error('nama') is-invalid @enderror" id="inputEmail4">
                @error('nama')
                <div class="alert alert-danger invalid-feedback">
                    <strong>Kesalahan!</strong> {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-4">
            <label for="inputPassword4">NISN</label>
            <input type="text" name="NISN" autocomplete="off" value="{{$student->NISN}}" class="form-control @error('NISN') is-invalid @enderror" id="inputPassword4">
                @error('NISN')
                <div class="alert alert-danger invalid-feedback">
                    <strong>Kesalahan!</strong> {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-4">
            <label>Kelas</label>
            <input type="text" name="kelas" autocomplete="off" value="{{$student->kelas}}" class="form-control @error('kelas') is-invalid @enderror" id="inputPassword4">
                @error('kelas')
                <div class="alert alert-danger invalid-feedback">
                    <strong>Kesalahan!</strong> {{ $message }}
                </div>
                @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Jurusan</label>
            <input type="text" name="jurusan" autocomplete="off" value="{{$student->jurusan}}" class="form-control @error('jurusan') is-invalid @enderror" id="inputPassword4">
                @error('jurusan')
                <div class="alert alert-danger invalid-feedback">
                    <strong>Kesalahan!</strong> {{ $message }}
                </div>
                @enderror
        </div>
        <div class="form-row col-md-8">
            <div class="form-group ">
                <label>Alamat</label>
                <input type="text" name="alamat" autocomplete="off" value="{{$student->alamat}}" class="form-control @error('alamat') is-invalid @enderror" id="inputPassword4">
                @error('alamat')
                    <div class="alert alert-danger invalid-feedback">
                        <strong>Kesalahan!</strong> {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="">Email</label>
                <input type="email" name="email" value="{{$student->email}}" autocomplete="off" class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <div class="alert alert-danger invalid-feedback">
                        <strong>Kesalahan!</strong> {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">NO Telepon</label>
                <input type="text" name="no_telp" value="{{$student->no_telp}}" autocomplete="off" class="form-control @error('no_telp') is-invalid @enderror">
                @error('no_telp')
                    <div class="alert alert-danger invalid-feedback">
                        <strong>Kesalahan!</strong> {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-row col-md-6">
            <div class="form-group">
                <label for="">Gambar</label>
                <input type="file" name="gambar" id="" class="@error('gambar') is-invalid @enderror">
                @error('gambar')
                    <div class="alert alert-danger invalid-feedback">
                        <strong>Kesalahan!</strong> {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-row col-md-8">
            <div class="form-group">
                <img src="{{ $student->getAvatar()}}" height="130px;" width="130px;" style="border-radius: 50%;" alt="">
            </div>
        </div>
        <div class="form-row col-md-8 mt-4" style="margin-top: 10px;">
            <button type="submit" class="btn btn-lg btn-block btn-outline btn-info">Simpan</button>
        </div>
        </form>       


@endsection