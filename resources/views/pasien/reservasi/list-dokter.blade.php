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
              <h3>Daftar Dokter Hewan</h3>
              <p>Pilih salah satu dokter hewan untuk melakukan reservasi.</p>
            </div>
          </div>
        </div>

        <section class="section">
          <div class="row">
            @foreach ($datas as $data)
              @if(isset($data->jadwalPraktik[0]->jam_kerja))
              <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                {{-- card dokter --}}
                <div class="card mb-3 shadow-sm" style="width: 14rem;">
                  <img src="{{ asset('asset/img/doc.png') }}" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h6 class="mb-1">drh. {{ $data->nama }}</h6>
                    <small class="text-muted">
                      @foreach ($data->jadwalPraktik as $val)
                        @if ($loop->last)
                          {{ $val->hari }} ({{ $val->jam_kerja }})
                        @else
                          {{ $val->hari }} ({{ $val->jam_kerja }}),
                        @endif
                      @endforeach
                    </small>
                    <br>
                    <a href="{{ url('pasien/reservasi/'.$data->id_dokter.'/create') }}" class="btn btn-text btn-purple stretched-link mt-3">
                      Reservasi
                    </a>
                  </div>
                </div>
              </div>
              @endif
            @endforeach
            
          </div>
          
        </section>
      </div>
  </div>
  {{-- end of main content --}}
</div>
@endsection