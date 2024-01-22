<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}

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

    .w-3 {
        width: 3% !important;
    }

    .w-4 {
        width: 4% !important;
    }

    .w-5 {
        width: 5% !important;
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
        font-weight: 800;
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
        width: 215px;
        height: 85px;
        font-size: 12px;
        resize: none;
        outline: none;
        font-family: 'Times New Roman';
    }

    .borderNone {}

    .header1 {
        width: 37%;
        padding-right: 10px;
    }

    .header2 {
        width: 45%;
        text-align: center;
    }

    .unv {
        font-size: 12px;
        margin-bottom: 0rem;
    }

    .ps {
        font-size: 13.5px;
    }

    .ks {
        font-size: 15px;
    }

    .semester {
        font-size: 12px;
    }

    .border {
        border: 1px solid #000 !important;
    }

    .d-flex {
        display: -webkit-box;
        display: -webkit-flex;
        /* wkhtmltopdf uses this one */
        display: flex;
        -webkit-box-pack: justify;
        /* wkhtmltopdf uses this one */
        justify-content: space-between;
    }

    .flex-riwayat {
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        flex: 1;
        display: flex
    }
</style>

<body>
    <table class="w-100">
        <tr>
            <td width="70px">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/logo_ukdw.png'))) }}"
                    alt="Image" class="" width="70" height="65">
            </td>
            <td class="header1">
                <p class="unv">UNIVERSITAS KRISTEN DUTA WACANA FAKULTAS TEKNOLOGI INFORMASI</p>
                <hr class="">
                {{-- <span class="text-bold">PROGRAM STUDI SISTEM INFORMASI</span> --}}
                <p class="ps"><b>PROGRAM STUDI SISTEM INFORMASI</b></p>
            </td>
            <td class="header2 bg-header">
                <p class="ks"><b>KARTU KONSULTASI SKRIPSI</b></p><br style="height: 2px">
                <p class="semester">Mulai Sem. {{ Auth::user()->periode->semester }} /
                    {{ date('Y', strtotime(Auth::user()->periode->tanggalMulai)) }}</p>
            </td>
        </tr>
    </table>
    <table class="kolomInfo border mt-4 w-100">
        <tr>
            <td style="width: 18%; font-size: 12px">
                NIM
            </td>
            <td style="width: 2%; text-align: center; font-size: 12px">
                :
            </td>
            <td style="width: 16%">
                <span class="text-sm" style="width: 2%; font-size: 12px"><b>{{ Auth::user()->nim }}</b></span>
            </td>
            <td style="width: 20%; font-size: 12px">
                <span>Nama Mahasiswa</span>
            </td>
            <td style="width: 2%; text-align: center;">
                :
            </td>
            <td style="">
                <span class="text-uppercase" style="font-size: 12px"><b>{{ Auth::user()->nama }}</b></span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="text-sm justify-content-start" style="font-size: 12px">Judul Skripsi</span>
            </td>
            <td style="width: 2%; text-align: center; font-size: 12px">
                :
            </td>
            <td colspan="4">
                <span class="text-uppercase" style="font-size: 12px"><b>{{ Auth::user()->judul }}</b></span>
            </td>
        </tr>
        <tr>
            <td>
                <span style="font-size: 12px">Pembimbing 1</span>
            </td>
            <td style="width: 2%; text-align: center; font-size: 12px">
                :
            </td>
            <td colspan="1">
                @foreach ($dosen1 as $dp1)
                    <span style="font-size: 12px"><b>{{ $dp1->nama }}</b></span>
                @endforeach
            </td>
            <td>
                <span style="font-size: 12px">Pembimbing 2</span>
            </td>
            <td style="text-align: center; font-size: 12px">
                :
            </td>
            <td>
                @foreach ($dosen2 as $dp2)
                    <span style="font-size: 12px"><b>{{ $dp2->nama }}</b></span>
                @endforeach
            </td>
        </tr>
    </table>
    <?php $no1 = 0; ?>
    <?php $no2 = 0; ?>
    <div style="width: 100%">
        {{-- Table Riwayat 1 --}}
        <div style="float: left; width: 49%">
            <table class="mt-4" style="width: 37%">
                <tr>
                    <td style="font-size: 12px; text-align: center;" class="center borderAtas borderKiri borderKanan">
                        <span>Pembimbing I</span>
                    </td>
                </tr>
            </table>
            @foreach ($riwayatBimbingan1 as $rb1)
                <div>
                    <div>
                        <table>
                            <tr>
                                <td style="width: 10%; text-align: center;" class="bg-nomor" rowspan="2">
                                    <span class="text-white">{{ ++$no1 }}
                                    </span>
                                </td>
                                <td class="text-xs borderAtas borderKanan">
                                    <span class="ps-2">Tanggal Konsultasi:
                                        {{ date('d M Y', strtotime($rb1->tanggalBimbingan)) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="borderBawah borderKanan"></td>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <td class="borderKiri borderKanan" style="width: 72%">
                                    <span style="font-size: 8px" class="ps-2">Catatan Perkembangan/Revisi
                                        Skripsi:</span>
                                </td>
                                <td class="borderKanan">
                                    <span style="font-size: 10px;" class="ps-1">Paraf Dosen:</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="borderKiri borderBawah" rowspan="3">
                                    <p style="font-size: 10px;">
                                        {{ $rb1->catatanBimbingan }}</p>
                                </td>
                                <td class="borderKiri borderKanan borderBawah" height="40px"></td>
                            </tr>
                            <tr>
                                <td class="borderKiri borderKanan" height="1px">
                                    <span style="font-size: 10px" class="ps-1">Paraf Mahasiswa:</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="borderKiri borderKanan borderBawah" height="40px"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Table Riwayat 2 --}}
        <div style="float: right; width: 49%;">
            <table class="mt-4" style="width: 37%">
                <tr>
                    <td style="font-size: 12px; text-align: center;" class="center borderAtas borderKiri borderKanan">
                        <span>Pembimbing II</span>
                    </td>
                </tr>
            </table>
            @foreach ($riwayatBimbingan2 as $rb2)
                <div class="card mb-3">
                    <div class="card-body">
                        <table>
                            <tr>
                                <td style="width: 10%; text-align: center;" class="bg-nomor" rowspan="2">
                                    <span class="text-white">{{ ++$no2 }}
                                    </span>
                                </td>
                                <td class="text-xs borderAtas borderKanan">
                                    <span class="ps-2">Tanggal Konsultasi:
                                        {{ date('d M Y', strtotime($rb2->tanggalBimbingan)) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="borderBawah borderKanan"></td>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <td class="borderKiri borderKanan" style="width: 72%">
                                    <span style="font-size: 8px" class="ps-2">Catatan Perkembangan/Revisi
                                        Skripsi:</span>
                                </td>
                                <td class="borderKanan">
                                    <span style="font-size: 10px;" class="ps-1">Paraf Dosen:</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="borderKiri borderBawah" rowspan="3">
                                    <p style="font-size: 10px;">
                                        {{ $rb2->catatanBimbingan }}</p>
                                </td>
                                <td class="borderKiri borderKanan borderBawah" height="40px"></td>
                            </tr>
                            <tr>
                                <td class="borderKiri borderKanan" height="1px">
                                    <span style="font-size: 10px" class="ps-1">Paraf Mahasiswa:</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="borderKiri borderKanan borderBawah" height="40px"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="clear: both;"></div> {{-- Clear float --}}
    </div>
</body>

</html>
