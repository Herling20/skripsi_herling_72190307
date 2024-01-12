<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="{{ asset('/resources/css/material-dashboard.css') }}" media="all" /> --}}
    @vite(['resources/css/material-dashboard.css'])

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}
    <title>Kartu Konsultasi Skripsi</title>
</head>
<style>
    .center {
        text-align: center;
    }

    .border2 {
        border: 2px solid black;
    }

    .border {
        border: 1px solid black;
    }

    .borderAtas {
        border-top: 1px solid black
    }

    .borderBawah {
        border-bottom: 1px solid black
    }

    .borderKiri {
        border-left: 1px solid black
    }

    .borderKanan {
        border-right: 1px solid black
    }

    .pt-0 {
        padding-top: 0 !important;
    }

    .pt-1 {
        padding-top: 0.25rem !important;
    }

    .pt-2 {
        padding-top: 0.5rem !important;
    }

    .pt-3 {
        padding-top: 1rem !important;
    }

    .mt-0 {
        margin-top: 0 !important;
    }

    .mt-1 {
        margin-top: 0.25rem !important;
    }

    .mt-2 {
        margin-top: 0.5rem !important;
    }

    .mt-3 {
        margin-top: 1rem !important;
    }

    .mt-4 {
        margin-top: 1.5rem !important;
    }

    .mt-5 {
        margin-top: 3rem !important;
    }

    .mt-6 {
        margin-top: 4rem !important;
    }

    .mt-7 {
        margin-top: 6rem !important;
    }

    .mt-8 {
        margin-top: 8rem !important;
    }

    .mt-9 {
        margin-top: 10rem !important;
    }

    .me-1 {
        margin-right: 0.55rem !important;
    }

    .w-10 {
        width: 10% !important;
    }

    .w-15 {
        width: 15% !important;
    }

    .w-20 {
        width: 20% !important;
    }

    .w-25 {
        width: 25% !important;
    }

    .w-30 {
        width: 30% !important;
    }

    .w-35 {
        width: 35% !important;
    }

    .w-40 {
        width: 40% !important;
    }

    .w-45 {
        width: 45% !important;
    }

    .w-50 {
        width: 50% !important;
    }

    .w-100 {
        width: 100% !important;
    }

    .p-1 {
        padding: 0.25rem !important;
    }

    .p-2 {
        padding: 0.5rem !important;
    }

    .p-3 {
        padding: 1rem !important;
    }

    .p-4 {
        padding: 1.5rem !important;
    }

    .p-5 {
        padding: 3rem !important;
    }

    .p-6 {
        padding: 4rem !important;
    }

    .p-7 {
        padding: 6rem !important;
    }

    .ps-0 {
        padding-left: 0 !important;
    }

    .ps-1 {
        padding-left: 0.25rem !important;
    }

    .ps-2 {
        padding-left: 0.5rem !important;
    }

    .ps-3 {
        padding-left: 1rem !important;
    }

    .text-uppercase {
        text-transform: uppercase !important;
    }

    .text-lg {
        font-size: 1.125rem !important;
    }

    .text-md {
        font-size: 1rem !important;
    }

    .text-sm {
        font-size: 0.875rem !important;
    }

    .text-xs {
        font-size: 0.75rem !important;
    }

    .text-xxs {
        font-size: 0.65rem !important;
    }

    .text-normal {
        font-weight: 400;
    }

    .text-bold {
        font-weight: 600;
    }

    .text-white {
        color: #fff !important;
    }

    .bg-header {
        background-color: #adb5bd !important;
    }

    .bg-nomor {
        background-color: #000 !important;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    textarea {
        width: 210px;
        height: 85px;
        resize: none;
        position: absolute;
        border: none;
        font-family: 'Times New Roman';
    }
</style>

