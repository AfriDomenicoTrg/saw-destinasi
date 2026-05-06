<?php
// database/migrations/xxxx_xx_xx_000003_create_kriteria_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kriteria')->unique(); // C1, C2, C3
            $table->string('nama_kriteria'); // Harga Tiket, Jarak, Fasilitas
            $table->enum('tipe', ['benefit', 'cost']);
            $table->float('bobot'); // bobot dalam bentuk desimal (0.25, 0.30)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriterias');
    }
};
