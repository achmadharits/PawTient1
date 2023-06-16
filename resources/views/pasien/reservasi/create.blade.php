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
                    <input name="tgl_reservasi" type="text" id="datepicker" class="form-control @error('tgl_reservasi') is-invalid @enderror" 
                    autocomplete="off" placeholder="YYYY/MM/DD" onchange="getJamKerja();">
                    @error('tgl_reservasi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>

                  {{-- jam --}}
                  <div class="form-group">
                    <label for="jam_reservasi">Jam Reservasi</label>
                    <input type="text" name="jam_reservasi" id="timepicker" class="form-control">
                    @error('jam_reservasi')
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
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script type="text/javascript">
  $(function () {
    var allowedDays = {{ $tanggal }};
    var disabledDays = {!! $tgl_izin !!}; // ini gak da d nya
    // console.log(disabledDays);

    $("#datepicker").datepicker({
      dateFormat: "yy/mm/dd",
      minDate: 0,
      beforeShowDay: function (date) {
        var day = date.getDay();
        var tanggal = jQuery.datepicker.formatDate('yy-mm-dd', date);
        
        if(disabledDays.includes(tanggal)){ // disini ada ran
            return [false];
        } else if(allowedDays.includes(day)){
          return [true, ""];
        }else {
          return [false];
        }
      },
    });
  });
</script>

<script type="text/javascript">
  function updateMinAndMax(min, max) {
    $('#timepicker').timepicker('option', 'minTime', min);
    $('#timepicker').timepicker('option', 'maxTime', max);
    $('#timepicker').timepicker('option', ' defaultTime', min);
  }


  function getJamKerja() {
    let id_dokter = "{{ $datas->id_dokter }}";
    let tanggal = document.getElementById("datepicker").value;
    let newTgl = moment(tanggal).format('YYYY-MM-DD');
    let startHour;
    let endHour;

    axios.get('/api/jadwal/'+id_dokter+'/'+newTgl, {
    })
    .then(function (response) {
      let workHours = response.data.jadwal;
      startHour = workHours.toString().substring(0, 5);
      endHour = workHours.toString().substring(8, 13);
      updateMinAndMax(startHour,endHour)
      console.log(startHour, endHour);
    })
    .catch(function (error) {
      console.log(error);
    });

    $('#timepicker').timepicker({
        timeFormat: 'H:i',
        interval: 30,
        dynamic: false,
        dropdown: true,
        scrollbar: true,
        disableTimeRanges: [
          ['12:00', '12:31'],
          ['15:00', '15:31'],
        ],
        listWidth: .5,
    });
    

  }
  
</script>
@endsection