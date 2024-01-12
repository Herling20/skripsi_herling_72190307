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
@php
    $cekACC = 0;
    $counter = 0;
@endphp
@section('dashboard')
    <nav class="navbar navbar-expand-sm shadow-none pe-6 border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="judul">
            <div class="square"></div>
            <h1 class="judulHalaman">Milestone</h1>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 pe-5">
                <div class="card my-table">
                    <div class="card-header p-0 position-relative mt-n4 mx-4 z-index-2">
                        <div class="row">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2 pb-2 flex">
                                <div class="col-6 my-auto">
                                    <h6 class="text-white text-capitalize ps-3">Milestone Mahasiswa</h6>
                                </div>
                                <div class="col-6">
                                    <div class="pe-2">
                                        <i class="bi bi-flag-fill text-white icon-table float-end"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="me-4 my-2 text-end">
                        <a class="btn btn-success" href="{{ route('mahasiswa.cetakKonsultasi') }}">
                            <i class="bi bi-file-earmark-arrow-down pe-1"></i>
                            Download Log Book
                        </a>
                    </div>
                    <div class="card-body px-0 pt-1 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr class="">
                                        <th
                                            class="col-1 text-center text-uppercase text-black text-xs font-weight-bolder opacity-8">
                                            No</th>
                                        <th
                                            class=" text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Nama Milestone</th>
                                        <th
                                            class="col-2 text-center text-black text-uppercase text-wrap text-xs font-weight-bolder opacity-8">
                                            Jumlah Bimbingan Dosen Pembimbing 1</th>
                                        <th
                                            class="col-2 text-center text-black text-uppercase text-wrap text-xs font-weight-bolder opacity-8">
                                            Jumlah Bimbingan Dosen Pembimbing 2</th>
                                        <th
                                            class="col-2 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Bimbingan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    @foreach ($hasil as $mlstn)
                                        @php
                                            $counter += 1;
                                        @endphp
                                        <tr class="">
                                            <td class="text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ ++$no }}</span>
                                            </td>
                                            <td class="py-1">
                                                <span
                                                    class="text-wrap text-black text-xs font-weight-bold">{{ $mlstn->namaMilestone }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-black text-xs font-weight-bold">
                                                    {{ $mlstn->konsultasiDP1->count() }}
                                                </span>
                                                <span class="text-black text-xs font-weight-bold"></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-black text-xs font-weight-bold">
                                                    {{ $mlstn->konsultasiDP2->count() }}
                                                </span>
                                            </td>
                                            <td id="text-wrap-normal" class="text-center py-1">
                                                {{-- <a id="text-wrap-normal" class="btn btn-info text-xxs"
                                                    href="" data-bs-toggle="modal"
                                                    data-bs-target="#ajukanBimbingan{{ $mlstn->id }}">Ajukan
                                                </a> --}}
                                                @if ($mlstn->ACC == 1)
                                                    <button disabled class="btn btn-success text-xxs opacity-10">Selesai</button>
                                                    @php
                                                        $cekACC = 1;
                                                    @endphp
                                                @else
                                                    @if ($mlstn->expired)
                                                        <button disabled class="btn btn-dark text-xxs opacity-8">Waktu Berakhir</button>
                                                    @elseif ($cekACC == 1 || $counter == 1)
                                                        <button rel="tooltip" id="text-wrap-normal"
                                                            class="btn btn-info text-xxs" href=""
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#ajukanBimbingan{{ $mlstn->id }}">
                                                            Ajukan
                                                        </button>
                                                        @php
                                                            $cekACC = 0;
                                                        @endphp
                                                    @else
                                                        <button disabled class="btn btn-dark text-xxs opacity-8">Belum dapat mengajukan</button>
                                                    @endif
                                                @endif

                                                <div class="modal fade" id="ajukanBimbingan{{ $mlstn->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-dark">Pengajuan Bimbingan</h5>
                                                                <button type="button"
                                                                    class="tombol_tutup btn btn-link text-dark col-1 btn-lg"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="material-icons bi bi-x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('mahasiswa.ajukanBimbingan') }}"
                                                                    method="POST" id="ajukanBimbinganForm"
                                                                    class="ajukanBimbinganForm">
                                                                    @csrf
                                                                    <input type="hidden" name="milestone_id"
                                                                        id="milestone_id" value="{{ $mlstn->id }}">
                                                                    <div class="data-profile">
                                                                        <label for=""
                                                                            class="text-dark text-start">Milestone</label>
                                                                        <input type="text" name="namaMilestone"
                                                                            value="{{ $mlstn->namaMilestone }}"
                                                                            class="text-sm" disabled>
                                                                    </div>
                                                                    <div class="data-profile">
                                                                        <label for=""
                                                                            class="text-dark text-start">Judul
                                                                            Skripsi</label>
                                                                        <textarea name="judulSkripsi" id="" class="pe-3 text-justify" disabled>{{ Auth::user()->judul }}</textarea>
                                                                    </div>
                                                                    <div class="dropdown-dosen">
                                                                        <label for="" class="text-dark">Kepada
                                                                            Dosen Pembimbing</label>
                                                                        <select name="bimbingan_id" id="bimbingan_id"
                                                                            class="form-select text-center">
                                                                            <option value="">--- Pilih Pembimbing ---
                                                                            </option>
                                                                            @foreach ($dosenPembimbing1 as $dp1)
                                                                                <option value="{{ $dp1->bimbingan_id }}">
                                                                                    {{ $dp1->nama }}</option>
                                                                            @endforeach
                                                                            @foreach ($dosenPembimbing2 as $dp2)
                                                                                <option value="{{ $dp2->bimbingan_id }}">
                                                                                    {{ $dp2->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="data-profile">
                                                                        <label for=""
                                                                            class="text-dark text-start">Deskripsi</label>
                                                                        <input type="text" name="deskripsiPengajuan"
                                                                            id="deskripsiPengajuan" class="text-sm">
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-success float-end">Ajukan</button>
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
    <script>
        $(document).ready(function() {
            $(document).on('submit', '.ajukanBimbinganForm', function(e) {
                e.preventDefault();

                var form = $(this);
                var dataPengajuan = form.serializeArray();
                var modalId = form.closest('.modal').attr('id'); // Get the ID of the closest modal

                console.log(dataPengajuan);

                var errorMessages = [];

                $.ajax({
                    type: "POST",
                    url: '{{ route('mahasiswa.ajukanBimbingan') }}',
                    data: dataPengajuan,
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 'sukses') {
                            $('.tombol_tutup').click();
                            $('#ajukanBimbinganForm')[0].reset();
                            $('.table-responsive').load(location.href + ' .table-responsive');
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Berhasil mengajukan bimbingan.",
                                icon: "success",
                                confirmButtonText: 'Kembali',
                                timer: 1500,
                            });
                        }
                        // console.log(total);
                    },
                    error: function(errors) {
                        var error = errors.responseJSON;
                        console.log(error);

                        $.each(error.errors, function(elementId, message) {
                            appendErrorMessage('#' + modalId + ' #' + elementId,
                                message, errorMessages); // Update the selector
                            // appendErrorMessage('#' + elementId, message);

                        });

                        // Function to append error messages
                        function appendErrorMessage(elementId, message) {
                            if ($(elementId).siblings('.error-message').length === 0) {
                                $(elementId).addClass('is-invalid');
                                $(elementId).after(
                                    '<span class="text-danger text-sm pt-1 font-weight-normal error-message">' +
                                    message +
                                    '</span>');
                                errorMessages.push(message);
                                event.preventDefault();
                            }
                        }


                        // Event listener to remove error message when the corresponding input field is filled
                        $('#bimbingan_id, #deskripsiPengajuan')
                            .on('input',
                                function() {
                                    var inputId = '#' + $(this).attr('id');
                                    if ($(inputId).val().trim() !== '') {
                                        $(inputId).removeClass('is-invalid');
                                        $(inputId).siblings('.error-message').remove();
                                    }
                                });
                    }
                });
            });
        });
    </script>
@endsection
