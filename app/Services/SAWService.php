<?php

namespace App\Services;

use App\Models\Wisata;
use App\Models\Kriteria;
use App\Models\Penilaian;

class SAWService
{
    /**
     * Get ranking rekomendasi wisata
     */
    public function getRanking()
    {
        // Ambil semua data
        $wisatas = Wisata::all();
        $kriterias = Kriteria::all();
        $penilaians = Penilaian::with(['wisata', 'kriteria'])->get();

        if ($wisatas->isEmpty() || $kriterias->isEmpty() || $penilaians->isEmpty()) {
            return [];
        }

        // 1. Normalisasi matrix
        $normalized = $this->normalize($penilaians, $kriterias);

        // 2. Hitung nilai preferensi
        $preferences = $this->calculatePreference($normalized, $kriterias);

        // 3. Buat ranking
        $ranking = [];
        foreach ($wisatas as $wisata) {
            $ranking[] = [
                'wisata' => $wisata,
                'nilai' => $preferences[$wisata->id] ?? 0,
                'normalized_values' => $normalized[$wisata->id] ?? []
            ];
        }

        // Urutkan dari nilai tertinggi
        usort($ranking, function ($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });

        // Tambahkan peringkat
        foreach ($ranking as $index => $item) {
            $ranking[$index]['rank'] = $index + 1;
        }

        return $ranking;
    }

    /**
     * Normalisasi matrix
     */
    private function normalize($penilaians, $kriterias)
    {
        $normalized = [];

        foreach ($kriterias as $kriteria) {
            // Ambil semua nilai untuk kriteria ini
            $nilaiAll = $penilaians->where('kriteria_id', $kriteria->id)->pluck('nilai')->toArray();

            if (empty($nilaiAll)) continue;

            if ($kriteria->tipe === 'benefit') {
                $max = max($nilaiAll);
                foreach ($penilaians->where('kriteria_id', $kriteria->id) as $penilaian) {
                    $normalized[$penilaian->wisata_id][$kriteria->id] = $max > 0 ? $penilaian->nilai / $max : 0;
                }
            } else { // cost
                $min = min($nilaiAll);
                foreach ($penilaians->where('kriteria_id', $kriteria->id) as $penilaian) {
                    $normalized[$penilaian->wisata_id][$kriteria->id] = $penilaian->nilai > 0 ? $min / $penilaian->nilai : 0;
                }
            }
        }

        return $normalized;
    }

    /**
     * Hitung nilai preferensi
     */
    private function calculatePreference($normalized, $kriterias)
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
     * Get matrix penilaian untuk ditampilkan ke user
     */
    public function getPenilaianMatrix()
    {
        $wisatas = Wisata::all();
        $kriterias = Kriteria::all();
        $penilaians = Penilaian::all()->keyBy(function ($item) {
            return $item->wisata_id . '_' . $item->kriteria_id;
        });

        return [
            'wisatas' => $wisatas,
            'kriterias' => $kriterias,
            'penilaians' => $penilaians
        ];
    }
}
