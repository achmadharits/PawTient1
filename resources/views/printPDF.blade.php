<!DOCTYPE html>

<html>

<head>

    <title>Laravel 9 Generate PDF Example - ItSolutionStuff.com</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <div>
        <h1>{{ $title }}</h1>

        <p>{{ $date }}</p>

        <p>Berikut informasi detail terkait reservasi:</p>



        <table class="table table-bordered">

            <tr>
                <th>ID Reservasi</th>
                <th>ID Dokter</th>
                <th>ID Pasien</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Jenis Hewan</th>
                <th>Status</th>
                <th>Deskirpsi</th>


            <tr>
                <td>{{ $id }}</td>
                <td>{{ $id_dokter }}</td>
                <td>{{ $id_pasien }}</td>
                <td>{{ $tanggal_reservasi}}</td>
                <td>{{ $jam_reservasi }}</td>
                <td>{{ $jenis_hewan}}</td>
                <td>{{ $status_reservasi }}</td>
                <td>{{ $deskripsi_reservasi }}</td>
            </tr>

        </table>
    </div>