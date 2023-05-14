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
              <h3>Buat Rekam Medis Baru</h3>
            </div>
            {{-- <div class="col-12 col-md-6 order-md-2 order-first">
              <div class="button">
                <a href="#" class="btn icon icon-left btn-primary">
                  <iconify-icon icon="akar-icons:plus"></iconify-icon>
                  Buat Jadwal
                </a>
              </div>
            </div> --}}
          </div>
        </div>

        <section class="section">
          <div class="card">
            <div class="card-body">
              <form method="POST" action="#">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    {{-- nama pasien --}}
                    <div class="form-group">
                      <label for="id_pasien">Nama Pasien</label>
                      <select name="id_pasien" class="form-select @error('id_pasien') is-invalid @enderror" >
                        <option value="">Pilih Pasien</option>
                        @foreach ($datas as $data)
                        <option value="{{ $data->id_pasien }}">{{ $data->nama }}</option>
                        @endforeach
                      </select>
                      @error('id_pasien')
                      <span class="invalid-feedback role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    {{-- input anamnesis --}}
                    <div class="form-group">
                      <label for="anamnesis">Anamnesis</label>
                      <textarea name="anamnesis" rows="3" class="form-control @error('anamnesis') is-invalid @enderror"></textarea>
                      @error('anamnesis')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>

                    {{-- input diagnosis --}}
                    <div class="form-group">
                      <label for="diagnosis">Diagnosis</label>
                      <input type="text" class="form-control" name="diagnosis">
                    </div>

                  </div>
                  <div class="col-md-6">
                    {{-- tgl jadwal --}}
                    <div class="form-group">
                      <label for="tgl_jadwal">Tanggal Konsultasi</label>
                      <input name="tgl_jadwal" type="date" class="form-control @error('tgl_jadwal') is-invalid @enderror">
                      @error('tgl_jadwal')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    {{-- input odontogram --}}
                    <div class="form-group">
                      <label for="odontogram">Odontogram</label>
                      <textarea name="odontogram" rows="3" class="form-control @error('anamnesis') is-invalid @enderror"></textarea>
                      @error('odontogram')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    {{-- input perawatan --}}
                    <div class="form-group">
                      <label for="perawatan">Tindakan Perawatan</label>
                      <input type="text" class="form-control" name="perawatan">
                    </div>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

              </form>
            </div>
          </div>
        </section>
      </div>
  </div>
  {{-- end of main content --}}
</div>
@endsection