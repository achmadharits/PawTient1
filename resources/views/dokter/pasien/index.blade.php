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
              <h3>Daftar Pasien</h3>
              <p>Menampilkan pasien yang Anda tangani.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
              <div class="button">
                <a href="{{ url('/rekam-medis/create') }}" class="btn icon icon-left btn-primary">
                  <iconify-icon icon="akar-icons:plus"></iconify-icon>
                  Tambah Pasien
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
                            <th>Foto</th>
                            <th data-sortable>Nama Pasien</th>
                            <th data-sortable>Usia</th>
                            <th data-sortable>Nomor WhatsApp</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      
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