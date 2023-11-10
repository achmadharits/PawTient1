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
              <h3>Daftar Reservasi Pasien</h3>
              <p>Menampilkan reservasi masuk yang telah dibuat oleh pasien Anda.</p>
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
                            <th data-sortable>Nama Pasien</th>
                            <th data-sortable>Tanggal Reservasi</th>
                            <th data-sortable>Jam Reservasi</th>
                            <th data-sortable>Jenis Hewan</th>
                            <th data-sortable>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($datas as $data)
                        <tr>
                            <td>{{ $data->pasien->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tgl_reservasi)->translatedFormat('l, d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->jam_reservasi)->format('H:i') }}</td>
                            <td>{{ $data->jenis_hewan }}</td>
                            <td>{{ $data->deskripsi }}</td>
                            <td>
                              <div class="table-action">
                                {{-- edit --}}
                                <form action="{{ url('dokter/reservasi/save/'.$data->id) }}" method="POST">
                                  @csrf
                                  <button type="submit" class="btn btn-txt btn-green me-1">
                                    <div class="d-flex align-items-center justify-content-center">
                                      <iconify-icon icon="akar-icons:check" class="me-1"></iconify-icon>
                                      <div class="icon-txt">Setuju</div>
                                    </div>
                                  </button>
                                </form>
                                {{-- delete --}}
                                <form action="{{ url('dokter/reservasi/tolak/'.$data->id) }}" method="POST">
                                  @csrf
                                  <button type="submit" class="btn btn-txt btn-red" alt="delete">
                                    <div class="d-flex align-items-center justify-content-center">
                                      <iconify-icon icon="akar-icons:cross" class="me-1"></iconify-icon>
                                      <div class="icon-txt">Tolak</div>
                                    </div>
                                  </button>
                                </form>
                              </div>
                              
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