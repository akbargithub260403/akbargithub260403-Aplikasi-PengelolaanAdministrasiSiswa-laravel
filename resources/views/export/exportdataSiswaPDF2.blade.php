<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Siswa {{$jurusan}}</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
</head>

<style>
    @media print {
        .tombolPrint {
            display: none;
        }
    }

</style>

<body>
    <center><img src="{{asset('/img/logo.png')}}" alt="" height="150px;" width="120px;" style="opacity:0.5;"></center>
    <div class="container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Tanggal Data Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $dt)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$dt->NISN}}</td>
                    <td>{{$dt->nama}}</td>
                    <td>{{$dt->kelas}}</td>
                    <td>{{$dt->jurusan}}</td>
                    <td>{{$dt->alamat}}</td>
                    <td>{{$dt->email}}</td>
                    <td>{{$dt->no_telp}}</td>
                    <td>{{$dt->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button onclick="window.print()" class="tombolPrint btn btn-info">Print Disini</button>
    </div>


</body>

</html>
