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
              <h3>Buat Rekam Medis</h3>
            </div>
          </div>
        </div>

        <section class="section">
          <div class="card">
            <div class="card-body">
              <form method="POST" action="{{ url('rekam-medis') }}">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    {{-- Jenis konsultasi --}}
                    <div class="form-group">
                      <label for="id_pasien">Jenis Konsultasi</label>
                      <select name="id_jenis" class="form-select @error('id_jenis') is-invalid @enderror">
                        <option value="">Pilih</option>
                        @foreach ($jenis as $jenis)
                        <option value="{{ $jenis->id_jenis }}">{{ $jenis->jenis }}</option>
                        @endforeach
                      </select>
                      @error('id_jenis')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    {{-- Nama pasien --}}
                    <div class="form-group">
                      <label for="id_pasien">Nama Pasien</label>
                      <input type="text" name="" class="form-control" value="{{ $datas->pasien->nama }}" disabled>
                    </div>
                    {{-- ID pasien --}}
                    <div class="form-group">
                      <input type="text" name="id_pasien" class="form-control d-none" value="{{ $datas->id_pasien }}">
                    </div>
                    {{-- tgl jadwal --}}
                    <div class="form-group">
                      <label for="">Tanggal Konsultasi</label>
                      <input name="" type="date" class="form-control" value="{{ $datas->tgl_jadwal }}" disabled>
                    </div>
                    {{-- tgl jadwal --}}
                    <div class="form-group">
                      <input name="tgl_konsultasi" type="date" class="form-control d-none" value="{{ $datas->tgl_jadwal }}">
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
                  </div>

                  <div class="col-md-6">
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
                    {{-- input diagnosis --}}
                    <div class="form-group">
                      <label for="diagnosis">Diagnosis</label>
                      <input type="text" class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis">
                      @error('diagnosis')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    {{-- input perawatan --}}
                    <div class="form-group">
                      <label for="perawatan">Tindakan Perawatan</label>
                      <input type="text" class="form-control @error('perawatan') is-invalid @enderror" name="perawatan">
                      @error('perawatan')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
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