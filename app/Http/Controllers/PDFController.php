<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Reservasi;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        $reservasi = Reservasi::find($id);
        $data = [
            'title' => 'PawTient',
            'date' => date('m/d/Y'),
            'id' => $reservasi->id,
            'id_dokter' => $reservasi->id_dokter,
            'id_pasien' => $reservasi->id_pasien,
            'tanggal_reservasi' => $reservasi->tgl_reservasi,
            'jam_reservasi' => $reservasi->jam_reservasi,
            'jenis_hewan' => $reservasi->jenis_hewan,
            'status_reservasi' => $reservasi->status,
            'deskripsi_reservasi' => $reservasi->deskripsi,
        ];

        $pdf = PDF::loadView('printPDF', $data);

        return $pdf->download('pawtient-reservasi.pdf');
    }
}
