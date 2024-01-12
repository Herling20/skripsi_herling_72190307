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
            <h1 class="judulHalaman">Data Mahasiswa</h1>
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
                                    <h6 class="text-white text-capitalize ps-3">Data Mahasiswa</h6>
                                </div>
                                <div class="col-6">
                                    <div class="pe-2">
                                        <i class="bi bi-people-fill text-white icon-table float-end"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header pt-3 pb-1">
                        <div class="row">
                            <div class="col-6 align-content-center p-pagination px-3">
                                {{ $mahasiswa->links('pagination::bootstrap-4') }}
                            </div>
                            <div class="col-6 text-end">
                                <a class="btn btn-success" href="{{ route('admin.tambahDataMahasiswa') }}">
                                    <i class="bi bi-plus-circle pe-1"></i>
                                    Tambah Mahasiswa
                                </a>
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
                                            NIM</th>
                                        <th
                                            class="co-3 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Nama Mahasiswa</th>
                                        <th
                                            class="text-center text-black text-uppercase  text-xs font-weight-bolder opacity-8">
                                            Dosen Pembimbing 1</th>
                                        <th
                                            class="text-center text-black text-uppercase  text-xs font-weight-bolder opacity-8">
                                            Dosen Pembimbing 2</th>
                                        <th
                                            class="col-1 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Jumlah Konsultasi</th>
                                        <th
                                            class="col-2 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataMahasiswa as $mhs)
                                        <tr class="">
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ ++$no }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-wrap text-black text-xs font-weight-bold">{{ $mhs->nim }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-wrap text-black text-xs font-weight-bold">{{ $mhs->nama }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @foreach ($mhs->dosen1 as $dp1)
                                                    <span
                                                        class="text-black text-xs font-weight-bold">{{ $dp1->nama }}</span>
                                                @endforeach
                                            </td>
                                            <td class="align-middle text-center">
                                                @foreach ($mhs->dosen2 as $dp2)
                                                    <span
                                                        class="text-black text-xs font-weight-bold">{{ $dp2->nama }}</span>
                                                @endforeach
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ $mhs->jumlah_konsultasi }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="text-xxs btn btn-info btn-sm bi bi-person-lines-fill"
                                                    href="{{ route('admin.detailDataMahasiswa', $mhs->id) }}">
                                                </a>
                                                <a class="text-xxs btn btn-warning btn-sm bi bi-pencil-square"
                                                    href="{{ route('admin.editDataMahasiswa', $mhs->id) }}">
                                                </a>
                                                <a class="text-xxs btn btn-danger btn-sm bi bi-trash3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapusDataMahasiswa{{ $mhs->id }}">
                                                </a>
                                                <div class="modal fade" id="hapusDataMahasiswa{{ $mhs->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-dark">Hapus Data Mahasiswa
                                                                </h5>
                                                                <button type="button"
                                                                    class="btn btn-link text-dark col-1 btn-lg"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="material-icons bi bi-x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('admin.hapusDataMahasiswa', $mhs->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="main-data-profile">
                                                                        <div class="data-profile text-center">
                                                                            <h6 class="text-dark w-100">Anda yakin untuk
                                                                                menghapus Data Mahasiswa ini ?</h6>
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
