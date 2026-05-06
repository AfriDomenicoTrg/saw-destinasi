<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wisata_id')->constrained('wisatas')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->float('nilai', 10, 2); // nilai mentah (contoh: harga 25000, jarak 5km, fasilitas 4)
            $table->timestamps();

            $table->unique(['wisata_id', 'kriteria_id']); // 1 wisata hanya punya 1 nilai per kriteria
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
