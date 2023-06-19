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
              <h3>Edit Jadwal Kontrol</h3>
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
              <form method="POST" action="{{ url('jadwal-kontrol/'.$datas->id_jadwal) }}">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <div class="create-group">
                  {{-- nama dokter --}}
                  <div class="form-group d-none">
                    <label for="nama-dokter">ID Dokter</label>
                    <input type="text" name="id_dokter" class="form-control" value="{{ Auth::guard('dokter')->user()->id_dokter }}">
                  </div>

                  {{-- id jadwal --}}
                  {{-- <div class="form-group">
                    <label for="nama-pasien">ID Jadwal</label>
                    <input type="text" class="form-control" name="id_pasien" value="{{ $datas->id_jadwal }}" disabled>
                  </div> --}}
  
                  {{-- nama pasien --}}
                  <div class="form-group">
                    <label for="nama-pasien">Nama Pasien</label>
                    <input type="text" class="form-control" name="id_pasien" value="{{ $datas->pasien->nama }}" disabled>
                  </div>
  
                  {{-- tgl jadwal --}}
                  <div class="form-group">
                    <label for="tgl_jadwal">Tanggal Jadwal</label>
                    <input name="tgl_jadwal" type="text" id="datepicker" class="form-control @error('tgl_jadwal') is-invalid @enderror" 
                    value="{{ str_replace('-', '/', $datas->tgl_jadwal) }}" autocomplete="off" onchange="getJamKerja();">
                    @error('tgl_jadwal')
                    <span class="invalid-feedback role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>

                  {{-- jam --}}
                  <div class="form-group">
                    <label for="jam_jadwal">Jam Jadwal</label>
                    <input type="text" name="jam_jadwal" id="timepicker" class="form-control  @error('tgl_jadwal') is-invalid @enderror" autocomplete="off" value="{{ substr($datas->jam_jadwal, 0, 5) }}">
                    @error('jam_jadwal')
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
    var disabledDays = {!! $tgl_izin !!}; // ini gak da d nya
    console.log(disabledDays);

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
    let jam_kerja = [];
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