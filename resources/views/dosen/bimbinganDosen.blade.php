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
            <h1 class="judulHalaman">Bimbingan</h1>
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
                                    <h6 class="text-white text-capitalize ps-3">Bimbingan</h6>
                                </div>
                                <div class="col-6">
                                    <div class="pe-2">
                                        <i class="bi bi-journals text-white icon-table float-end"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header  pt-3 pb-1">
                        <div class="pb-0 px-3">
                            {{ $detailBimbingan->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                    <div class="card-body pt-0 px-0 pb-1">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr class="">
                                        <th
                                            class="text-center text-uppercase text-black text-xs font-weight-bolder opacity-8">
                                            No</th>
                                        <th
                                            class="col-1 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Tanggal Pengajuan</th>
                                        <th
                                            class="col-4 text-center text-black text-uppercase  text-xs font-weight-bolder opacity-8">
                                            Milestone</th>
                                        <th
                                            class="text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Nama Mahasiswa</th>
                                        <th
                                            class="text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Tanggal Bimbingan</th>
                                        <th
                                            class="col-2 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Jam</th>
                                        <th
                                            class="col-2 text-center text-black text-uppercase text-xs font-weight-bolder opacity-8">
                                            Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detailBimbingan as $detail)
                                        <tr class="">
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ ++$no }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-wrap text-black text-xs font-weight-bold">{{ date('d M Y', strtotime($detail->tanggalPengajuan)) }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span
                                                    class="text-wrap text-black text-xs font-weight-bold">{{ $detail->namaMilestone }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-black text-xs font-weight-bold">{{ $detail->namaMhs }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($detail->tanggalBimbingan != null)
                                                    <span
                                                        class="text-black text-xs font-weight-bold">{{ Carbon\Carbon::parse($detail->tanggalBimbingan)->translatedFormat('l\, d M Y') }}</span>
                                                @else
                                                    <span class="text-black text-xs font-weight-bold">Belum
                                                        ditentukan</span>
                                                @endif

                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($detail->tanggalBimbingan != null)
                                                    <span
                                                        class="text-black text-xs font-weight-bold">{{ Carbon\Carbon::parse($detail->tanggalBimbingan)->translatedFormat('H:i T') }}</span>
                                                @else
                                                    <span class="text-black text-xs font-weight-bold">Belum
                                                        ditentukan</span>
                                                @endif

                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($detail->statusBimbingan == 'Menunggu')
                                                    <a class="text-xxs btn btn-warning btn-lg" data-bs-toggle="modal"
                                                        data-bs-target="#konfirmasiBimbingan{{ $detail->detailBimbingan_id }}">Belum
                                                        Konfirmasi</a>
                                                    @include('dosen.modal_bimbingan.konfirmasiBimbingan')
                                                @elseif ($detail->statusBimbingan == 'Disetujui')
                                                    @php
                                                        $currentTime = \Carbon\Carbon::now();
                                                        $bimbinganTime = \Carbon\Carbon::parse($detail->tanggalBimbingan);
                                                        $timeDifference = $currentTime->diffInSeconds($bimbinganTime, false);
                                                    @endphp
                                                    @if ($currentTime->lt($bimbinganTime))
                                                        <a class="text-xxs btn btn-success btn-lg" disabled>Diterima</a>
                                                    @elseif ($detail->jamMulai == null)
                                                        <a class="text-xxs btn btn-info btn-lg" data-bs-toggle="modal"
                                                            data-bs-target="#mulaiBimbingan{{ $detail->detailBimbingan_id }}">Mulai</a>
                                                        @include('dosen.modal_bimbingan.mulaiBimbingan')
                                                    @elseif ($detail->jamMulai != null && $detail->jamSelesai == null)
                                                        <a class="text-xxs btn btn-warning btn-lg" data-bs-toggle="modal"
                                                            data-bs-target="#selesaiBimbingan{{ $detail->detailBimbingan_id }}">Selesai</a>
                                                        @include('dosen.modal_bimbingan.selesaiBimbingan')
                                                    @elseif ($detail->jamSelesai != null)
                                                        <a class="text-xxs btn btn-behance bg-dark btn-lg"
                                                            href="">Sudah Bimbingan</a>
                                                    @endif
                                                @else
                                                    <a class="text-xxs btn btn-danger btn-lg" disabled>Ditolak</a>
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
    {{-- Konfrimasi Bimbingan --}}
    <script>
        $(document).ready(function() {
            $(document).on('submit', '.konfirmasiBimbinganForm', function(e) {
                e.preventDefault();

                var form = $(this);

                var dataBimbingan = form.serializeArray();
                // var statusBimbingan = $('#statusBimbingan').val();
                var modalId = form.closest('.modal').attr('id'); // Get the ID of the closest modal
                // Get the value of the clicked button
                var statusBimbingan = $(document.activeElement).val();

                dataBimbingan.push({
                    'name': 'statusBimbingan',
                    'value': statusBimbingan
                })


                console.log("Form submitted with status:", statusBimbingan);
                console.log("Form data:", dataBimbingan);

                var errorMessages = [];

                $.ajax({
                    type: "POST",
                    url: '{{ route('dosen.konfirmasiBimbingan') }}',
                    data: dataBimbingan,
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 'terima') {
                            $('.tombol_tutup').click();
                            $('#konfirmasiBimbinganForm')[0].reset();
                            $('.table-responsive').load(location.href + ' .table-responsive');
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Bimbingan diterima dan jadwal telah ditetapkan.",
                                icon: "success",
                                confirmButtonText: 'Kembali',
                                timer: 2000,
                            });
                        } else if (response.status == 'tidak_diterima') {
                            $('.tombol_tutup').click();
                            $('#konfirmasiBimbinganForm')[0].reset();
                            $('.table-responsive').load(location.href + ' .table-responsive');
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Bimbingan telah ditolak.",
                                icon: "success",
                                confirmButtonText: 'Kembali',
                                timer: 2000,
                            });
                        }
                        // console.log(total);
                    },
                    error: function(errors) {
                        var error = errors.responseJSON;
                        console.log(error);

                        $.each(error.errors, function(elementId, message) {
                            appendErrorMessage('#' + modalId + ' #' + elementId,
                                message, errorMessages);

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
                        $('#bimbingan_id, #deskripsiPengajuan').on('input',
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
    {{-- End Konfrimasi Bimbingan --}}

    {{-- Selesai Bimbingan --}}
    <script>
        $(document).ready(function() {
            $(document).on('submit', '.selesaiBimbinganForm', function(e) {
                e.preventDefault();

                var form = $(this);

                var dataBimbingan = form.serializeArray();
                // var statusBimbingan = $('#statusBimbingan').val();
                var modalId = form.closest('.modal').attr('id');

                console.log("Form data:", dataBimbingan);

                var errorMessages = [];

                $.ajax({
                    type: "POST",
                    url: '{{ route('dosen.selesaiBimbingan') }}',
                    data: dataBimbingan,
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 'sukses') {
                            $('.tombol_tutup').click();
                            $('#selesaiBimbinganForm')[0].reset();
                            $('.table-responsive').load(location.href + ' .table-responsive');
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Bimbingan telah selesai! Silahkan kembali ke halaman Bimbingan.",
                                icon: "success",
                                confirmButtonText: 'Kembali',
                                timer: 2000,
                            });
                        }
                        // console.log(total);
                    },
                    error: function(errors) {
                        var error = errors.responseJSON;
                        console.log(error);

                        $.each(error.errors, function(elementId, message) {
                            appendErrorMessage('#' + modalId + ' #' + elementId,
                                message, errorMessages);

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
                        $('#catatanBimbingan, #acc_dp1, #acc_dp2').on('input',
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
