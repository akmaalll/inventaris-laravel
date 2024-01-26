<?php

namespace App\ExportsKasKecil\KasKecil\Excel;

use App\Models\KasKecil;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class Export implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $kas_kecils = KasKecil::all();
        return collect([
            $this->customProcessDataKasKecilToExcel($kas_kecils)
        ]);
    }
    public function headings(): array
    {
        return [
            'Tanggal Transaksi',
            'No Transaksi',
            'Nama Transaksi',
            'Debet',
            'Kredit',
            'Saldo',
            // 'Keterangan'

        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->setAllBorders('thin')->egtDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            }
        ];
    }
    public function customProcessDataKasKecilToExcel($model)
    {
        foreach ($model as $key => $kas_kecils) {
            $data[$key]['tanggal_transaksi'] = $kas_kecils->tanggal_transaksi;
            $data[$key]['no_transaksi'] = $kas_kecils->no_transaksi;
            $data[$key]['nama_transaksi'] = $kas_kecils->nama_transaksi;
            $data[$key]['debet'] = $kas_kecils->debet;
            $data[$key]['kredit'] = $kas_kecils->kredit;
            $data[$key]['saldo'] = $kas_kecils->saldo;
            // $data[$key]['keterangan'] = $kas_kecils->keterangan;
        }

        return $data;
    }
}
