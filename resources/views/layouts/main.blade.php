<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('/img/logo.png')}}">

    <title>@yield('judul')</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/timeline.css')}}" rel="stylesheet">
    <link href="{{ asset('css/startmin.css')}}" rel="stylesheet">
    <link href="{{ asset('css/morris.css')}}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">


    @yield('cssLuar')

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <ul class="nav navbar-nav navbar-left navbar-top-links">
                <li><a href="{{'/'}}"><i class="fa fa-home fa-fw"></i> Aplikasi Pengelolaan Administrasi Siswa</a></li>
            </ul>

            <ul class="nav navbar-right navbar-top-links">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> Setting <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> {{Auth::user()->name}}</a>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out fa-fw"></i>{{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <center>
                                <h4 class="d-inline-block"><i>APADS</i>
                                    <img src="{{ asset('/img/logo.png')}}" width="40" height="40" alt="">
                                </h4>
                            </center>
                        </li>
                        <li>
                            <a href="{{'/home'}}" class="@yield('dashboard')"><i class="fa fa-dashboard fa-fw"></i>
                                Dashboard</a>
                        </li>
                        <li>
                            <a href="{{'/tambah-siswa'}}" class="@yield('tambahSiswa')"><i class="fa fa-edit fa-fw"></i>
                                Tambah Data Siswa</a>
                        </li>
                        <li>
                            <a href="{{'/jurusan-students/'.'RPL'}}" class="@yield('halamanJurusan')"><i
                                    class="fa fa-graduation-cap"></i> Jurusan</a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{'/jurusan-students/'.'RPL'}}">Rekayasa Perangkat Lunak</a>
                                </li>
                                <li>
                                    <a href="{{'/jurusan-students/'.'TKJ'}}">Teknik Komputer Jaringan</a>
                                </li>
                                <li>
                                    <a href="{{'/jurusan-students/'.'KIMIA'}}">Kimia Industri</a>
                                </li>
                                <li>
                                    <a href="{{'/jurusan-students/'.'BDP'}}">Bisnis Dan Pemasaran</a>
                                </li>
                                <li>
                                    <a href="{{'/jurusan-students/'.'ATPH'}}">Agribisnis Tanaman Pangan Dan
                                        Horticultura</a>
                                </li>
                                <li>
                                    <a href="{{'/jurusan-students/'.'TEI'}}">Teknik Elektronik Industri</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="{{'/data-siswa'}}" class="@yield('dataSiswa')"><i class="fa fa-archive"></i>
                                Data Siswa</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">@yield('judulContent')</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.panel -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-clock-o fa-fw"></i> @yield('judulContent')
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="content">
                            @yield('content')
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    </div>
    </div>
    @yield('highcharts')

    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/metisMenu.min.js')}}"></script>
    <script src="{{ asset('js/raphael.min.js')}}"></script>
    <script src="{{ asset('js/morris.min.js')}}"></script>
    <script src="{{ asset('js/morris-data.js')}}"></script>
    <script src="{{ asset('js/startmin.js')}}"></script>
    <script src="{{ asset('js/html5shiv.min.js')}}"></script>
    <script src="{{ asset('js/respond.min.js')}}"></script>


</body>

</html>
