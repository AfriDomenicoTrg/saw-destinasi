

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_preferensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_sesi')->nullable(); // nama/deskripsi preferensi
            $table->json('bobot_kriteria'); // menyimpan bobot dalam format JSON
            $table->json('destinasi_terpilih')->nullable(); // destinasi yang dibandingkan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_preferensis');
    }
};
