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
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->text('diagnosis')->change();
            $table->longText('odontogram')->change();
            $table->longText('anamnesis')->change();
            $table->text('perawatan')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->string('diagnosis', 200)->change();
            $table->string('odontogram', 200)->change();
            $table->string('anamnesis')->change();
            $table->string('perawatan', 200)->change();
        });
    }
};
