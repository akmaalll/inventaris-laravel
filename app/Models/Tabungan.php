<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tabungan extends Model
{
    use HasFactory;

    protected $table = 'tabungans';
    protected $fillable = ['tanggal_transaksi', 'no_transaksi', 'keterangan', 'debet', 'kredit', 'saldo'];
    protected $guarded = ['created_at', 'updated_at'];


    // Trigger untuk mengupdate saldo setiap kali debet atau kredit diisi
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ambil saldo dari data sebelumnya
            $saldo_sebelumnya = static::latest('tanggal_transaksi')->first();

            // Tentukan nilai saldo untuk data saat ini
            $model->saldo = $saldo_sebelumnya
                ? $saldo_sebelumnya->saldo + $model->debet - $model->kredit
                : $model->debet - $model->kredit; // Perubahan pada bagian ini
        });
    }
}    









//     public function indonesian_format_date($value)
//     {
//         return Carbon::parse($value)->format('d-m-Y');
//     }

//     public function indonesian_currency($value)
//     {
//         return number_format($value, 2, ', ', '.');
//     }
// }
