<?php

namespace App\ImportsTabungan\Tabungan\Excel;

use App\Models\Tabungan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Import implements ToModel, WithHeadingRow
{
    use Importable;
    private $tabungans;

    public function __construct()
    {
        $this->tabungans = Tabungan::select('id', 'no_transaksi', 'keterangan')->get();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Tabungan([
            'tanggal_transaksi'        => $row['tanggal_transaksi'],
            'no_transaksi'        => $row['no_transaksi'],
            'keterangan'          => $row['keterangan'],
            'debet'               => $row['debet'],
            'kredit'              => $row['kredit'],
            'saldo'               => $row['saldo'],

        ]);
    }
}
