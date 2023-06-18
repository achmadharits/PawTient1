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
            <div class="col-lg-6 col-12">
              <div class="row">
                <div class="col-md-6 col-lg-6 col-12 col-sm-6">
                  <div class="card">
                    <div class="card-body px-4 py-4">
                      <div class="row d-flex align-items-center">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-flex justify-content-center align-items-center">
                          <iconify-icon class="stat-icon" icon="akar-icons:calendar"></iconify-icon>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                          <h6 class="text-muted">Jadwal Aktif</h6>
                          <h6><a href="{{ url('/jadwal-kontrol') }}" class="stretched-link"></a>{{ $jadwal }}</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-lg-6 col-12 col-sm-6">
                  <div class="card">
                    <div class="card-body px-4 py-4">
                      <div class="row d-flex align-items-center">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-flex justify-content-center align-items-center">
                          <iconify-icon class="stat-icon" icon="akar-icons:schedule"></iconify-icon>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                          <h6 class="text-muted">Reservasi Masuk</h6>
                          <h6><a href="{{ url('/dokter/reservasi') }}" class="stretched-link"></a>{{ $reservasi }}</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-7 col-7">
                      <h5>Jadwal Praktik</h5>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-5 d-flex justify-content-end">
                      <a title="Lihat semua" href="{{ url('/jadwal-praktik') }}">
                        <iconify-icon icon="akar-icons:enlarge" class="secondary"></iconify-icon>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex list-jadwal">
                    @foreach ($praktik as $p)
                    <div class="list-card mb-3">
                      <div class="list-card-body">
                        <h6>{{ $p->hari }}</h6>
                        <small>{{ $p->jam_kerja }}</small>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              
            </div>

            <div class="col-lg-6 col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-7 col-7">
                      <h5>Jadwal Hari Ini</h5>
                      <small>{{ Carbon\Carbon::parse(now()->toDateString())->translatedFormat('l, d M Y') }}</small>
                    </div>
                    {{-- <div class="col-lg-5 col-md-5 col-sm-5 col-5 d-flex justify-content-end">
                      <a title="Lihat semua" href="{{ url('pasien') }}">
                        <iconify-icon icon="akar-icons:enlarge" class="secondary"></iconify-icon>
                      </a>
                    </div> --}}
                  </div>
                </div>
                <div class="card-body list-jadwal">
                  <table class="table thead-dark">
                    <tr>
                      <th>No. Antrian</th>
                      <th>Nama Pasien</th>
                      <th>Jam</th>
                    </tr>
                    @forelse ($datas as $data)
                    <tr>
                      <td>{{ $data->antrian }}</td>
                      <td>{{ $data->pasien->nama }}</td>
                      <td>{{ \Carbon\Carbon::parse($data->jam_jadwal)->format('H:i') }} WIB</td>
                    </tr>
                    @empty
                    <td colspan="3" class="text-center">
                      Tidak ada jadwal hari ini.
                    </td>
                    @endforelse
                  </table>
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