<body>
    <table class="w-100">
        <tr>
            <td width="70px">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/logo_ukdw.png'))) }}"
                    alt="Image" class="" width="70" height="65">
            </td>
            <td width="290px">
                <font size="2">UNIVERSITAS KRISTEN DUTA WACANA FAKULTAS TEKNOLOGI INFORMASI</font>
                <hr class="me-1">
                {{-- <span class="text-bold">PROGRAM STUDI SISTEM INFORMASI</span> --}}
                <font size="15.5px" class="text-bold">PROGRAM STUDI SISTEM INFORMASI</font>
            </td>
            <td width="310px" class="center bg-header">
                <font size="18px" class="text-bold">KARTU KONSULTASI SKRIPSI</font><br>
                <font size="13px">Mulai Sem. {{ date('Y', strtotime(Auth::user()->periode->tanggalMulai)) }} /
                    {{ date('Y', strtotime(Auth::user()->periode->tanggalMulai)) + 1 }}</font>
            </td>
        </tr>
        {{-- <tr>
            <td colspan="3">
                <hr>
            </td>
        </tr> --}}
    </table>
    <table class="border2 mt-4 w-100 ">
        <tr>
            <td class="w-20 text-sm">
                NIM
            </td>
            <td class="text-sm">
                :
            </td>
            <td class="text-bold">
                <span class="text-sm">{{ Auth::user()->nim }}</span>
            </td>
            <td class="w-20">
                <span class="text-sm">Nama Mahasiswa</span>
            </td>
            <td class="text-sm">
                :
            </td>
            <td class="w-50">
                <span class="text-uppercase text-bold text-sm">{{ Auth::user()->nama }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="text-sm justify-content-start">Judul Skripsi</span>
            </td>
            <td class="center">
                :
            </td>
            <td colspan="4">
                <span class="text-uppercase text-bold text-sm">{{ Auth::user()->judul }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="text-sm">Pembimbing 1</span>
            </td>
            <td class="center">
                :
            </td>
            <td class="w-25">
                @foreach ($dosen1 as $dp1)
                    <span class="text-sm text-bold">{{ $dp1->nama }}</span>
                @endforeach
            </td>
            <td>
                <span class="text-sm">Pembimbing 2</span>
            </td>
            <td class="center text-sm">
                :
            </td>
            <td class="w-25">
                @foreach ($dosen2 as $dp2)
                    <span class="text-sm text-bold">{{ $dp2->nama }}</span>
                @endforeach
            </td>
        </tr>
    </table>
    <table class="mt-4 w-100 flex">
        <tr>
            <td class="center borderAtas borderKiri borderKanan w-25">
                <span class="text-md">Pembimbing I</span>
            </td>
            <td class="w-40" colspan=""></td>
            <td class="center borderAtas borderKiri borderKanan w-25">
                <span class="text-md">Pembimbing II</span>
            </td>
            <td class="w-35"></td>
        </tr>
    </table>
    <?php $no1 = 0; ?>
    <?php $no2 = 0; ?>
    @foreach ($riwayatBimbingan1 as $rb1)
        @foreach ($riwayatBimbingan2 as $rb2)
            <table>
                <tr>
                    <td class="w-1 center border bg-nomor" rowspan="2" width="35px"><span
                            class="text-white">{{ ++$no1 }}</span></td>
                    <td class="text-xs borderAtas borderKanan" width="291.5px"><span class="ps-2">Tanggal Konsultasi:
                            {{ date('d M Y', strtotime($rb1->tanggalBimbingan)) }}</span>
                    </td>

                    <td width="30px" rowspan="2"></td>

                    <td class="w-1 center border bg-nomor" rowspan="2" width="35px"><span
                            class="text-white">{{ ++$no2 }}</span></td>
                    <td class="text-xs borderAtas borderKanan"><span class="ps-2">Tanggal Konsultasi:
                            {{ date('d M Y', strtotime($rb2->tanggalBimbingan)) }}</span></td>
                </tr>
                <tr>
                    <td class="borderBawah borderKanan"></td>
                    <td class="borderBawah borderKanan"></td>
                </tr>
            </table>

            <table>
                <tr>
                    <td class="borderKiri borderKanan" width="220px">
                        <span class="text-xxs ps-2">Catatan Perkembangan/Revisi Skripsi:</span>
                    </td>
                    <td class="borderKanan" width="106.5px">
                        <span class="ps-1 text-xs">Paraf Dosen:</span>
                    </td>

                    <td rowspan="4" width="30px"></td>

                    <td class="borderKiri borderKanan" width="220px">
                        <span class="text-xxs ps-2">Catatan Perkembangan/Revisi Skripsi:</span>
                    </td>
                    <td class="borderKanan">
                        <span class="ps-1 text-xs">Paraf Dosen:</span>
                    </td>
                </tr>
                <tr>
                    <td class="borderKiri borderBawah" rowspan="3">
                        <textarea class="text-xs">{{ $rb1->catatanBimbingan }}</textarea>
                    </td>
                    <td class="borderKiri borderKanan borderBawah" height="40px"></td>
                    <td class="borderKiri borderBawah" rowspan="3">
                        <textarea class="text-xs">{{ $rb2->catatanBimbingan }}</textarea>
                    </td>
                    <td class="borderKiri borderKanan borderBawah"></td>
                </tr>
                <tr>
                    <td class="borderKiri borderKanan" height="1px">
                        <span class="ps-1 text-xs">Paraf Mahasiswa:</span>
                    </td>
                    <td class="borderKiri borderKanan">
                        <span class="ps-1 text-xs">Paraf Mahasiswa:</span>
                    </td>
                </tr>
                <tr>
                    <td class="borderKiri borderKanan borderBawah" height="40px"></td>
                    <td class="borderKiri borderKanan borderBawah"></td>
                </tr>
            </table>
        @endforeach
    @endforeach
</body>
</html>
