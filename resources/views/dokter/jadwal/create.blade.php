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
          </div>
        </div>

        <section class="section">
          <div class="card d-none" id="dataAntrian">
            <div class="card-header" style="margin-bottom: -10px;">
              <h6>Daftar Antrian Pasien</h6>
              <p id="tglText" style="margin-bottom: -10px"></p>
            </div>
            <div class="card-body">
              <table class="table table-responsive table-striped">
                <thead>
                  <tr>
                    <th>Antrian</th>
                    <th>Nama</th>
                    <th>Jam Jadwal</th>
                  </tr>
                </thead>
                <tbody id="table-body">
                  
                </tbody>
              </table>
            </div>
          </div>


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
                    <input name="tgl_jadwal" type="text" id="datepicker" class="form-control @error('tgl_jadwal') is-invalid @enderror" 
                    autocomplete="off" placeholder="YYYY/MM/DD" onchange="getJamKerja(); getJadwal()">
                    @error('tgl_jadwal')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>

                  {{-- jam --}}
                  <div class="form-group">
                    <label for="jam_jadwal">Jam Jadwal</label>
                    <input type="text" name="jam_jadwal" id="timepicker" class="form-control  @error('jam_jadwal') is-invalid @enderror" autocomplete="off">
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
    var disabledDays = {!! $tgl_izin !!};
    console.log(disabledDays);

    $("#datepicker").datepicker({
      dateFormat: "yy/mm/dd",
      minDate: 0,
      beforeShowDay: function (date) {
        var day = date.getDay();
        var tanggal = jQuery.datepicker.formatDate('yy-mm-dd', date);
        
        if(disabledDays.includes(tanggal)){
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
    let id_dokter = "{{ $id_dokter }}";
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
  function getJadwal(){
    let dataAntrian;
    const api = "{{ url('/api/data-jadwal/') }}";
    let id_dokter = "{{ Auth::guard('dokter')->user()->id_dokter }}";
    let tanggal = document.getElementById("datepicker").value;
    let newTgl = moment(tanggal).format('YYYY-MM-DD');

    axios.get(api+'/'+id_dokter+'/'+newTgl, {
    })
    .then(function (response) {
      dataAntrian = response.data.jadwal;
      console.log(dataAntrian);
      $('#dataAntrian').removeClass('d-none');
      renderDataInTheTable(dataAntrian);

      // set info tanggal card
      moment.locale('id');
      let tglText = moment(newTgl).format('LL');
      console.log(tglText);
      $("#tglText").html(tglText);
    })
    .catch(function (error) {
      console.log(error);
    });

    function renderDataInTheTable(dataAntrian) {
      const mytable = document.getElementById("table-body");
      mytable.innerHTML = '';
      dataAntrian.forEach(data => {
        let newRow = document.createElement("tr");
        Object.values(data).forEach((value, index) => {
          let cell = document.createElement("td");
          if(index === 2)
            {
              cell.innerText = moment(value, 'HH:mm:ss').format('HH:mm');
              console.log(cell.innerText);
            }else{
                cell.innerText = value;
            }

          newRow.appendChild(cell);
        })
        mytable.appendChild(newRow);
      });
    }
  }
  
</script>
@endsection