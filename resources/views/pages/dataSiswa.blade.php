@extends('layouts.main')
@section('judul','Halaman Data Siswa')
@section('judulContent','File Data Siswa')
@section('dataSiswa','active')

@section('content')

<table class="table table-dark table-bordered table-hover ">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama File</th>
            <th>Keterangan</th>
            <th>Tanggal Data Masuk</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $dt)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td><a href="{{asset('/file/'.$dt->data_file)}}">{{$dt->data_file}}</a></td>
            <td>{{$dt->keterangan}}</td>
            <td>{{$dt->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection