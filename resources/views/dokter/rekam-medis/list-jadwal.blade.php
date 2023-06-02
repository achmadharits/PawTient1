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
            <div class="col-12 order-md-1 order-last">
              <h3>Daftar Jadwal Konsultasi</h3>
              <p>Pilih salah satu data jadwal konsultasi yang hendak dibuatkan rekam medis.</p>
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
                            <th data-sortable>ID Jadwal</th>
                            <th data-sortable>Nama Pasien</th>
                            <th data-sortable>Tanggal Jadwal</th>
                            <th data-sortable>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($datas as $data)
                        <tr>
                            <td>{{ $data->id_jadwal }}</td>
                            <td>{{ $data->pasien->nama }}</td>
                            <td>{{ $data->tgl_jadwal }}</td>
                            <td>
                              <span class="badge bg-light-secondary">{{ $data->status }}</span>
                            </td>
                            <td>
                              <div class="table-action">
                                {{-- buat --}}
                                <form action="{{ url('rekam-medis/'.$data->id_jadwal.'/create') }}" method="GET">
                                  @csrf
                                  <button type="submit" class="btn btn-txt btn-purple">
                                    <div class="d-flex align-items-center justify-content-center">
                                      <iconify-icon icon="akar-icons:pencil" class="me-1"></iconify-icon>
                                      <div class="icon-txt">Buat</div>
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