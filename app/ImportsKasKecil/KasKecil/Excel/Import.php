<?php

namespace App\ImportsKasKecil\KasKecil\Excel;

use App\Models\KasKecil;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Import implements ToModel, WithHeadingRow
{
    use Importable;
    private $kas_kecils;

    public function __construct()
    {
        $this->kas_kecils = KasKecil::select('id', 'no_transaksi', 'nama_transaksi')->get();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new KasKecil([
            'tanggal_transaksi'        => $row['tanggal_transaksi'],
            'no_transaksi'        => $row['no_transaksi'],
            'nama_transaksi'      => $row['nama_transaksi'],
            'debet'               => $row['debet'],
            'kredit'              => $row['kredit'],
            'saldo'               => $row['saldo'],
        ]);
    }
}
