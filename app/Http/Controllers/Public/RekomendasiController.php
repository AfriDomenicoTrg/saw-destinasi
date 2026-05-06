<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    public function index()
    {
        $wisatas = Wisata::orderBy('nama_wisata')->get();
        return view('public.index', compact('wisatas'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'budget' => 'required|numeric|min:0',
            'jarak' => 'required|numeric|min:0',
        ]);

        $userBudget = $request->input('budget');
        $userJarak = $request->input('jarak');

        $wisatas = Wisata::all();
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();

        // Ambil nilai dari tabel penilaian untuk C3, C4, C5
        $penilaians = Penilaian::with(['wisata', 'kriteria'])->get();

        // Mapping nilai dari database
        $nilaiDatabase = [];
        foreach ($penilaians as $p) {
            $nilaiDatabase[$p->wisata_id][$p->kriteria->kode_kriteria] = $p->nilai;
        }

        // Siapkan matrix nilai
        $nilaiMatrix = [];
        foreach ($wisatas as $wisata) {
            // Nilai dari USER
            $nilaiMatrix[$wisata->id]['C1'] = $userJarak;      // Jarak (user input)
            $nilaiMatrix[$wisata->id]['C5'] = $userBudget;     // Budget (user input)

            // Nilai dari ADMIN (dari tabel penilaian)
            $nilaiMatrix[$wisata->id]['C2'] = $nilaiDatabase[$wisata->id]['C5'] ?? 0; // Harga Tiket
            $nilaiMatrix[$wisata->id]['C3'] = $nilaiDatabase[$wisata->id]['C3'] ?? 3; // Fasilitas
            $nilaiMatrix[$wisata->id]['C4'] = $nilaiDatabase[$wisata->id]['C4'] ?? 3; // Keindahan
        }

        // Hitung SAW
        $ranking = $this->calculateSAW($wisatas, $kriterias, $nilaiMatrix, $userBudget, $userJarak);

        return view('public.result', compact('ranking', 'kriterias', 'userBudget', 'userJarak'));
    }

    private function calculateSAW($wisatas, $kriterias, $nilaiMatrix, $userBudget, $userJarak)
    {
        $normalized = [];

        foreach ($kriterias as $kriteria) {
            $kode = $kriteria->kode_kriteria;
            $nilaiAll = [];

            foreach ($wisatas as $wisata) {
                $nilaiAll[] = $nilaiMatrix[$wisata->id][$kode] ?? 0;
            }

            $nilaiAll = array_filter($nilaiAll, function($v) { return $v > 0; });
            if (empty($nilaiAll)) continue;

            if ($kriteria->tipe === 'benefit') {
                $max = max($nilaiAll);
                foreach ($wisatas as $wisata) {
                    $nilai = $nilaiMatrix[$wisata->id][$kode] ?? 0;
                    $normalized[$wisata->id][$kriteria->id] = $max > 0 ? $nilai / $max : 0;
                }
            } else {
                $min = min($nilaiAll);
                foreach ($wisatas as $wisata) {
                    $nilai = $nilaiMatrix[$wisata->id][$kode] ?? 0;
                    $normalized[$wisata->id][$kriteria->id] = $nilai > 0 ? $min / $nilai : 0;
                }
            }
        }

        // Hitung preferensi
        $preferences = [];
        foreach ($wisatas as $wisata) {
            $total = 0;
            foreach ($kriterias as $kriteria) {
                $total += $kriteria->bobot * ($normalized[$wisata->id][$kriteria->id] ?? 0);
            }
            $preferences[$wisata->id] = $total;
        }

        // Buat ranking
        $ranking = [];
        foreach ($wisatas as $wisata) {
            $ranking[] = [
                'wisata' => $wisata,
                'nilai' => $preferences[$wisata->id] ?? 0,
                'normalized_values' => $normalized[$wisata->id] ?? [],
                'harga_tiket' => $nilaiMatrix[$wisata->id]['C2'] ?? 0,
                'fasilitas' => $nilaiMatrix[$wisata->id]['C3'] ?? 0,
                'keindahan' => $nilaiMatrix[$wisata->id]['C4'] ?? 0,
                'rank' => 0
            ];
        }

        usort($ranking, function($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });

        foreach ($ranking as $index => $item) {
            $ranking[$index]['rank'] = $index + 1;
        }

        return collect($ranking);
    }
}
