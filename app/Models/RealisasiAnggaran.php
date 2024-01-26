<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiAnggaran extends Model
{
    protected $table = 'realisasi_anggarans';
    protected $fillable = [
        'kode',
        'bulan',
        'tahun',
        'deskripsi',
        'anggaran',
        'realisasi',
        'selisih'

    ];
}
