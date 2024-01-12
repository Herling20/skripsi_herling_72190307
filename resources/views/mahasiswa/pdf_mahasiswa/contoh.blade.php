<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite(['resources/css/login.css', 'resources/css/mainHome.css', 'resources/css/mainMilestoneDosen.css', 'resources/css/sidebar.css', 'resources/css/cardMahasiswa.css', 'resources/css/table.css', 'resources/css/material-dashboard.css']) --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script> --}}
    <title>Kartu Konsultasi Skripsi</title>
</head>
<style>
    .center {
        text-align: center;
    }
</style>

<body>
    <table>
        <tr>
            <td width="70px">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/logo_ukdw.png'))) }}"
                    alt="Image" class="" width="70" height="65">
            </td>
            <td width="290px">
                <font size="2">UNIVERSITAS KRISTEN DUTA WACANA FAKULTAS TEKNOLOGI INFORMASI</font><hr class="">
                <font size="2,1">PROGRAM STUDI SISTEM INFORMASI</font>
            </td>
            <td width="310px" class="center">
                <font size="4" style="center">KARTU KONSULTASI SKRIPSI</font><br>
                <font size="2,1">Mulai Sem. </font>
            </td>
        </tr>
        <tr>
            <td colspan="3"><hr></td>
        </tr>
    </table>
</body>

</html>
