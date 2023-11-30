@extends('layouts.app')

@section('content')
<div class="split-screen">
    <div class="auth-left">
        <section class="copy">
            <img src="{{ asset('asset/img/logo-white.png    ') }}" alt="">
            <div class="mt-3">
            <h5>Selamat datang!</h5>
            <!-- <p>Atur jadwal konsultasi gigi dengan mudah</p> -->
            </div>
        </section>
        </div>
        <div class="auth-right">
        <section class="copy">
            <h4>Masuk ke akun Pawtient</h4>
            @if(session()->has('success'))
            <div class="alert alert-light-success alert-dismissible show fade">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session()->get('success') }}
            </div>
            @endif
            <form method="POST" action="{{ route('auth.login') }}">
                @csrf
                <div class="input-auth">
                <!-- input email -->
                <label for="email" class="mt-4 mb-2">Alamat Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autofocus placeholder="Masukkan alamat email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
                
                <div class="input-auth">
                <!-- input password -->
                <label for="password" class="mt-3 mb-2">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="Masukkan password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
    
                <div class="input-auth">
                <!-- button login -->
                <button type="submit" class="btn btn-primary">
                    Masuk
                </button>
                </div>
    
                <div class="input-auth text-center mt-4">
                <p>Belum punya akun? <a href="{{ route('register.index') }}">Daftar</a></p>
                </div>
    
            </form>
            </section>
    </div>
</div>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn.btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
