@extends('layouts.app')
@section('content')
@include('partials.sidebar')
<div id="main" class='layout-navbar'>
  @include('partials.navbar')
  {{-- main content --}}
  <div id="main-content">
      <div class="page-heading">
        <div class="page-title">
          <div class="row mb-4">
            <div class="col-12 col-md-6 order-md-1 order-last">
              <h3>Buat Jadwal Praktik Baru</h3>
            </div>
          </div>
        </div>

        <section class="section">
          <div class="card">
            <div class="card-body">
              <form method="POST" action="{{ url('jadwal-praktik') }}">
                @csrf
                <div class="create-group">
                  {{-- nama dokter --}}
                  <div class="form-group d-none">
                    <label for="nama-dokter">ID Dokter</label>
                    <input type="text" name="id_dokter" class="form-control" value="{{ Auth::guard('dokter')->user()->id_dokter }}">
                  </div>
  
                  {{-- hari --}}
                  <div class="form-group">
                    <label for="hari">Hari Praktik</label>
                    <select name="hari" class="form-select @error('hari') is-invalid @enderror" >
                      <option value="">Pilih hari</option>
                      <option value="Minggu">Minggu</option>
                      <option value="Senin">Senin</option>
                      <option value="Selasa">Selasa</option>
                      <option value="Rabu">Rabu</option>
                      <option value="Kamis">Kamis</option>
                      <option value="Jumat">Jumat</option>
                      <option value="Sabtu">Sabtu</option>
                    </select>
                    @error('hari')
                    <span class="invalid-feedback role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
  
                  {{-- jam kerja --}}
                  <div class="form-group">
                    <label for="jam_kerja">Jam Kerja</label>
                    <div class="row">
                      <div class="col-5">
                        <input name="jam_kerja1" type="time" class="form-control @error('jam_kerja1') is-invalid @enderror">
                        @error('jam_kerja1')
                        <span class="invalid-feedback role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                      <div class="col-1 text-center">hingga</div>
                      <div class="col-5">
                        <input name="jam_kerja2" type="time" class="form-control @error('jam_kerja2') is-invalid @enderror">
                        @error('jam_kerja2')
                        <span class="invalid-feedback role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                    </div>
                  </div>

                </div>
  
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
              </form>



            </div>
          </div>
        </section>
      </div>
  </div>
  {{-- end of main content --}}
</div>
@endsection