<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfControllertb extends Controller
{
    public function generatePDF(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $nama_bulan = \DateTime::createFromFormat('!m', $bulan)->format('F');
        $tabungans = Tabungan::whereMonth('tanggal_transaksi', $bulan)->whereYear('tanggal_transaksi', $tahun)->get();
        $toko = 'Lembaga Kesejahteraan Sosial Anak FAJAR HARAPAN';
        $judul_laporan = 'Laporan tabungan  ' . $nama_bulan . ' ' . $tahun;

        $pdf = PDF::loadView('pages.tabungan.pdf', compact(['tabungans', 'toko', 'judul_laporan']))->setPaper('a4');
        return $pdf->download('print-tabungan.pdf');
    }
}




// <?php

// namespace App\Http\Controllers;

// use App\Models\Tabungan;
// use Barryvdh\DomPDF\Facade\Pdf;

// class PdfControllertb extends Controller
// {
//     public function generatePDF()
//     {
//         $tabungans = Tabungan::all();
//         $toko = 'PSSA FAJAR HARAPAN';
//         $pdf = PDF::loadView('pages.tabungan.pdf', compact(['tabungans', 'toko']))->setPaper('a4');
//         return $pdf->download('print-tabungan.pdf');
//     }
// }















//     public function generatePDFOne($id)
//     {
//         $comodities = Comodities::find($id);
//         $toko = 'PSSA FAJAR HARAPAN';
//         $pdf = PDF::loadView('pages.comodities.pdfone', compact(['comodities', 'toko']))->setPaper('a4');
//         return $pdf->download('print.pdf');
//     }
// }
