<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Administrasi {{$namaSiswa}}</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
</head>

<style>
    @media print{
        .tombolPrint{
            display: none;
        }
    }
</style>

<body>

    <center><img src="{{asset('/img/logo.png')}}" alt="" height="150px;" width="120px;" style="opacity:0.5;"></center>
    <div class="container">

        <table class="table table-bordered" cellpadding="8" border=1>
            <thead>
                <tr>
                    <th></th>
                    <td style="padding: 10px 50px">
                        <center><b>Data Siswa</b></center>
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach($dataSiswa as $dt)
                    <tr>
                        <th rowspan="8" width="300px;"><center ><img style="margin-top:30px; border-radius:10px;" src="{{asset('/img/gambar-siswa/'.$dt->gambar)}}" height="180px;" width="180px;" alt=""></center></th>
                    </tr>
                @endforeach    
                @foreach($dataSiswa as $dt)
                    <tr>
                        <td>NISN : <b>{{$dt->NISN}}</b></td>
                    </tr>
                    <tr>
                        <td>Nama : <b>{{$dt->nama}}</b></td>
                    </tr>
                    <tr>
                        <td>Kelas   : <b>{{$dt->kelas}}</b></td>
                    </tr>
                    <tr>
                        <td>Jurusan     : <b>{{$dt->jurusan}}</b></td>
                    </tr>
                    <tr>
                        <td>Email       : <b>{{$dt->email}}</b></td>
                    </tr>
                    <tr>
                        <td>Alamat      : <b>{{$dt->alamat}}</b></td>
                    </tr>
                    <tr>
                        <td>No Telepon  : <b>{{$dt->no_telp}}</b></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <table class="table table-bordered" border=1>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Waktu Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataAdministrasi as $dta)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$dta->tanggal}}</td>
                    <td>{{$dta->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button onclick="window.print()" class="tombolPrint btn btn-info">Print Disini</button>

    </div>

</body>

</html>
