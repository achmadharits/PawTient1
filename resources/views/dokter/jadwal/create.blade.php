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
              <h3>Buat Jadwal Kontrol Baru</h3>
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
              <form method="POST" action="{{ url('jadwal-kontrol') }}">
                @csrf
                <div class="create-group">
                  {{-- nama dokter --}}
                  <div class="form-group d-none">
                    <label for="nama-dokter">ID Dokter</label>
                    <input type="text" name="id_dokter" class="form-control" value="{{ Auth::guard('dokter')->user()->id_dokter }}">
                  </div>
  
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
  
                  {{-- tgl jadwal --}}
                  <div class="form-group">
                    <label for="tgl_jadwal">Tanggal Jadwal</label>
                    <input name="tgl_jadwal" type="text" id="datepicker" class="form-control @error('tgl_jadwal') is-invalid @enderror">
                    @error('tgl_jadwal')
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
      altFormat: "dd/mm/yy",
      minDate: 0,
      beforeShowDay: function (date) {
        var day = date.getDay();
        if (allowedDays.includes(day)) {
          return [true, ""]; // tanggal dapat dipilih
        } else {
          return [
            false,
            "disabled",
            "Hanya boleh memilih tanggal dengan hari Selasa, Rabu, atau Jumat.",
          ]; // tanggal tidak dapat dipilih
        }
      },
    });
  });
</script>
@endsection