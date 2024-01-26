<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabungansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabungans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_transaksi');
            $table->string('no_transaksi');
            $table->string('keterangan');
            $table->decimal('debet', 10, 2); // Perubahan: Menggunakan tipe data decimal dengan panjang total 10 dan 2 digit di belakang koma
            $table->decimal('kredit', 10, 2); // Perubahan: Menggunakan tipe data decimal dengan panjang total 10 dan 2 digit di belakang koma
            $table->decimal('saldo', 10, 2)->nullable();; // Perubahan: Menggunakan tipe data decimal dengan panjang total 10 dan 2 digit di belakang koma
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabungans');
    }
}
