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
          <div class="row">
            <div class="col-lg-9 col-12">
              <div class="row">
                <div class="col-md-4 col-lg-4 col-12 col-sm-6">
                  <div class="card">
                    <div class="card-body px-4 py-4">
                      <div class="row d-flex align-items-center">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-flex justify-content-center align-items-center">
                          <iconify-icon class="stat-icon" icon="akar-icons:calendar"></iconify-icon>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                          <h6 class="text-muted">Jadwal Aktif</h6>
                          <h6>6</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4 col-lg-4 col-12 col-sm-6">
                  <div class="card">
                    <div class="card-body px-4 py-4">
                      <div class="row d-flex align-items-center">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-flex justify-content-center align-items-center">
                          <iconify-icon class="stat-icon" icon="akar-icons:schedule"></iconify-icon>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                          <h6 class="text-muted">Reservasi Masuk</h6>
                          <h6>6</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4 col-lg-4 col-12 col-sm-6">
                  <div class="card">
                    <div class="card-body px-4 py-4">
                      <div class="row d-flex align-items-center">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-flex justify-content-center align-items-center">
                          <iconify-icon class="stat-icon" icon="akar-icons:people-group"></iconify-icon>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                          <h6 class="text-muted">Jumlah Pasien</h6>
                          <h6>10</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card">
                <div class="card-body">
                    <h5>Ini adalah dashboard dokter gigi</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam dolores, dolorum exercitationem ea dolore nam laboriosam quia sequi suscipit quas saepe harum fugit dicta! Nemo sed quisquam incidunt aspernatur officia.</p>
                </div>
              </div>
              
            </div>

            <div class="col-lg-3 col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-7 col-7">
                      <h6>Daftar Pasien</h6>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-5 d-flex justify-content-end">
                      <a title="Lihat semua" href="">
                        <iconify-icon icon="akar-icons:enlarge" class="secondary"></iconify-icon>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="patient-list d-flex align-items-center">
                    <div class="avatar-img">
                      <img src="{{ asset('asset/img/faces/3.jpg') }}" alt="">
                    </div>
                    <div class="avatar-name ms-4">
                      <h6>Havina Leli</h6>
                      <small>havina@email.com</small>
                    </div>
                  </div>

                  <div class="patient-list d-flex align-items-center">
                    <div class="avatar-img">
                      <img src="{{ asset('asset/img/faces/3.jpg') }}" alt="">
                    </div>
                    <div class="avatar-name ms-4">
                      <h6>Havina Leli</h6>
                      <small>havina@email.com</small>
                    </div>
                  </div>

                  <div class="patient-list d-flex align-items-center">
                    <div class="avatar-img">
                      <img src="{{ asset('asset/img/faces/3.jpg') }}" alt="">
                    </div>
                    <div class="avatar-name ms-4">
                      <h6>Havina Leli</h6>
                      <small>havina@email.com</small>
                    </div>
                  </div>

                  <div class="patient-list d-flex align-items-center">
                    <div class="avatar-img">
                      <img src="{{ asset('asset/img/faces/3.jpg') }}" alt="">
                    </div>
                    <div class="avatar-name ms-4">
                      <h6>Havina Leli</h6>
                      <small>havina@email.com</small>
                    </div>
                  </div>

                  <div class="patient-list d-flex align-items-center">
                    <div class="avatar-img">
                      <img src="{{ asset('asset/img/faces/3.jpg') }}" alt="">
                    </div>
                    <div class="avatar-name ms-4">
                      <h6>Havina Leli</h6>
                      <small>havina@email.com</small>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
          
          
        </section>
      </div>
  </div>
  {{-- end of main content --}}
</div>
@endsection