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
              <h3>Buat Perizinan Baru</h3>
            </div>
          </div>
        </div>

        <section class="section">
          <div class="card">
            <div class="card-body">
              <form method="POST" action="{{ url('izin') }}">
                @csrf
                <div class="create-group">
                  {{-- nama dokter --}}
                  <div class="form-group d-none">
                    <label for="nama-dokter">ID Dokter</label>
                    <input type="text" name="id_dokter" class="form-control" value="{{ Auth::guard('dokter')->user()->id_dokter }}">
                  </div>
  
                  {{-- tgl izin --}}
                  <div class="form-group">
                    <label for="tgl_izin">Tanggal Izin</label>
                    <input name="tgl_izin" type="text" id="datepicker" class="form-control @error('tgl_izin') is-invalid @enderror" autocomplete="off" placeholder="YYYY/MM/DD">
                    @error('tgl_izin')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
  
                  {{-- alasan --}}
                  <div class="form-group">
                    <label for="alasan">Alasan Izin</label>
                    <input name="alasan" type="text" id="datepicker" class="form-control @error('alasan') is-invalid @enderror" autocomplete="off">
                    @error('alasan')
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