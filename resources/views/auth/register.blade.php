@extends('layouts.app')

@section('content')
<div class="split-screen">
    <div class="auth-left">
        <section class="copy">
            <img src="{{ asset('asset/img/logo-white.png') }}" alt="">
            <div class="mt-3">
            <h5>Selamat datang!</h5>
            <!-- <p>Atur jadwal konsultasi gigi dengan mudah</p> -->
            </div>
        </section>
        </div>
        <div class="register-right">
        <section class="copy">
            <h4>Daftar akun DentistIn</h4>
            <form method="POST" action="{{ route('register.create') }}">
                @csrf
                <div class="input-auth">
                    <!-- input email -->
                    <label for="email" class="mt-4 mb-2">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" autofocus placeholder="Masukkan nama lengkap">
                    @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-auth">
                <!-- input email -->
                <label for="email" class="mt-4 mb-2">Alamat Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autofocus placeholder="Masukkan alamat email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>

                <div class="input-auth">
                    <!-- input no hp -->
                    <label for="email" class="mt-4 mb-2">Nomor WhatsApp</label>
                    <input  type="number" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}"  autofocus placeholder="08xxxx">
                    @error('no_hp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="input-auth">
                <!-- input password -->
                <label for="password" class="mt-3 mb-2">Password</label>
                <input  type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="Masukkan password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
    
                <div class="input-auth">
                <!-- input password -->
                <label for="password" class="mt-3 mb-2">Konfirmasi Password</label>
                <input  type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password"  placeholder="Masukkan kembali password">
                @error('confirm_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
    
                <div class="input-auth">
                <!-- select role -->
                <label for="role" class="mt-3 mb-2" required>Daftar Sebagai</label>
                <select class="form-select" name="role" id="selectRole">
                    <option value="">Pilih</option>
                    <option value="dokter gigi">Dokter Hewan</option>
                    <option value="pasien">Pasien</option>
                </select>
                </div>

                <div class="input-auth d-none" id="noRegistDokter">
                    <!-- input no regist -->
                    <label for="no_regist_dokter" class="mt-3 mb-2">Nomor STR Dokter</label>
                    <input type="text" name="no_str" class="form-control number-input" placeholder="Masukkan nomor STR Dokter Anda">
                </div>
                
                <div class="input-auth">
                <!-- button login -->
                <button type="submit" class="btn btn-primary">
                    Daftar
                </button>
                </div>
    
                <div class="input-auth text-center mt-4">
                <p>Sudah punya akun? <a href="{{ route('auth.index') }}">Masuk</a></p>
                </div>
    
            </form>
        </section>
    </div>
</div>

{{-- for displaying nomor regist dokter --}}
<script type="text/javascript">
    $(document).ready(function() {
        $('#selectRole').on('change', function() {
            console.log(this.value);
            if (this.value == 'dokter gigi') {
                $('#noRegistDokter').removeClass('d-none');
            } else {
                $('#noRegistDokter').addClass('d-none');
            }
        });
    });
</script>

{{-- for masukin nomor regist dokter --}}
<script type="text/javascript">
    $(document).ready(function() {
        $('.number-input').inputmask("99.9.9.999.9.99.999999");
    });
</script>


@endsection
