@extends('layouts.layoutUtama')

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
                        <a href="{{ route('admin.profil') }}" class="{{ $halaman === 'profil' ? 'active' : '' }} link flex">
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
            <h1 class="judulHalaman">Data Dosen</h1>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 pe-4">
                <div class="card my-table">
                    <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                        <div class="row">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2 pb-2 flex">
                                <div class="col-6 my-auto">
                                    <h6 class="text-white text-capitalize ps-3">Edit Data Dosen</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="pe-2 float-end">
                                        <i class="bi bi-person text-white icon-table float-end"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <form action="{{ route('admin.updateDataDosen', $dosen->id) }}" method="POST">
                            @csrf
                            <div class="main-data-profile">
                                <div class="data-profile w-55 pe-3">
                                    <label for="" class="text-start">Nama Dosen</label>
                                    <input type="text" name="nama" id="nama"
                                        class="text-sm form-control @error('nama') is-invalid @enderror"
                                        value="{{ $dosen->nama }}" placeholder="Masukkan Nama Dosen">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="data-profile w-45">
                                    <label for="" class="text-start">NIDN</label>
                                    <input type="text" name="nidn" id="nidn"
                                        class="text-sm form-control @error('nidn') is-invalid @enderror"
                                        value="{{ $dosen->nidn }}" placeholder="Masukkan NIDN">
                                    @error('nidn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="data-profile">
                                    <label for="" class="text-start">Email</label>
                                    <input type="text" name="email" id="email"
                                        class="text-sm form-control @error('email') is-invalid @enderror"
                                        value="{{ $dosen->email }}" placeholder="Masukkan Email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="data-profile w-50">
                                    <label for="" class="text-start">Password</label>
                                    <input type="text" name="password" id="password"
                                        class="text-sm form-control @error('password') is-invalid @enderror"
                                        value="{{ $dosen->password }}" placeholder="Masukkan Password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <div class="data-profile w-50 pe-3">
                                    <label for="" class="text-start">No. Handphone</label>
                                    <input type="text" name="noHp" id="noHp"
                                        class="text-sm form-control @error('noHp') is-invalid @enderror"
                                        value="{{ $dosen->noHp }}" placeholder="Masukkan No. Handphone">
                                    @error('noHp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="dropdown-dosen w-50">
                                    <label for="" class="text-start">Jenis Kelamin</label>
                                    <select name="jenisKelamin" id="jenisKelamin"
                                        class="form-select @error('jenisKelamin') is-invalid @enderror">
                                        <option value="">--- Pilih Jenis Kelamin ---</option>
                                        <option value="Laki - Laki"
                                            {{ $dosen->jenisKelamin == 'Laki - Laki' ? 'selected' : '' }}>Laki - Laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ $dosen->jenisKelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenisKelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="w-90 text-end pe-2">
                                    <button type="submit" class="btn btn-warning">Ubah</button>
                                </div>
                                <div class="w-10 text-end">
                                    <a href="{{ route('admin.dataDosen') }}" class="btn btn-info">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
