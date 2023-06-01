@extends('layouts.app')
@section('content')
@include('partials.pasien-sidebar')

<div id="main" class='layout-navbar'>
  @include('partials.navbar')
  {{-- main content --}}
  <div id="main-content">
      <div class="page-heading">
        <div class="page-title">
          <div class="row mb-4">
            <div class="col-12 col-md-6 order-md-1 order-last">
              <h3>Daftar Dokter Gigi</h3>
              <p>Pilih salah satu dokter gigi untuk melakukan reservasi.</p>
            </div>
            {{-- <div class="col-12 col-md-6 order-md-2 order-first">
              <div class="button">
                <a href="{{ url('/pasien/reservasi/create') }}" class="btn icon icon-left btn-primary">
                  <iconify-icon icon="akar-icons:plus"></iconify-icon>
                  Buat Reservasi
                </a>
              </div>
            </div> --}}
          </div>
        </div>

        <section class="section">
          <div class="row">
            @foreach ($datas as $data)
            <div class="col-lg-4">
              {{-- card dokter --}}
              <div class="card mb-3 shadow-sm" style="width: 15rem;">
                <img src="{{ asset('asset/img/doc.png') }}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h6>drg. {{ $data->nama }}</h6>
                  <p class="card-text">Jadwal Praktik:</p>
                  <p class="card-text"><small class="text-muted">Senin 10:00 - 18:00, Selasa 10:00 - 18:00</small></p>
                  <a href="{{ url('pasien/reservasi/'.$data->id_dokter.'/create') }}" class="btn btn-primary stretched-link">Reservasi</a>
                </div>
              </div>
            </div>
            @endforeach
            
          </div>
          
          {{-- <div class="card shadow-sm" style="max-width: 600px;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="{{ asset('asset/img/doc.png') }}" class="img-fluid rounded-start" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">drg. Elisa</h5>
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
              </div>
            </div>
          </div> --}}

          {{-- card dokter --}}
          <div class="card">
            
          </div>

        </section>
      </div>
  </div>
  {{-- end of main content --}}
</div>
@endsection