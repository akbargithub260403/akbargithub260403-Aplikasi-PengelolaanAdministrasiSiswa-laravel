@extends('layouts.main')
@section('judul','Halaman Dashboard')
@section('judulContent','Dashboard')
@section('dashboard','active')

@section('content')

<style>
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    #container {
        height: 400px;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

</style>

<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{count($jumlah_siswa)}}</div>
                        <div>Jumlah Siswa</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-folder-open fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{count($jumlah_administrasi)}}</div>
                        <div>Jumlah Administrasi</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{count($jumlah_admin)}}</div>
                        <div>Jumlah Admin</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- GRAFIK -->
<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        Jumlah Siswa Keseluruhan Sekolah Menengah Kejuruan Negeri 4 Padalarang. Berdasarkan Dara Siswa Per Jurusan
    </p>
</figure>

<script src="{{ asset('js/highcharts/highcharts.js')}}"></script>
<script src="{{ asset('js/highcharts/exporting.js')}}"></script>
<script src="{{ asset('js/highcharts/export-data.js')}}"></script>
<script src="{{ asset('js/highcharts/accessibility.js')}}"></script>
<script>
    Highcharts.chart('container', {

        chart: {
            type: 'column'
        },

        title: {
            text: 'Data Siswa SMKNN 4 PADALARANG'
        },

        xAxis: {
            categories: ['Jumlah Siswa Keseluruhan']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Jumlah Siswa'
            }
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>';
            }
        },

        plotOptions: {
            column: {

            }
        },

        series: [{
            name: 'RPL',
            data: [<?= count($RPL); ?>]
        }, {
            name: 'TKJ',
            data: [<?= count($TKJ); ?>]
        }, {
            name: 'KIMIA',
            data: [<?= count($KIMIA); ?>]
        }, {
            name: 'BDP',
            data: [<?= count($BDP); ?>]
        }, {
            name: 'ATPH',
            data: [<?= count($ATPH); ?>]
        }, {
            name: 'TEI',
            data: [<?= count($TEI); ?>]
        }]
    });

</script>
@endsection

