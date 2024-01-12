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
                        <a href="{{ route('admin.profil') }}"
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
            <h1 class="judulHalaman">Tahun Ajaran</h1>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card my-table">
                    <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                        <div class="row">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2 pb-2 flex">
                                <div class="col-6 my-auto">
                                    <h6 class="text-white text-capitalize ps-3">Tahun Ajaran</h6>
                                </div>
                                <div class="col-6">
                                    <div class="pe-2">
                                        <i class="bi bi-calendar2-range-fill text-white icon-table float-end"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header pt-3 pb-1">
                        <div class="row">
                            <div class="col-6 align-content-center p-pagination px-3">
                                {{-- {{ $mahasiswa->links('pagination::bootstrap-4') }} --}}
                            </div>
                            <div class="col-6 text-end">
                                <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahTahunAjaran">
                                    <i class="bi bi-plus-circle pe-1"></i>
                                    Tambah Tahun Ajaran
                                </a>
                                @include('admin.modal_admin.tambah_tahunAjaran')
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-0 pt-1 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr class="">
                                        <th
                                            class="text-center text-uppercase text-black text-xs font-weight-bolder opacity-8">
                                            No</th>
                                        <th
                                            class="col-1 text-center text-black text-uppercase  text-xs font-weight-bolder opacity-8">
                                            Semester</th>
                                        <th
                                            class="co-3 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Tahun</th>
                                        <th
                                            class="text-center text-black text-uppercase  text-xs font-weight-bolder opacity-8">
                                            Tanggal Mulai</th>
                                        <th
                                            class="text-center text-black text-uppercase  text-xs font-weight-bolder opacity-8">
                                            Tanggal Selesai</th>
                                        <th
                                            class="col-2 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Status</th>
                                        <th
                                            class="col-2 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 0;
                                    @endphp
                                    @foreach ($tahunAjaran as $tAjaran)
                                        <tr class="">
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ ++$no }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-wrap text-black text-xs font-weight-bold">{{ $tAjaran->semester }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-wrap text-black text-xs font-weight-bold">{{ $tAjaran->tahun }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ Carbon\Carbon::parse($tAjaran->tanggalMulai)->translatedFormat('l\, d M Y') }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ Carbon\Carbon::parse($tAjaran->tanggalSelesai)->translatedFormat('l\, d M Y') }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($tAjaran->status == 'Aktif')
                                                    <a class="badge bg-success">Aktif</a>
                                                @else
                                                    <a class="badge bg-danger">Tidak Aktif</a>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($tAjaran->status == 'Tidak Aktif')
                                                    <a class="text-xxs btn btn-success btn-sm bi bi-check-circle"
                                                        data-bs-toggle="modal" data-bs-target="#aktifTahunAjaran{{ $tAjaran->id }}">
                                                    </a>
                                                    @include('admin.modal_admin.aktifTahunAjaran')
                                                @else
                                                @endif
                                                <a class="text-xxs btn btn-warning btn-sm bi bi-pencil-square"
                                                    data-bs-toggle="modal" data-bs-target="#editTahunAjaran{{ $tAjaran->id }}">
                                                </a>
                                                @include('admin.modal_admin.editTahunAjaran')
                                                <a class="text-xxs btn btn-danger btn-sm bi bi-trash3"
                                                    data-bs-toggle="modal" data-bs-target="#hapusTahunAjaran{{ $tAjaran->id }}">
                                                </a>
                                                <div class="modal fade" id="hapusTahunAjaran{{ $tAjaran->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-dark">Hapus Tahun Ajaran
                                                                </h5>
                                                                <button type="button"
                                                                    class="btn btn-link text-dark col-1 btn-lg"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="material-icons bi bi-x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.hapusTahunAjaran', $tAjaran->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="main-data-profile">
                                                                        <div class="data-profile text-center">
                                                                            <h6 class="text-dark w-100">Anda yakin untuk
                                                                                menghapus Tahun Ajaran ini ?</h6>
                                                                        </div>
                                                                        <div class="w-50">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">HAPUS</button>
                                                                        </div>
                                                                        <div class="w-50">
                                                                            <button type="button" class="btn btn-info"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close">BATAL</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
@endsection
