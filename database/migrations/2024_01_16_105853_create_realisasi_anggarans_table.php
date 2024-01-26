<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealisasiAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realisasi_anggarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('bulan');
            $table->unsignedInteger('tahun');
            $table->string('deskripsi');
            $table->decimal('anggaran', 15, 2);
            $table->decimal('realisasi', 15, 2);
            $table->decimal('selisih', 15, 2)->storedAs('anggaran - realisasi'); // This assumes your database supports computed columns
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
        Schema::dropIfExists('realisasi_anggarans');
    }
}
