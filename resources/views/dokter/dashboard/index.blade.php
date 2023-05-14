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
                              <a class="dropdown-item" href="{{ url('/profil') }}">
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
              <h3>Selamat datang, {{ Auth::guard('dokter')->user()->nama }}!</h3>
              @if(session()->has('error'))
              <div class="alert alert-light-danger color-danger">
                  {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                  {{ session()->get('error') }}
              </div>
              @endif
            </div>
          </div>
        </div>

        <section class="section">
          <div class="card">
            <div class="card-body">
                <h5>Ini adalah dashboard dokter gigi</h5>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Officiis nobis eius distinctio quisquam doloremque atque dignissimos, iure quae fugit tempore eum hic accusamus a provident, sint asperiores cupiditate? Reiciendis, eius!</p>
            </div>
          </div>
        </section>
      </div>
  </div>
  {{-- end of main content --}}
</div>
@endsection