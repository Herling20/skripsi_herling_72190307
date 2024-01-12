@extends('layouts.layoutUtama')

@section('chartJumlahBimbinganDsn')
    <script src="{{ asset('achart/dist/apexcharts.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('achart/dist/apexcharts.css') }}" />
    <script>
        // var selisihWaktuData = {!! json_encode($data['dataWaktubimbingan']->pluck('selisih_waktu')) !!};
        // var selisihWaktuData = {!! json_encode($data['dataWaktubimbingan']->pluck('selisih_waktu')) !!};
        var options = {
            series: [],
            colors: ['#008000', '#00BFFF', '#FCE205', '#FF0000', '#00FF00', '#bf00ff', '#C0C0C0', '#ff7f00 ', '#4169E1',
                '#f534b3', '#964b00 ', '#ffff00 '
            ],
            chart: {
                type: 'bar',
                height: '200px',
                stacked: true,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        position: 'bottom',
                        offsetX: -10,
                        offsetY: 0
                    }
                }
            }],
            plotOptions: {
                bar: {
                    horizontal: false,
                    borderRadius: 10,
                    columnWidth: '45%',
                    dataLabels: {
                        total: {
                            enabled: true,
                            style: {
                                fontSize: '12px',
                                fontWeight: 900
                            },
                            formatter: function(val) {
                                return val + " bimbingan"
                            }
                        }
                    }
                },
            },
            title: {
                text: 'Jumlah Bimbingan Tiap Bulan Mahasiswa',
                align: 'Center',
                offsetX: 0,
                offsetY: 0,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            xaxis: {
                categories: @json($namaMahasiswa),
            },
            yaxis: {
                title: {
                    text: 'Jumlah Bimbingan'
                },
                distributed: true,
            },
            legend: {
                position: 'right',
                offsetY: 0,
                fontSize: '12px',
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " bimbingan"
                    }
                }
            }
        };

        @foreach ($dataSeries as $dsKey => $dsValue)
            @foreach ($dsValue as $month => $monthValue)
                options.series.push({
                    name: '{{ $month }}',
                    data: @json($monthValue)
                });
            @endforeach
        @endforeach

        var chart = new ApexCharts(document.querySelector("#barChartJumlahBimbingan"), options);
        chart.render();
    </script>
@endsection

@section('chartTahapanMilestoneDsn')
    <script>
        var options = {
            series: [{
                name: 'Tahap Milestone',
                data: @json($capaianMilestone),
            }],
            chart: {
                type: 'bar',
                height: '200px',
                toolbar: {
                    show: false
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '30%',
                    endingShape: 'rounded',
                    distributed: true,
                },
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        position: 'bottom',
                        offsetX: -10,
                        offsetY: 0
                    }
                }
            }],
            title: {
                text: 'Tahapan Milestone Mahasiswa',
                align: 'Center',
                offsetX: 0,
                offsetY: 0,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($namaMahasiswa),
            },
            yaxis: {
                title: {
                    text: 'Tahap Milestone'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#barChartTahapMilestone"), options);
        chart.render();
    </script>
@endsection

@section('sidebar')
    <nav class="sidebar">
        <div class="logo_items flex">
            <span class="nav_image">
                <img src="/image/logo.svg" alt="logo_img" />
            </span>
        </div>
        <div class="flex justify-content-around w-85 mx-3 mt-3 pb-2 border-bottom border-black">
            <a href="{{ route('dosen.profil') }}" class="flex">
                <div class="img-fluid pe-3">
                    @if (Auth::user()->foto)
                        <img src="/image/Dosen/{{ Auth::user()->foto }}" class="rounded-circle avatar">
                    @else
                        <img class="rounded-circle avatar" src="/image/foto-profil-kosong.jpg" alt="">
                    @endif
                </div>
                <div class="pt-3">
                    <p href="#" class="text-black text-xs font-weight-bold mb-1">{{ Auth::user()->nama }}</p>
                    <p href="#" class="text-black text-xs font-weight-normal">Dosen</p>
                </div>
            </a>
        </div>
        <div class="container">
            <div class="pt-1">
                <ul class="menu_item">
                    <li class="item">
                        <a href="{{ route('dosen.dashboard') }}"
                            class="{{ $halaman === 'dashboard' ? 'active' : '' }} link flex">
                            <i class="bi bi-bar-chart-line-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('dosen.profil') }}" class="{{ $halaman === 'profil' ? 'active' : '' }} link flex">
                            <i class="bi bi-person-fill"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('dosen.mahasiswa') }}"
                            class="{{ $halaman === 'mahasiswa' ? 'active' : '' }} link flex">
                            <i class="bi bi-people-fill"></i>
                            <span>Mahasiswa</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('dosen.milestone') }}"
                            class="{{ $halaman === 'milestone' ? 'active' : '' }} link flex">
                            <i class="bi bi-flag-fill"></i>
                            <span>Milestone</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('dosen.bimbingan') }}"
                            class="{{ $halaman === 'bimbingan' ? 'active' : '' }} link flex">
                            <i class="bi bi-journals"></i>
                            <span>Bimbingan</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('dosen.logout') }}" class="link flex">
                            @method('POST')
                            <i class="bx bx-log-out"></i>
                            <span>Log out</span>
                        </a>
                    </li>
                </ul>
            </div>
    </nav>
@endsection

@section('dashboard')
    <nav class="navbar navbar-expand-sm shadow-none pe-6 border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="judul">
            <div class="square"></div>
            <h1 class="judulHalaman">Dashboard</h1>
        </div>
    </nav>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-primary shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="bi bi-people-fill opacity-10"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Mahasiswa Bimbingan</p>
                            @foreach ($mahasiswaBimbingan as $mb)
                                <h4 class="mb-0">{{ $mb->mahasiswaBimbingan }}</h4>
                            @endforeach
                            {{-- <p class="text-xxs mb-0 text-capitalize">Tahun Ajaran Sem.{{ $tahunAjaranAktif->semester }} {{ $tahunAjaranAktif->tahun }}/{{ $tahunAjaranAktif->tahun + 1 }} </p> --}}
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2">
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-success shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="bi bi-flag-fill opacity-10"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Jumlah Milestone</p>
                            @foreach ($jumlahMilestone as $jm)
                                <h4 class="mb-0">{{ $jm->jumlah_milestone }}</h4>
                            @endforeach
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2">
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pb-card pt-2">
                        <div class="text-start pt-1">
                            <p class="text-sm mb-0 text-capitalize">Jumlah Milestone</p>
                            @foreach ($dataMahasiswa as $dm)
                                <p class="text-xxs mb-0 text-bold">Angkatan {{ $dm->angkatan }} :
                                    {{ $dm->jumlah_mahasiswa }} </p>
                            @endforeach
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2">
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="border-radius-lg pe-1">
                        <div class="py-3 px-2">
                            <div id="barChartJumlahBimbingan"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="border-radius-lg py-1">
                        <div class="pt-3 pb-2 px-2">
                            <div id="barChartTahapMilestone"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
