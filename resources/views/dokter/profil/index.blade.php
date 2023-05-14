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
              <h3>Kelola Profil</h3>
            </div>
          </div>
        </div>

        <section class="section">
          <div class="card">
            <div class="card-body">
              @if(session()->has('success'))
              <div class="alert alert-light-success alert-dismissible show fade">
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  {{ session()->get('success') }}
              </div>
              @endif
              <form action="{{ url('profil/'.$datas->id_dokter) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <div class="row">
                  <div class="col-md-4">
                    <div class="profile-picture">
                      <img src="{{ asset('asset/img/doc.png') }}" class="rounded-circle mx-auto d-block mb-2" width="220px">
                      <div class="round">
                        <input type="file" class="form-control input-foto" name="file_foto">
                        {{-- <iconify-icon icon="akar-icons:edit"></iconify-icon> --}}
                      </div>
                    </div>
                    
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" name="nama" class="form-control" value="{{ $datas->nama }}" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="alamat" class="form-label">Alamat</label>
                      <textarea class="form-control" name="alamat" rows="3" value="{{ $datas->alamat }}" placeholder="Masukkan alamat">{{ $datas->alamat }}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="no_hp">Nomor WhatsApp</label>
                      <small class="text-muted">contoh.<i>081133876</i></small>
                      <input type="text" class="form-control" name="no_hp" value="{{ $datas->no_hp }}">
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="reset" class="btn btn-light-secondary">Reset</button>
                  </div>
                </div>
              </form>
              {{-- end card body --}}
            </div>
          </div>
        </section>
      </div>
  </div>
  {{-- end of main content --}}
</div>
@endsection