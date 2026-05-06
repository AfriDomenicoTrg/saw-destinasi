<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Admin
        User::create([
            'name' => 'Gabriel Tarigan',
            'email' => 'gabriel@spkwisata.com',
            'password' => Hash::make('gabriel123'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Afri Tarigan',
            'email' => 'afri@spkwisata.com',
            'password' => Hash::make('afri123'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Hilman Natanael',
            'email' => 'hilman@spkwisata.com',
            'password' => Hash::make('hilman123'),
            'role' => 'admin',
        ]);

        // Data Kriteria
        $kriterias = [
            ['kode_kriteria' => 'C1', 'nama_kriteria' => 'Budget', 'tipe' => 'cost', 'bobot' => 0.25],
            ['kode_kriteria' => 'C2', 'nama_kriteria' => 'Jarak Tempuh', 'tipe' => 'cost', 'bobot' => 0.20],
            ['kode_kriteria' => 'C3', 'nama_kriteria' => 'Fasilitas', 'tipe' => 'benefit', 'bobot' => 0.20],
            ['kode_kriteria' => 'C4', 'nama_kriteria' => 'Keindahan', 'tipe' => 'benefit', 'bobot' => 0.20],
            ['kode_kriteria' => 'C5', 'nama_kriteria' => 'Harga Tiket', 'tipe' => 'cost', 'bobot' => 0.15],
        ];

        foreach ($kriterias as $kriteria) {
            Kriteria::create($kriteria);
        }

        // Info Console
        $this->command->info('✅ Admin & 5 Kriteria berhasil ditambahkan!');
    }
}
