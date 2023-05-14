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
                                Edit Profil
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
              <h3>Kelola Profil</h3>
            </div>
          </div>
        </div>

        <section class="section">
          <div class="card">
            <div class="card-body">
              @if(session()->has('success'))
              <div class="alert alert-light-success alert-dismissible show fade">
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  {{ session()->get('success') }}
              </div>
              @endif
              <form action="{{ url('profil/'.$datas->id_dokter) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <div class="row">
                  <div class="col-md-4">
                    <div class="profile-picture">
                      <img src="{{ asset('asset/img/doc.png') }}" class="rounded-circle mx-auto d-block mb-2" width="220px">
                      <div class="round">
                        <input type="file" class="form-control input-foto" name="file_foto">
                        {{-- <iconify-icon icon="akar-icons:edit"></iconify-icon> --}}
                      </div>
                    </div>
                    
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" name="nama" class="form-control" value="{{ $datas->nama }}" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="alamat" class="form-label">Alamat</label>
                      <textarea class="form-control" name="alamat" rows="3" value="{{ $datas->alamat }}" placeholder="Masukkan alamat">{{ $datas->alamat }}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="no_hp">Nomor WhatsApp</label>
                      <small class="text-muted">contoh.<i>081133876</i></small>
                      <input type="text" class="form-control" name="no_hp" value="{{ $datas->no_hp }}">
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="reset" class="btn btn-light-secondary">Reset</button>
                  </div>
                </div>
              </form>
              {{-- end card body --}}
            </div>
          </div>
        </section>
      </div>
  </div>
  {{-- end of main content --}}
</div>
@endsection