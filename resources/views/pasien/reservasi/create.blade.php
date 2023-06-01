@extends('layouts.app')
@section('content')
@include('partials.pasien-sidebar')
<div id="main" class='layout-navbar'>
  @include('partials.navbar')
  {{-- main content --}}
  <div id="main-content">
      <div class="page-heading">
        <div class="page-title">
          <div class="row mb-4">
            <div class="col-12 col-md-6 order-md-1 order-last">
              <h3>Buat Reservasi Baru</h3>
            </div>
          </div>
        </div>

        <section class="section">
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label for="id_dokter">Nama Dokter</label>
                <input type="text" class="form-control" value="{{ $datas->nama }}" disabled>
              </div>
              <form method="POST" action="{{ url('pasien/reservasi') }}">
                @csrf
                <div class="create-group">
                  {{-- nama pasien --}}
                  <div class="form-group d-none">
                    <label for="nama-dokter">ID Pasien</label>
                    <input type="text" name="id_pasien" class="form-control" value="{{ Auth::guard('pasien')->user()->id_pasien }}">
                  </div>
                  {{-- nama dokter --}}
                  <div class="form-group d-none">
                    <label for="id_dokter">Nama Dokter</label>
                    <input type="text" name="id_dokter" class="form-control" value="{{ $datas->id_dokter }}">
                  </div>
  
                  {{-- tgl jadwal --}}
                  <div class="form-group">
                    <label for="tgl_reservasi">Tanggal Reservasi</label>
                    <input name="tgl_reservasi" type="text" id="datepicker" class="form-control @error('tgl_reservasi') is-invalid @enderror" autocomplete="off" placeholder="YYYY/MM/DD">
                    @error('tgl_reservasi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>

                  {{-- deskripsi --}}
                  <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="2" autocomplete="off" placeholder="Tulis deskripsi"></textarea>
                    {{-- <input name="deskripsi" type="text" class="form-control @error('deskripsi') is-invalid @enderror" autocomplete="off" placeholder="Tulis deskripsi"> --}}
                    @error('deskripsi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
  
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
              </form>



            </div>
          </div>
        </section>
      </div>
  </div>
  {{-- end of main content --}}
</div>

<script type="text/javascript">
  $(function () {
    var allowedDays = {{ $tanggal }};
    $("#datepicker").datepicker({
      dateFormat: "yy/mm/dd",
      minDate: 0,
      beforeShowDay: function (date) {
        var day = date.getDay();
        if (allowedDays.includes(day)) {
          return [true, ""]; // tanggal dapat dipilih
        } else {
          return [
            false,
          ]; // tanggal tidak dapat dipilih
        }
      },
    });
  });
</script>
@endsection