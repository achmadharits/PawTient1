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
        Schema::create('dokter', function (Blueprint $table) {
            $table->string('id_dokter', 10);
            $table->primary('id_dokter');
            $table->char('nama',100);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_str');
            $table->string('no_hp')->nullable();
            $table->char('alamat',255)->nullable();
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
        Schema::dropIfExists('dokter');
    }
};
