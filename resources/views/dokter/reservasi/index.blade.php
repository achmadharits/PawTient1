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
                            <th data-sortable>Tanggal Jadwal</th>
                            <th data-sortable>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      {{-- @foreach ($datas as $data) --}}
                        <tr>
                            <td>Havina Leli</td>
                            <td>2023-06-01</td>
                            <td>Karet behel ada yang lepas</td>
                            <td>
                              <div class="table-action">
                                {{-- edit --}}
                                <a href="" class="btn btn-txt btn-green me-1 " alt="edit">
                                  <div class="d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="akar-icons:check" class="me-1"></iconify-icon>
                                    <div class="icon-txt">Setuju</div>
                                  </div>
                                </a>
                                {{-- delete --}}
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
                              </div>
                              
                            </td>
                        </tr>
                      {{-- @endforeach --}}
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