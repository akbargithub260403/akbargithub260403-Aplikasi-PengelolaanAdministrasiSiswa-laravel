@extends('layouts.main')
@section('judul','Halaman Tambah Siswa')
@section('judulContent','Tambah Siswa')
@section('tambahSiswa','active')

@section('content')

@if (session('status'))
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&nbsp;</button>
    {{ session('status') }} &nbsp; <a href="#" class="alert-link">Berhasil</a>.
</div>
@endif

<button type="button" class="btn btn-outline btn-success btn-md col-md-offset-10" data-toggle="modal" data-target="#myModal">
    Import Data Siswa
</button>
<hr>

    <form role="form" method="post" action="{{'/tambah-siswa/progress'}}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="inputEmail4">Nama Siswa</label>
            <input type="text" name="nama" autocomplete="off" class="form-control @error('nama') is-invalid @enderror" id="inputEmail4">
                @error('nama')
                <div class="alert alert-danger invalid-feedback">
                    <strong>Kesalahan!</strong> {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-4">
            <label for="inputPassword4">NISN</label>
            <input type="text" name="NISN" autocomplete="off" class="form-control @error('NISN') is-invalid @enderror" id="inputPassword4">
                @error('NISN')
                <div class="alert alert-danger invalid-feedback">
                    <strong>Kesalahan!</strong> {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-4">
            <label>Kelas</label>
            <select name="kelas" class="form-control">
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Jurusan</label>
            <select name="jurusan" class="form-control">
                <option value="RPL">RPL</option>
                <option value="TKJ">TKJ</option>
                <option value="BDP">BDP</option>
                <option value="ATPH">ATPH</option>
                <option value="KIMIA">KIMIA</option>
                <option value="TEI">TEI</option>
            </select>
        </div>
        <div class="form-row col-md-8">
            <div class="form-group ">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"></textarea>
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
                <input type="email" name="email" autocomplete="off" class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <div class="alert alert-danger invalid-feedback">
                        <strong>Kesalahan!</strong> {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">NO Telepon</label>
                <input type="text" name="no_telp" autocomplete="off" class="form-control @error('no_telp') is-invalid @enderror">
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
        <div class="form-row col-md-8 mt-4" style="margin-top: 10px;">
            <button type="submit" class="btn btn-lg btn-block btn-outline btn-info">Simpan</button>
        </div>
        </form>       

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Import Data Siswa Xls.</h4>
            </div>
            <div class="modal-body">
                <form action="{{'/import-dataSiswa'}}" method="post" enctype="multipart/form-data">
                @csrf
                    <label for="">Data Siswa</label>
                    <input type="file" name="file" class="form-control col-md-6">
                    <br>
                    <label for="">Keterangan</label>
                    <input type="text" name="keterangan" id="" class="form-control col-md-6">
                    <br><br><hr>
                    <a href="{{asset('/file/1969903167contohFile.xlsx')}}">Contoh File Excel</a>
                    <hr>
                    <p>Perhatikan format dan isi dari file excel yang akan di Upload. Jika format file dan isi file tidak sesuai seperti contoh file , maka data siswa tidak akan tersimpan</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection