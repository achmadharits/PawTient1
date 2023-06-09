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
              <h3>Edit Jadwal Praktik</h3>
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
              <form method="POST" action="{{ url('jadwal-praktik/'.$datas->id) }}">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <div class="create-group">
                  {{-- hari --}}
                  <div class="form-group">
                    <label for="hari">Hari Praktik</label>
                    <select name="hari" class="form-select @error('hari') is-invalid @enderror">
                      <option value="">Pilih hari</option>
                      <option value="Minggu" {{ $datas->hari === "Minggu" ? 'selected': ''}}>Minggu</option>
                      <option value="Senin" {{ $datas->hari === "Senin" ? 'selected': ''}}>Senin</option>
                      <option value="Selasa" {{ $datas->hari === "Selasa" ? 'selected': ''}}>Selasa</option>
                      <option value="Rabu" {{ $datas->hari === "Rabu" ? 'selected': ''}}>Rabu</option>
                      <option value="Kamis" {{ $datas->hari === "Kamis" ? 'selected': ''}}>Kamis</option>
                      <option value="Jumat" {{ $datas->hari === "Jumat" ? 'selected': ''}}>Jumat</option>
                      <option value="Sabtu" {{ $datas->hari === "Sabtu" ? 'selected': ''}}>Sabtu</option>
                    </select>
                    @error('hari')
                    <span class="invalid-feedback role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
  
                  {{-- jam kerja --}}
                  <div class="form-group">
                    <label for="jam_kerja">Jam Kerja</label>
                    <div class="row">
                      <div class="col-5">
                        <input name="jam_kerja1" type="time" class="form-control @error('jam_kerja1') is-invalid @enderror" value="{{ substr($datas->jam_kerja, 0, 5) }}">
                        @error('jam_kerja1')
                        <span class="invalid-feedback role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                      <div class="col-1 text-center">hingga</div>
                      <div class="col-5">
                        <input name="jam_kerja2" type="time" class="form-control @error('jam_kerja2') is-invalid @enderror" value="{{ substr($datas->jam_kerja, 8, 5) }}">
                        @error('jam_kerja2')
                        <span class="invalid-feedback role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                    </div>
                  </div>

                </div>
  
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
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