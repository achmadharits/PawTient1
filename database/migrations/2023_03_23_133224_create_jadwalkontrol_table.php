<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwalkontrol', function (Blueprint $table) {
            $table->string('id_jadwal', 10);
            $table->primary('id_jadwal');
            $table->string('id_dokter', 10);
            $table->string('id_pasien', 10);
            $table->foreign('id_dokter')->references('id_dokter')->on('dokter')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('tgl_jadwal');
            $table->char('status', 50);
            $table->string('pesan')->nullable();
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
        Schema::dropIfExists('jadwalkontrol');
    }
};
