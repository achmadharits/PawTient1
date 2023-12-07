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
            <h3>Daftar Reservasi</h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <div class="button">
              <a href="{{ url('/pasien/reservasi/dokter') }}" class="btn icon icon-left btn-primary">
                <iconify-icon icon="akar-icons:plus"></iconify-icon>
                Buat Reservasi
              </a>
            </div>
          </div>
        </div>
      </div>

      <section class="section">
        <div class="card">
          <div class="card-body">

            @if(session()->has('success'))
            <div class="alert alert-light-success alert-dismissible show fade mb-2">
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              {{ session()->get('success') }}
            </div>
            @endif
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th data-sortable>Nama Dokter</th>
                  <th data-sortable>Tanggal</th>
                  <th data-sortable>Jam</th>
                  <th data-sortable>Jenis Hewan</th>
                  <th data-sortable>Deskripsi</th>
                  <th data-sortable>Status</th>
                  {{-- <th>Aksi</th> --}}
                </tr>
              </thead>
              <tbody>
                @foreach ($datas as $data)
                <tr>
                  <td>{{ $data->dokter->nama }}</td>
                  <td>{{ $data->tgl_reservasi }}</td>
                  <td>{{ Carbon\Carbon::parse($data->jam_reservasi)->format('H:i') }}</td>
                  <td>{{ $data->jenis_hewan }}</td>
                  <td>{{ $data->deskripsi }}</td>
                  <td><span class="badge {{ $data->status === 'Menunggu' ? 'bg-light-warning' : 'bg-light-secondary' }}">{{ $data->status }}</span></td>
                  <td><a href="/generate-pdf/<?php echo $data->id; ?>" class="btn btn-red" target="_blank">CETAK PDF</a></td>
                  <td>
                    {{-- <div class="table-action">
                                
                                <a href="" class="btn btn-txt btn-green me-1 " alt="edit">
                                  <div class="d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="akar-icons:check" class="me-1"></iconify-icon>
                                    <div class="icon-txt">Setuju</div>
                                  </div>
                                </a>
                                <form action="" method="POST">
                                  @csrf
                                  <input type="hidden" name="_method" value="DELETE">
                                  <button type="submit" class="btn btn-txt btn-red" alt="delete">
                                    <div class="d-flex align-items-center justify-content-center">
                                      <iconify-icon icon="akar-icons:cross" class="me-1"></iconify-icon>
                                      <div class="icon-txt">Tolak</div>
                                    </div>
                                  </button>
                                </form>
                              </div> --}}

                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </div>
  {{-- end of main content --}}
</div>
@endsection