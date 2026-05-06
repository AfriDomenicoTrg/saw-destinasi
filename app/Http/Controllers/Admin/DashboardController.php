<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wisata;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // STATISTIK UTAMA
        // ==========================================
        $totalWisata = Wisata::count();
        $totalKriteria = Kriteria::count();
        $totalPenilaian = Penilaian::count();
        $totalAdmin = User::where('role', 'admin')->count();

        // ==========================================
        // STATISTIK BOBOT
        // ==========================================
        $kriterias = Kriteria::all();
        $totalBobot = $kriterias->sum('bobot');
        $bobotStatus = $totalBobot == 1 ? 'perfect' : ($totalBobot > 1 ? 'over' : 'under');
        $bobotMessage = $bobotStatus == 'perfect' ? 'Bobot sempurna 100%' : ($bobotStatus == 'over' ? 'Bobot melebihi 100%' : 'Bobot kurang dari 100%');

        // ==========================================
        // DATA WISATA
        // ==========================================
        $recentWisatas = Wisata::orderBy('created_at', 'desc')->take(5)->get();
        $topWisata = Wisata::withCount('penilaians')
            ->orderBy('penilaians_count', 'desc')
            ->first();

        // Wisata dengan nilai tertinggi per kriteria
        $wisataTerbaik = [];
        foreach ($kriterias as $kriteria) {
            $terbaik = Penilaian::where('kriteria_id', $kriteria->id)
                ->with('wisata')
                ->orderBy('nilai', 'desc')
                ->first();
            if ($terbaik && $terbaik->wisata) {
                $wisataTerbaik[$kriteria->kode_kriteria] = [
                    'nama' => $terbaik->wisata->nama_wisata,
                    'nilai' => $terbaik->nilai
                ];
            }
        }

        // ==========================================
        // STATISTIK PENILAIAN
        // ==========================================
        $kelengkapanData = $totalWisata > 0 && $totalKriteria > 0
            ? round(($totalPenilaian / ($totalWisata * $totalKriteria)) * 100, 2)
            : 0;

        // TARGET MINIMAL (tambahkan ini)
        $targetMinimal = 80; // Target minimal kelengkapan data 80%
        $progressColor = $kelengkapanData >= $targetMinimal ? 'green' : ($kelengkapanData >= 50 ? 'yellow' : 'red');

        // Rata-rata nilai per kriteria
        $kriteriaStats = [];
        foreach ($kriterias as $kriteria) {
            $rataRata = Penilaian::where('kriteria_id', $kriteria->id)
                ->where('nilai', '>', 0)
                ->avg('nilai');

            $kriteriaStats[] = [
                'kriteria' => $kriteria,
                'rata_rata' => round($rataRata ?? 0, 2),
                'total_terisi' => Penilaian::where('kriteria_id', $kriteria->id)->count(),
                'max_nilai' => Penilaian::where('kriteria_id', $kriteria->id)->max('nilai') ?? 0,
                'min_nilai' => Penilaian::where('kriteria_id', $kriteria->id)->min('nilai') ?? 0,
            ];
        }

        // ==========================================
        // DATA UNTUK CHART
        // ==========================================
        // Wisata per bulan (12 bulan terakhir)
        $wisataPerBulan = [];
        $bulanLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $bulanLabels[] = $date->format('M Y');
            $wisataPerBulan[] = Wisata::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        // Penilaian per kriteria (untuk chart bar)
        $penilaianPerKriteria = [];
        foreach ($kriterias as $kriteria) {
            $penilaianPerKriteria[] = Penilaian::where('kriteria_id', $kriteria->id)->count();
        }

        // Distribusi nilai fasilitas & keindahan (1-5)
        $distribusiNilai = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribusiNilai[$i] = Penilaian::whereIn('kriteria_id', function($q) use ($kriterias) {
                    $q->select('id')->from('kriterias')->whereIn('kode_kriteria', ['C3', 'C4']);
                })
                ->where('nilai', $i)
                ->count();
        }

        // ==========================================
        // AKTIVITAS TERBARU
        // ==========================================
        $recentActivities = $this->getRecentActivities();

        // ==========================================
        // REKOMENDASI SISTEM
        // ==========================================
        $recommendations = [];
        if ($kelengkapanData < 80) {
            $recommendations[] = [
                'icon' => 'fas fa-database',
                'color' => 'text-yellow-500',
                'bg_color' => 'bg-yellow-100',
                'title' => 'Kelengkapan Data Rendah',
                'message' => "Data penilaian baru {$kelengkapanData}% lengkap. Segera lengkapi data untuk hasil SAW yang akurat.",
                'action' => route('admin.penilaian.index')
            ];
        }

        if ($totalBobot != 1) {
            $recommendations[] = [
                'icon' => 'fas fa-balance-scale',
                'color' => 'text-orange-500',
                'bg_color' => 'bg-orange-100',
                'title' => 'Bobot Kriteria Tidak Seimbang',
                'message' => "Total bobot saat ini " . ($totalBobot * 100) . "%. Harus 100% untuk perhitungan SAW yang valid.",
                'action' => route('admin.kriteria.index')
            ];
        }

        if ($totalWisata < 3) {
            $recommendations[] = [
                'icon' => 'fas fa-umbrella-beach',
                'color' => 'text-blue-500',
                'bg_color' => 'bg-blue-100',
                'title' => 'Tambahkan Wisata',
                'message' => "Hanya {$totalWisata} wisata tersedia. Tambahkan lebih banyak wisata untuk variasi rekomendasi.",
                'action' => route('admin.wisata.create')
            ];
        }

        return view('admin.dashboard', compact(
            'totalWisata', 'totalKriteria', 'totalPenilaian', 'totalAdmin',
            'kriterias', 'totalBobot', 'bobotStatus', 'bobotMessage',
            'recentWisatas', 'topWisata', 'wisataTerbaik',
            'kriteriaStats', 'kelengkapanData', 'progressColor', 'targetMinimal',
            'wisataPerBulan', 'bulanLabels', 'penilaianPerKriteria', 'distribusiNilai',
            'recentActivities', 'recommendations'
        ));
    }

    private function getRecentActivities()
    {
        $activities = collect();

        // Wisata terbaru
        $recentWisatas = Wisata::orderBy('created_at', 'desc')->take(3)->get();
        foreach ($recentWisatas as $wisata) {
            $activities->push((object)[
                'type' => 'create',
                'icon' => 'fa-plus-circle',
                'icon_color' => 'text-green-500',
                'bg_color' => 'bg-green-100',
                'title' => 'Wisata Baru Ditambahkan',
                'description' => $wisata->nama_wisata . ' - ' . $wisata->lokasi,
                'time' => $wisata->created_at->diffForHumans(),
                'datetime' => $wisata->created_at
            ]);
        }

        // Penilaian terbaru
        $recentPenilaians = Penilaian::with('wisata', 'kriteria')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        foreach ($recentPenilaians as $penilaian) {
            $activities->push((object)[
                'type' => 'update',
                'icon' => 'fa-star',
                'icon_color' => 'text-yellow-500',
                'bg_color' => 'bg-yellow-100',
                'title' => 'Penilaian Diperbarui',
                'description' => $penilaian->wisata->nama_wisata . ' - ' . ($penilaian->kriteria->nama_kriteria ?? 'Kriteria'),
                'time' => $penilaian->created_at->diffForHumans(),
                'datetime' => $penilaian->created_at
            ]);
        }

        return $activities->sortByDesc('datetime')->take(5);
    }
}
