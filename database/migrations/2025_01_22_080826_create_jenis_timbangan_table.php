<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jenis_timbangan', function (Blueprint $table) {
            $table->id('id_jenis_timbangan');
            $table->string('nama_jenis_timbangan')->unique(); // Nama jenis timbangan seperti "Kiloan" atau "Satuan"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_timbangan');
    }
};
