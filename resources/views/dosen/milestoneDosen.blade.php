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
            <h1 class="judulHalaman">Milestone</h1>
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
                                    <h6 class="text-white text-capitalize ps-3">Milestone</h6>
                                </div>
                                <div class="col-6">
                                    <div class="pe-2">
                                        <i class="bi bi-flag-fill text-white icon-table float-end"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- - Tambah Milestone - --}}
                    <div class="card-header pt-3 pb-1">
                        <div class="row">
                            <div class="col-6 align-content-center px-3 pt-3 text-sm">
                                @foreach ($tahunAjaran as $mlstn)
                                    <span class="text-bold">Tanggal Berakhir Milestone : {{ date('d M Y', strtotime($mlstn->tanggalSelesai)) }}</span>
                                @endforeach
                            </div>
                            <div class="col-6 text-end">
                                <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahMilestone">
                                    <i class="bi bi-plus-circle pe-1"></i>
                                    Tambah Milestone
                                </a>
                                @include('dosen.modal_milestone.tambah_milestone')
                            </div>
                        </div>
                    </div>
                    {{-- - End Tambah Milestone - --}}

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="dataMilestone" class="table align-items-center mb-0">
                                <thead>
                                    <tr class="">
                                        <th
                                            class="col-1 text-center text-uppercase text-black text-xs font-weight-bolder opacity-8">
                                            No</th>
                                        <th
                                            class="col-1 text-center text-uppercase text-black text-xs font-weight-bolder opacity-8">
                                            Semester</th>
                                        {{-- <th
                                            class="col-1 text-center text-uppercase text-black text-xs font-weight-bolder opacity-8">
                                            Tanggal Berakhir</th> --}}
                                        <th
                                            class="text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Nama Milestone</th>
                                        <th
                                            class="col-1 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Persen</th>
                                        <th
                                            class="col-2 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 0;
                                    @endphp
                                    @foreach ($milestone as $mlstn)
                                        <tr>
                                            <td class="text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ ++$no }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ $mlstn->semester }}</span>
                                            </td>
                                            {{-- <td class="text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ date('d M Y', strtotime($mlstn->tanggalBerakhir)) }}</span>
                                            </td> --}}
                                            <td class="w-100 text-justify">
                                                <span
                                                    class="text-wrap text-black text-xs font-weight-bolder">{{ $mlstn->namaMilestone }}</span>
                                                {{-- <input type="text"
                                                    class="text-black text-xs font-weight-bold text-wrap w-100 bg-transparent border-0"
                                                    name="namaMilestone" id="namaMilestone" placeholder="Isi Nama Milestone"
                                                    value="{{ $mlstn->namaMilestone }}" disabled> --}}
                                            </td>
                                            <td class="">
                                                <input type="text"
                                                    class="text-black text-xs font-weight-bold text-center bg-transparent border-0"
                                                    name="bobot" id="bobot" placeholder="Persen"
                                                    value="{{ $mlstn->bobot }}" disabled>
                                            </td>
                                            <td class="text-center py-1">
                                                {{-- - Edit Milestone - --}}
                                                <a class="edit text-xxs btn btn-warning btn-sm bi bi-pencil-square"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editMilestone{{ $mlstn->id }}">
                                                </a>
                                                @include('dosen.modal_milestone.edit_milestone')

                                                <a class="text-xxs btn btn-danger btn-sm bi bi-trash3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapusMilestone{{ $mlstn->id }}">
                                                </a>
                                                <div class="modal fade" id="hapusMilestone{{ $mlstn->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-dark">Hapus Milestone
                                                                </h5>
                                                                <button type="button"
                                                                    class="btn btn-link text-dark col-1 btn-lg"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="material-icons bi bi-x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('hapusMilestone.dosen', $mlstn->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="main-data-profile">
                                                                        <div class="data-profile text-center">
                                                                            <h6 class="text-dark w-100">Anda yakin untuk
                                                                                menghapus milestone ini ?</h6>
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
                                                {{-- - End Hapus Milestone - --}}
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
    @include('dosen.modal_milestone.script_editMilestone')
@endsection
