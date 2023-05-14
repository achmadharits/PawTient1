@extends('layouts.app')
@section('content')
@include('partials.sidebar')
<div id="main" class='layout-navbar'>
  {{-- navbar --}}
  <header class='mb-3'>
      <nav class="navbar navbar-expand navbar-light navbar-top">
          <div class="container-fluid">
              <a href="#" class="burger-btn d-block">
                  <iconify-icon icon="akar-icons:text-align-justified"></iconify-icon>
              </a>

              <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                  data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                  aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <div class="dropdown ms-auto">
                      <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                          <div class="user-menu d-flex">
                              <div class="user-name text-end me-3">
                                  <h6 class="mb-0 text-gray-600">{{ Auth::guard('dokter')->user()->nama }}</h6>
                                  <p class="mb-0 text-sm text-gray-600">Dokter Gigi</p>
                              </div>
                              <div class="user-img d-flex align-items-center">
                                  <div class="avatar avatar-md">
                                      <img src="{{ asset('asset/img/doc.png') }}">
                                  </div>
                              </div>
                          </div>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                          <li>
                              <h6 class="dropdown-header">Menu</h6>
                          </li>
                          <li>
                              <a class="dropdown-item" href="#">
                                  Profil Saya
                              </a>
                          </li>
                              <hr class="dropdown-divider">
                          </li>
                          <li>
                              <a class="dropdown-item" href="{{ route('auth.logout') }}">
                                  Keluar
                              </a>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
      </nav>
  </header>
  {{-- end of navbar --}}

  {{-- main content --}}
  <div id="main-content">
      <div class="page-heading">
        <div class="page-title">
          <div class="row mb-4">
            <div class="col-12 col-md-6 order-md-1 order-last">
              <h3>Buat Jadwal Kontrol Baru</h3>
            </div>
            {{-- <div class="col-12 col-md-6 order-md-2 order-first">
              <div class="button">
                <a href="#" class="btn icon icon-left btn-primary">
                  <iconify-icon icon="akar-icons:plus"></iconify-icon>
                  Buat Jadwal
                </a>
              </div>
            </div> --}}
          </div>
        </div>

        <section class="section">
          <div class="card">
            <div class="card-body">
              <form method="POST" action="{{ url('jadwal') }}">
                @csrf
                <div class="create-group">
                  {{-- nama dokter --}}
                  <div class="form-group d-none">
                    <label for="nama-dokter">ID Dokter</label>
                    <input type="text" name="id_dokter" class="form-control" value="{{ Auth::guard('dokter')->user()->id_dokter }}">
                  </div>
  
                  {{-- nama pasien --}}
                  <div class="form-group">
                    <label for="id_pasien">Nama Pasien</label>
                    <select name="id_pasien" class="form-select @error('id_pasien') is-invalid @enderror" >
                      <option value="">Pilih Pasien</option>
                      @foreach ($datas as $data)
                      <option value="{{ $data->id_pasien }}">{{ $data->nama }}</option>
                      @endforeach
                    </select>
                    @error('id_pasien')
                    <span class="invalid-feedback role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
  
                  {{-- tgl jadwal --}}
                  <div class="form-group">
                    <label for="tgl_jadwal">Tanggal Jadwal</label>
                    <input name="tgl_jadwal" type="date" class="form-control @error('tgl_jadwal') is-invalid @enderror">
                    @error('tgl_jadwal')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
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