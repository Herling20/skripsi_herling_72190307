<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/bootstrap.js'])
    @vite(['resources/css/login.css', 'resources/css/mainHome.css', 'resources/css/mainMilestoneDosen.css', 'resources/css/sidebar.css', 'resources/css/cardMahasiswa.css', 'resources/css/table.css', 'resources/css/material-dashboard.css'])

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Icon yang dipakai -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> --}}
    <title>SKRIPSI SI UKDW</title>
</head>

<body>
    @yield('main')

    <section class="dashboard">
        @yield('dashboard')
        @yield('sidebar')
        @yield('content')

        @yield('modal_edit_milestone')
        <!-- ====== Chart Dashboard Dosen ======= -->
        @yield('chartJumlahBimbinganDsn')
        @yield('chartJumlahMahsiswaDsn')
        @yield('chartTahapanMilestoneDsn')

        <!-- ====== Chart Mahasiswa Dosen ======= -->
        @yield('progressMahasiswaDsn')

        <!-- ====== Chart Home Mahasiswa ======= -->
        @yield('progressBarMahasiswa')

        <!-- ====== Chart Dashboard Admin ======= -->
        @yield('adminChartBarJumlahMahasiswaBimbingan')
        @yield('adminChartBarJumlahBimbinganDosen')
    </section>

    <!-- ====== ionicons ======= -->

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    {{-- <script src="/js/circular.js"></script>
    <script src="plugins/chart.js/Chart.min.js"></script> --}}

    @yield('script_tambah_milestone')

</body>

</html>
