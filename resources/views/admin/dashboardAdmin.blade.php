@extends('layouts.layoutUtama')

@section('adminChartBarJumlahMahasiswaBimbingan')
    <script src="{{ asset('achart/dist/apexcharts.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('achart/dist/apexcharts.css') }}" />
    <script>
        var options = {
            series: [],
            chart: {
                type: 'bar',
                width: '100%',
                height: '200px',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            colors: ['#FF0000', '#01A4FF', '#FCE205'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '25%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            title: {
                text: 'Jumlah Mahasiswa Tiap Dosen',
                align: 'Center',
                offsetX: 0,
                offsetY: 0,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            xaxis: {
                categories: @json($data['namaDosen']),
            },
            yaxis: {
                title: {
                    text: 'Jumlah Mahasiswa'
                }
            },
            fill: {
                opacity: 1
            },
            legend: {
                show: true,
                fontSize: '12px',
                position: 'top',
                horizontalAlign: 'right',
                offsetX: 0,
                offsetY: -35,
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " Mahasiswa"
                    }
                }
            }
        };

        @foreach ($data['dataJumlahMahasiswa'] as $angkatanData)
            options.series.push({
                name: 'Angkatan ' + '{{ $angkatanData['angkatan'] }}',
                data: @json($angkatanData['jumlah_mahasiswa'])
            });
        @endforeach

        var chart = new ApexCharts(document.querySelector("#barChartJumlahMhs"), options);
        chart.render();
    </script>
@endsection

@section('adminChartBarJumlahBimbinganDosen')
    <script src="{{ asset('achart/dist/apexcharts.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('achart/dist/apexcharts.css') }}" />
    <script>
        var options = {
            series: [{
                name: 'Jumlah Bimbingan Dosen',
                data: @json($data['dataJumlahBimbinganDosen']),
            }],
            chart: {
                type: 'bar',
                width: '100%',
                height: '200px',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '25%',
                    endingShape: 'rounded',
                    distributed: true,
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            title: {
                text: 'Jumlah Bimbingan Tiap Dosen',
                align: 'Center',
                offsetX: 0,
                offsetY: 0,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            xaxis: {
                categories: @json($data['namaDosen']),
            },
            yaxis: {
                title: {
                    text: 'Jumlah Bimbingan'
                }
            },
            fill: {
                opacity: 1
            },
            legend: {
                show: true,
                fontSize: '10px',
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " Kali"
                    }
                }
            }
        };

        // @foreach ($data['dataJumlahMahasiswa'] as $angkatanData)
        //     options.series.push({
        //         name: 'Angkatan ' + '{{ $angkatanData['angkatan'] }}',
        //         data: @json($angkatanData['jumlah_mahasiswa'])
        //     });
        // @endforeach

        var chart = new ApexCharts(document.querySelector("#barChartJumlahBimbinganDsn"), options);
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
            <a href="{{ route('admin.profil') }}" class="flex">
                <div class="img-fluid pe-3">
                    <img src="/image/Admin/{{ Auth::user()->foto }}" class="rounded-circle avatar">
                </div>
                <div class="pt-3">
                    <p href="#" class="text-black text-xs font-weight-bold mb-1">{{ Auth::user()->nama }}</p>
                    <p href="#" class="text-black text-xs font-weight-normal">Admin</p>
                </div>
            </a>
        </div>
        <div class="container">
            <div class="pt-1">
                <ul class="menu_item">
                    <li class="item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="{{ $halaman === 'dashboard' ? 'active' : '' }} link flex">
                            <i class="bi bi-bar-chart-line-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('admin.profil') }}"
                            class="{{ $halaman === 'profil' ? 'active' : '' }} link flex">
                            <i class="bi bi-person-fill"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('admin.tahunAjaran') }}"
                            class="{{ $halaman === 'tahun_ajaran' ? 'active' : '' }} link flex">
                            <i class="bi bi-calendar2-range-fill"></i>
                            <span>Tahun Ajaran</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('admin.dataMahasiswa') }}"
                            class="{{ $halaman === 'dataMahasiswa' ? 'active' : '' }} link flex">
                            <i class="bi bi-people-fill"></i>
                            <span>Data Mahasiswa</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('admin.dataDosen') }}"
                            class="{{ $halaman === 'dataDosen' ? 'active' : '' }} link flex">
                            <i class="bi bi-people-fill"></i>
                            <span>Data Dosen</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('admin.logout') }}" class="link flex">
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
                            <p class="text-sm mb-0 text-capitalize">Jumlah Mahasiswa</p>
                            <h4 class="mb-0">{{ $mahasiswaBimbingan }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2">
                        {{-- <div class="text-center">
                            <a href="" class="mb-0 text-xs font-weight-bolder text-black">More Info <i
                                    class="bi bi-arrow-right-circle-fill text-black"></i></a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-warning shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="bi bi-people-fill opacity-10"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Jumlah Dosen</p>
                            <h4 class="mb-0">{{ $dosen }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2">
                        {{-- <div class="text-center">
                            <a href="" class="mb-0 text-xs font-weight-bolder text-black">More Info <i
                                    class="bi bi-arrow-right-circle-fill text-black"></i></a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-success shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="bi bi-book-fill opacity-10"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Frekuensi Bimbingan</p>
                            <h4 class="mb-0">{{ $jumlahBimbingan }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="border-radius-lg pe-1">
                        <div class="py-3 px-2">
                            <div id="barChartJumlahMhs"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="border-radius-lg py-1">
                        <div class="py-3 px-2">
                            <div id="barChartJumlahBimbinganDsn"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-6">
                <div class="card">
                    <div class="border-radius-lg pe-1">
                        <div class="py-3 px-2">
                            <div id="barChart"></div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
