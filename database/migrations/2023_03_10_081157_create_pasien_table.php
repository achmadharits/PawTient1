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
        Schema::create('pasien', function (Blueprint $table) {
            $table->string('id_pasien', 10);
            $table->primary('id_pasien');
            $table->char('nama',100);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_hp')->nullable();
            $table->char('alamat',255)->nullable();
            $table->integer('usia')->nullable();
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
        Schema::dropIfExists('pasien');
    }
};
