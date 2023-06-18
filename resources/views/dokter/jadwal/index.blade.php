@extends('layouts.app')
@section('content')
@include('partials.sidebar')

<div id="main" class='layout-navbar'>
  @include('partials.navbar')
  {{-- main content --}}
  <div id="main-content">
      <div class="page-heading">
        <div class="page-title">
          <div class="row mb-4 align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
              <h3>Daftar Jadwal Kontrol</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
              <div class="d-flex align-items-center justify-content-end">
                  <form method="GET" action="{{ url('jadwal-kontrol') }}">
                    <div class="input-group input-group-md me-2 p-2">
                      <input type="date" class="form-control group" name="date" placeholder="Filter Tanggal">
                      <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                  </form>
                
                  <div class="button">
                    <a href="{{ url('/jadwal-kontrol/create') }}" class="btn icon icon-left btn-primary">
                      <iconify-icon icon="akar-icons:plus"></iconify-icon>
                      Buat Jadwal
                    </a>
                  </div>
                {{-- </div> --}}
                
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
              @if(session()->has('error'))
              <div class="alert alert-light-danger alert-dismissible show fade mb-2">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session()->get('error') }}
              </div>
              @endif
              
              <div id="table1_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <table class="table table-responsive table-striped" id="table1">
                  <thead>
                      <tr>
                          <th data-sortable>No. Antrian</th>
                          <th data-sortable>Nama Pasien</th>
                          <th data-sortable>Tanggal Jadwal</th>
                          <th data-sortable>Jam Jadwal</th>
                          <th data-sortable>Status</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($datas as $data)
                      <tr>
                          <td>{{ $data->antrian }}</td>
                          <td>{{ $data->pasien->nama }}</td>
                          <td>{{ \Carbon\Carbon::parse($data->tgl_jadwal)->translatedFormat('l, d F Y') }}</td>
                          <td>{{ \Carbon\Carbon::parse($data->jam_jadwal)->format('H:i') }}</td>
                          <td>
                            <span class="badge {{ $data->status == 'Aktif' ? 'bg-light-success' : 'bg-light-secondary' }}">{{ $data->status }}</span>
                          </td>
                          <td>
                            <div class="table-action">
                              {{-- edit --}}
                              <a href="{{ url('jadwal-kontrol/'.$data->id_jadwal.'/edit') }}" class="btn btn-txt btn-grey me-1 {{ $data->status == 'Selesai' || $data->status == 'Batal' || $data->status == 'Undelivered' || $data->status == 'Aktif' && $data->tgl_jadwal == now()->toDateString() ? 'd-none' : '' }}" alt="edit">
                                <div class="d-flex align-items-center justify-content-center">
                                  <iconify-icon icon="akar-icons:pencil" class="me-1" data-align="center"></iconify-icon>
                                  <div class="icon-txt">Edit</div>
                                </div>
                              </a>
                              {{-- delete --}}
                              {{-- <form action="{{ url('jadwal-kontrol/'.$data->id_jadwal) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn icon btn-icon me-1 {{ $data->status === 'Selesai' || $data->status === 'Batal' ? 'd-none' : '' }}" alt="delete">
                                  <iconify-icon icon="akar-icons:trash-can"></iconify-icon>
                                </button>
                              </form> --}}
                              {{-- cancel --}}
                              <form action="{{ url('jadwal-kontrol/cancel/'.$data->id_jadwal) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-txt btn-grey {{ $data->tgl_jadwal === now()->toDateString() && $data->status === 'Aktif' ? '' : 'd-none' }}" alt="batalkan jadwal">
                                  <div class="d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="akar-icons:cross" class="me-1"></iconify-icon>
                                    <div class="icon-txt">Batal</div>
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
          </div>
        </section>
      </div>
  </div>
  {{-- end of main content --}}
</div>
@endsection