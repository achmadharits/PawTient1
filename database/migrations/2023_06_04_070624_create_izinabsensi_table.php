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
        Schema::create('izinabsensi', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_izin');
            $table->string('alasan', 200);
            $table->string('id_dokter', 10);
            $table->foreign('id_dokter')->references('id_dokter')->on('dokter')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('izinabsensi');
    }
};
