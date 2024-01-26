<?php


namespace App\Http\Controllers;

use App\Models\KasKecil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfControllerkk extends Controller
{
    public function generatePDF(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $nama_bulan = \DateTime::createFromFormat('!m', $bulan)->format('F');
        $kas_kecils = KasKecil::whereMonth('tanggal_transaksi', $bulan)->whereYear('tanggal_transaksi', $tahun)->get();
        $toko = 'Lembaga Kesejahteraan Sosial Anak FAJAR HARAPAN';
        $judul_laporan = 'Laporan Kas Kecil ' . $nama_bulan . ' ' . $tahun;

        $pdf = PDF::loadView('pages.kaskecil.pdf', compact(['kas_kecils', 'toko', 'judul_laporan']))->setPaper('a4');
        return $pdf->download('print-kas-kecil.pdf');
    }
}
