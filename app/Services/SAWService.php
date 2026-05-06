<?php

namespace App\Services;

use App\Models\Wisata;
use App\Models\Kriteria;
use App\Models\Penilaian;

class SAWService
{
    /**
     * Hitung normalisasi matrix
     */
    public function normalize($penilaians, $kriterias)
    {
        $normalized = [];

        foreach ($kriterias as $kriteria) {
            // Ambil semua nilai untuk kriteria ini
            $nilaiAll = $penilaians->where('kriteria_id', $kriteria->id)->pluck('nilai')->toArray();

            if ($kriteria->isBenefit()) {
                $max = max($nilaiAll);
                foreach ($penilaians->where('kriteria_id', $kriteria->id) as $penilaian) {
                    $normalized[$penilaian->wisata_id][$kriteria->id] = $penilaian->nilai / $max;
                }
            } else { // Cost
                $min = min($nilaiAll);
                foreach ($penilaians->where('kriteria_id', $kriteria->id) as $penilaian) {
                    $normalized[$penilaian->wisata_id][$kriteria->id] = $min / $penilaian->nilai;
                }
            }
        }

        return $normalized;
    }

    /**
     * Hitung nilai preferensi (V) untuk setiap alternatif
     */
    public function calculatePreference($normalized, $kriterias)
    {
        $preferences = [];

        foreach ($normalized as $wisataId => $values) {
            $total = 0;
            foreach ($kriterias as $kriteria) {
                $total += $kriteria->bobot * ($values[$kriteria->id] ?? 0);
            }
            $preferences[$wisataId] = $total;
        }

        return $preferences;
    }

    /**
     * Dapatkan ranking wisata berdasarkan SAW
     */
    public function getRanking()
    {
        // Ambil semua data
        $wisatas = Wisata::all();
        $kriterias = Kriteria::all();
        $penilaians = Penilaian::with(['wisata', 'kriteria'])->get();

        // Hitung normalisasi
        $normalized = $this->normalize($penilaians, $kriterias);

        // Hitung preferensi
        $preferences = $this->calculatePreference($normalized, $kriterias);

        // Buat ranking
        $ranking = [];
        foreach ($wisatas as $wisata) {
            $ranking[] = [
                'wisata' => $wisata,
                'nilai' => $preferences[$wisata->id] ?? 0,
                'normalized_values' => $normalized[$wisata->id] ?? []
            ];
        }

        // Urutkan dari nilai tertinggi ke terendah
        usort($ranking, function ($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });

        // Tambahkan peringkat
        foreach ($ranking as $index => $item) {
            $ranking[$index]['rank'] = $index + 1;
        }

        return $ranking;
    }
}
