@extends('layouts.layoutUtama')

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
            <h1 class="judulHalaman">Mahasiswa</h1>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            @foreach ($mahasiswa as $mhs)
                <div class="col-cardMhs mb-3">
                    <a class="card" href="{{ route('dosen.detailMahasiswaDosen', $mhs->id) }}">
                        <div class="p-3 pt-2">
                            <div class="pt-2">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td rowspan="3">
                                                @if ($mhs->foto)
                                                    <img class="img-mahasiswaDosen"
                                                        src="/image/Mahasiswa/{{ $mhs->foto }}" alt="">
                                                @else
                                                    <img class="img-mahasiswaDosen" src="/image/foto-profil-kosong.jpg"
                                                        alt="">
                                                @endif
                                            </td>
                                            <td class="info-mahasiswa">
                                                <Label class="text-bold text-black" for="nama">Nama :</Label>
                                                <br>
                                                <label class="text-normal text-black"
                                                    for="">{{ $mhs->nama }}</label>
                                            </td>
                                            {{-- <td class="progress-mahasiswa text-center" rowspan="3">
                                                <span class="judulProgress-mahasiswaDosen text-black ">Progress</span>
                                                <div class="circular-progress-mahasiswaDosen">
                                                    <span class="progress-value">0%</span>
                                                </div> --}}
                                            {{-- <div id="progressMahasiswaChart">
                                                
                                            </div> --}}
                                            {{-- </td> --}}
                                        </tr>
                                        <tr>
                                            <td class="info-mahasiswa">
                                                <Label class="text-bold text-black" for="nama">Angkatan :</Label>
                                                <br>
                                                <label for="" class="text-black">{{ $mhs->angkatan }}</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-mahasiswa">
                                                <Label class="text-bold text-black" for="nama">Jumlah Konsultasi
                                                    :</Label>
                                                <br>
                                                <label for=""
                                                    class="text-black">{{ $mhs->jumlah_konsultasi }}</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
