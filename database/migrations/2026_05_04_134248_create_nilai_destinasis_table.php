

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_destinasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_destinasi')->constrained('destinasi')->onDelete('cascade');
            $table->foreignId('id_kriteria')->constrained('kriteria')->onDelete('cascade');
            $table->decimal('nilai', 10, 2);
            $table->timestamps();

            $table->unique(['id_destinasi', 'id_kriteria']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_destinasis');
    }
};
