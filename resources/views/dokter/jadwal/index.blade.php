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
              <h3>Daftar Jadwal Kontrol</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
              <div class="button">
                <a href="{{ url('/jadwal-kontrol/create') }}" class="btn icon icon-left btn-primary">
                  <iconify-icon icon="akar-icons:plus"></iconify-icon>
                  Buat Jadwal
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
                              <span class="badge {{ $data->status === 'Aktif' ? 'bg-light-success' : 'bg-light-secondary' }}">{{ $data->status }}</span>
                            </td>
                            <td>
                              <div class="table-action">
                                {{-- edit --}}
                                <a href="{{ url('jadwal/'.$data->id_jadwal.'/edit') }}" class="btn icon btn-icon me-1 {{ $data->status === 'Selesai' ? 'd-none' : '' }}" alt="edit">
                                  <iconify-icon icon="akar-icons:pencil" data-align="center"></iconify-icon>
                                </a>
                                {{-- delete --}}
                                <form action="{{ url('jadwal/'.$data->id_jadwal) }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="_method" value="DELETE">
                                  <button type="submit" class="btn icon btn-icon {{ $data->status === 'Selesai' ? 'd-none' : '' }}" alt="delete">
                                    <iconify-icon icon="akar-icons:trash-can"></iconify-icon>
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