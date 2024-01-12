@extends('layouts.layoutUtama')

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
            <h1 class="judulHalaman">Profile</h1>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-8 pe-4">
                <div class="card my-table">
                    <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                        <div class="row">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2 pb-2 flex">
                                <div class="col-6 my-auto">
                                    <h6 class="text-white text-capitalize ps-3">Profile saya,</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="pe-2 float-end">
                                        <i class="bi bi-person text-white icon-table float-end"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @foreach ($mahasiswa as $mhs) --}}
                    <div class="card-body px-0 pb-2">
                        <div class="main-data-profile">
                            <div class="data-profile">
                                <label for="">E-Mail</label>
                                <input type="text" id="email" name="email" value="{{ Auth::user()->email }}"
                                    disabled>
                            </div>
                            <div class="data-profile">
                                <label for="">NIM</label>
                                <input type="text" id="nim" name="nim" value="{{ Auth::user()->nim }}"
                                    disabled>
                            </div>
                            <div class="data-profile">
                                <label for="">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" value="{{ Auth::user()->nama }}"
                                    disabled>
                            </div>
                            <div class="data-profile" id="profile-setengah">
                                <label for="">No. Handphone</label>
                                <input type="text" id="noHp" name="noHp" value="{{ Auth::user()->noHp }}"
                                    disabled>
                            </div>
                            <div class="data-profile" id="profile-setengah">
                                <label for="">Jenis Kelamin</label>
                                <input type="text" id="jenisKelamin" name="jenisKelamin"
                                    value="{{ Auth::user()->jenisKelamin }}" disabled>
                            </div>
                            <div class="data-profile" id="profile-setengah">
                                <label for="">Jumlah SKS</label>
                                <input type="text" id="jumlah_sks" name="jumlah_sks"
                                    value="{{ Auth::user()->jumlah_sks }}" disabled>
                            </div>
                            <div class="data-profile" id="profile-setengah">
                                <label for="">IPK (Contoh : 2.50)</label>
                                <input type="text" id="ipk" name="ipk" value="{{ Auth::user()->ipk }}"
                                    disabled>
                            </div>
                            {{-- <div class="data-profile">
                                <label for="">Alamat</label>
                                <input type="text" id="alamat" name="alamat" value="{{ Auth::User() -> nama}}" disabled>
                            </div> --}}
                        </div>
                    </div>
                    {{-- @endforeach --}}
                </div>
            </div>
            <div class="col-4">
                <div class="card my-table">
                    <div class="col-12 text-center mt-n5 bg-transparent">
                        @if (Auth::user()->foto)
                            <img class="position-relative collapsing avatar-xxl rounded-circle"
                                src="/image/Mahasiswa/{{ Auth::user()->foto }}">
                        @else
                            <img class="position-relative collapsing avatar-xxl rounded-circle"
                                src="/image/foto-profil-kosong.jpg" alt="">
                        @endif

                    </div>
                    <div class="card-body px-0">
                        <form action="{{ route('mahasiswa.uploadFoto') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="data-profile px-5 pb-4">
                                <input type="hidden" id="fotoLama" name="fotoLama" value={{ Auth::user()->foto }}>
                                <input type="file" id="foto" name="foto"
                                    class="form-control-sm  text-center @error('foto') is-invalid @enderror">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center pb-3 text-md">
                                <label for="">{{ Auth::user()->nama }}</label>
                            </div>
                            <div class="text-center text-md pb-3">
                                <label for="" class="">MAHASISWA</label>
                            </div>
                            <div class="text-center text-md">
                                @if (Auth::user()->foto)
                                    <button type="submit" class="btn btn-warning rounded-pill">UBAH FOTO</button>
                                @else
                                    <button type="submit" class="btn btn-success rounded-pill">TAMBAH FOTO</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
