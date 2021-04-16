<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Siswa Jurusan $jurusan .xls");
?>
<h1><center>Data Siswa Jurusan <?= $jurusan; ?></center></h1>
<table border=1>
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>NISN</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>No Telepon</th>
            <th>Tanggal Data Masuk</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$dt->NISN}}</td>
                <td>{{$dt->nama}}</td>
                <td>{{$dt->kelas}}</td>
                <td>{{$dt->jurusan}}</td>
                <td>{{$dt->email}}</td>
                <td>{{$dt->alamat}}</td>
                <td>{{$dt->no_telp}}</td>
                <td>{{$dt->created_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
