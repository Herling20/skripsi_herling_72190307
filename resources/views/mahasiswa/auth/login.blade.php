{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('mahasiswa.login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- <link rel="stylesheet" href="/css/sidebar.css">
    <link rel="stylesheet" href="/css/main.css"> --}}
    {{-- @vite(['resources/js/circular.js', 'resources/js/bootstrap.js']) --}}
    @vite(['resources/css/login.css', 'resources/css/mainHome.css', 'resources/css/sidebar.css', 'resources/css/material-dashboard.css'])
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Icon yang dipakai -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>SKRIPSI SI UKDW</title>

</head>

<body>
    <div class="halaman-login">
        <div class="wrapper">
            <form action="{{ route('mahasiswa.login') }}" method="POST">
                @csrf
                <h1 class="fs-3">Selamat Datang, Silahkan Login Mahasiswa</h1>
                <div class="input-box">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="@error('email') is-invalid @enderror" placeholder="Masukkan Email" autofocus required value="{{ old('username') }}">
                    <i class="i-username bx bxs-user"></i>
    
                    @error('kodeUser')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
    
    
                <div class="input-box">
                    <label class="mb-1 mt-4" for="password">Password</label>
                    <input class="form-password" type="password" name="password" id="password" placeholder="Masukkan Password" required>
                    <i class="i-password bx bxs-lock-alt"></i>
                </div>
                <div class="show-password">
                    <label for=""><input class="form-checkbox" type="checkbox" id="showPass"> Show Password</label>
                </div>
                <div class="flex justify-content-center align-content-center">
                    <button type="submit" class="btn btn-success">Login</button>     
                </div>
    
    
            </form>
        </div>
    </div>

    @if(session()->has('loginError'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('loginError') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    {{-- <script src="/js/circular.js"></script> --}}

    {{-- Javascript Show Password dengan Checkbox --}}
    <script type="text/javascript">
        $(document).ready(function(){  
            $('#showPass').click(function(){
                if($(this).is(':checked')){
                    $('#password').attr('type','text');
                }else{
                    $('#password').attr('type','password');
                }
            });
        });
    </script>
    {{-- End Javascript --}}

    
</body>
</html>