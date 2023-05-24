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
        Schema::create('jadwalpraktik', function (Blueprint $table) {
            $table->id();
            $table->string('id_dokter', 10);
            $table->string('hari', 10);
            $table->string('jam_kerja', 50);
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
        Schema::dropIfExists('jadwalpraktik');
    }
};
