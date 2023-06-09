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
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jenis');
            $table->string('id_dokter', 10);
            $table->string('id_pasien', 10);
            $table->foreign('id_jenis')->references('id_jenis')->on('jeniskonsultasi')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_dokter')->references('id_dokter')->on('dokter')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('diagnosis', 200);
            $table->date('tgl_konsultasi');
            $table->string('odontogram', 200);
            $table->string('anamnesis');
            $table->string('perawatan', 200);
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
        Schema::dropIfExists('konsultasi');
    }
};
