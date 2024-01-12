@extends('layouts.layoutUtama')

@section('progressBarMahasiswa')
    <script src="{{ asset('achart/dist/apexcharts.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('achart/dist/apexcharts.css') }}" />
    <script>
        var options = {
            title: {
                text: 'Progress',
                align: 'Center',
                offsetX: 0,
                offsetY: 2,
                style: {
                    fontSize: '18px',
                    fontWeight: 'bold',
                }
            },
            series: [{{ $pencapaian }}],
            chart: {
                height: 300,
                width: '100%',
                type: 'radialBar',
                // style : {
                //     position: 'right',
                // }
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '50%',
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: 4,
                            fontSize: '18px',
                        }
                    }
                }
            },
            colors: ['#FF0000'],
        };
        var chart = new ApexCharts(document.querySelector("#progressBarMhs"), options);
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
            <a href="{{ route('mahasiswa.profil') }}" class="flex">
                <div class="img-fluid pe-3">
                    @if (Auth::user()->foto)
                        <img src="/image/Mahasiswa/{{ Auth::user()->foto }}" class="rounded-circle avatar">
                    @else
                        <img class="rounded-circle avatar" src="/image/foto-profil-kosong.jpg" alt="">
                    @endif
                </div>
                <div class="pt-3">
                    <p href="#" class="text-black text-xs font-weight-bold mb-1">{{ Auth::user()->nama }}</p>
                    <p href="#" class="text-black text-xs font-weight-normal">Mahasiswa</p>
                </div>
            </a>
        </div>
        <div class="container">
            <div class="pt-1">
                <ul class="menu_item">
                    <li class="item">
                        <a href="{{ route('mahasiswa.home') }}" class="{{ $halaman === 'home' ? 'active' : '' }} link flex">
                            <i class="bi bi-house-door-fill"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('mahasiswa.profil') }}"
                            class="{{ $halaman === 'profil' ? 'active' : '' }} link flex">
                            <i class="bi bi-person-fill"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('mahasiswa.milestone') }}"
                            class="{{ $halaman === 'milestone' ? 'active' : '' }} link flex">
                            <i class="bi bi-flag-fill"></i>
                            <span>Milestone</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('mahasiswa.logout') }}" class="link flex">
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
            <h1 class="judulHalaman">Home</h1>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 pe-5">
                <div class="">
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table-border align-items-center mb-0">
                                <tr>
                                    <td class="user-fotoProfil" rowspan="4">
                                        @if (Auth::user()->foto)
                                            <img class="fotoProfil" src="/image/Mahasiswa/{{ Auth::user()->foto }}"
                                                alt="">
                                        @else
                                            <img class="fotoProfil" src="/image/foto-profil-kosong.jpg" alt="">
                                        @endif
                                    </td>
                                    <td class="user-info-nama">
                                        <Label for="nama">Nama</Label>
                                        <br>
                                        <input type="text" name="" id="nama" class="opacity-10"
                                            value="{{ Auth::user()->nama }}" disabled>
                                    </td>
                                    <td class="user-info-nim">
                                        <label for="NIM">NIM</label>
                                        <br>
                                        <input type="text" name="" id="nim" value="{{ Auth::user()->nim }}"
                                            disabled>
                                    </td>
                                    <td class ="progress-pengerjaan" rowspan="4">
                                        <div class="progress-circular">
                                            {{-- <span class="judulProgress">Progress Pengerjaan</span>
                                            <div class="circular-progress">
                                                <span class="progress-value">0%</span>
                                            </div> --}}

                                            <div id="progressBarMhs">

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="user-info-ipk">
                                        <label for="ipk">IPK</label>
                                        <br>
                                        <input type="text" name="" id="ipk" value="{{ Auth::user()->ipk }}"
                                            disabled>
                                    </td>
                                    <td class="user-info-periode">
                                        <label for="periode">Periode :</label>
                                        <br>
                                        <input type="text" name="" id="periode"
                                            value="{{ date('Y', strtotime(Auth::user()->periode->tanggalMulai)) }} / {{ date('Y', strtotime(Auth::user()->periode->tanggalMulai)) + 1 }}"
                                            disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="user-info-judul">
                                        <label for="judulSkripsi">Judul Skripsi</label><br>
                                        <textarea name="judulSkripsi" id="" class="pe-3 text-justify" disabled>{{ Auth::user()->judul }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="user-info-dp">
                                        <label for="dosenPembimbing1">Dosen Pembimbing 1</label>
                                        <br>
                                        @foreach ($dosenPembimbing1 as $dp1)
                                            <input type="text" name="" id="dosenPembimbing2"
                                                value="{{ $dp1->nama }}" disabled>
                                        @endforeach
                                    </td>
                                    <td class="user-info-dp">
                                        <label for="dosenPembimbing2">Dosen Pembimbing 2</label>
                                        <br>
                                        @foreach ($dosenPembimbing2 as $dp2)
                                            <input type="text" name="" id="dosenPembimbing2"
                                                value="{{ $dp2->nama }}" disabled>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== Bagian Table ======= -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 pe-5">
                <div class="card my-table">
                    <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                        <div class="row">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2 pb-2 flex">
                                <div class="col-6 my-auto">
                                    <h6 class="text-white text-capitalize ps-3">Riwayat Bimbingan</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="pe-2 float-end">
                                        <i class="bx bx-history text-white icon-table float-end"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header  pt-3 pb-1">
                        <div class="pb-0 px-3">
                            {{ $riwayatBimbingan->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                    <div class="card-body pt-0 px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr class="">
                                        <th
                                            class="text-center text-uppercase text-black text-xs font-weight-bolder opacity-8">
                                            No</th>
                                        <th
                                            class="text-center text-uppercase text-black  text-xs font-weight-bolder opacity-8">
                                            Tanggal Pengajuan</th>
                                        <th
                                            class="text-center text-uppercase text-black  text-xs font-weight-bolder opacity-8">
                                            Milestone</th>
                                        <th
                                            class="text-center text-uppercase text-black  text-xs font-weight-bolder opacity-8">
                                            Dosen Pembimbing</th>
                                        <th
                                            class="text-center text-uppercase text-black  text-xs font-weight-bolder opacity-8">
                                            Tanggal Bimbingan</th>
                                        <th
                                            class="text-center text-uppercase text-black  text-xs font-weight-bolder opacity-8">
                                            Jam</th>
                                        <th
                                            class="text-center text-uppercase text-black  text-xs font-weight-bolder opacity-8">
                                            Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayatBimbingan as $riwayat)
                                        <tr class="">
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ ++$no }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ date('d M Y', strtotime($riwayat->tanggalPengajuan)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span id=""
                                                    class="text-wrap text-black text-xs font-weight-bold">{{ $riwayat->namaMilestone }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ $riwayat->namaDosen }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($riwayat->tanggalBimbingan != null)
                                                    <span
                                                        class="text-black text-xs font-weight-bold">{{ Carbon\Carbon::parse($riwayat->tanggalBimbingan)->translatedFormat('l\, d M Y') }}</span>
                                                @else
                                                    <span class="text-black text-xs font-weight-bold">Belum
                                                        ditentukan</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($riwayat->tanggalBimbingan != null)
                                                    <span
                                                        class="text-black text-xs font-weight-bold">{{ Carbon\Carbon::parse($riwayat->tanggalBimbingan)->translatedFormat('H:i T') }}</span>
                                                @else
                                                    <span class="text-black text-xs font-weight-bold">Belum
                                                        ditentukan</span>
                                                @endif
                                            </td>
                                            <td id="" class="text-center">
                                                @if ($riwayat->statusBimbingan == 'Menunggu')
                                                    <a class="text-xxs btn btn-warning">Menunggu</a>
                                                @elseif ($riwayat->statusBimbingan == 'Disetujui')
                                                    @if ($riwayat->jamMulai == null)
                                                        <a class="text-xxs btn btn-success" disabled>Diterima</a>
                                                    @elseif($riwayat->jamSelesai == null)
                                                        <a class="text-xxs btn btn-warning">Sedang Berlangsung</a>
                                                    @elseif($riwayat->jamSelesai != null)
                                                        <a class="text-xxs btn btn-info" data-bs-toggle="modal"
                                                            data-bs-target="#detailBimbingan{{ $riwayat->id }}">Detail</a>
                                                        @include('mahasiswa.modal_mahasiswa.detailBimbingan')
                                                    @endif
                                                @else
                                                    <a class="text-xxs btn btn-danger" disabled>Ditolak</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== End Tabel ======= -->
@endsection
