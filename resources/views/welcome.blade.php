<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DentistIn</title>
        <!-- <link rel="icon" href="{{ asset('asset/img/icon.svg') }}"> -->

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap -->
        @vite(['resources/js/app.js'])

        {{-- my style --}}
        <link rel="stylesheet" href="{{ asset('asset/style.css') }}">

    </head>
    <body class="antialiased">
        {{-- navbar --}}
        <div class="navbar-landing">
            <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                <!-- <img src="{{ asset('asset/img/logo-color.svg') }}"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="#">Beranda</a>
                    <a class="nav-link" href="#">Layanan</a>
                    <a class="btn btn-secondary" href="{{ route('register.index') }}">Daftar</a>
                    {{-- {{ route('register') }} --}}
                    <a class="btn btn-primary" href="{{ route('auth.index') }}">Masuk</a>
                </div>
                </div>
            </div>
            </nav>
        </div>
        {{-- navbar --}}
        
        <div class="container">
            {{-- hero --}}
            <div class="hero">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 justify-content-center">
                <div class="text-wrapper">
                    <h1 class="hero-title">
                    Atur Jadwal Konsultasi Hewan Peliharaan Anda dengan Mudah!
                    </h1>
                    <!-- <p class="hero-subtitle">
                    DentistIn hadir untuk mengatur jadwal konsultasi, cek jadwal konsultasi aktif, hingga rekap rekam medis.
                    </p> -->
                    <p class="hero-subtitle">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua
                    </p>
                    <a class="btn btn-primary" href="{{ route('auth.index') }}">Atur Jadwal</a>
                </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 justify-content-center">
                <!-- <img src="{{ asset('asset/img/hero-img.png') }}" class="mx-auto d-block" width="430px"> -->
                </div>
            </div>
            </div>
            {{-- hero --}}
        </div>
    </body>
</html>
