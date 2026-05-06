@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview sistem SPK Wisata')

@section('content')
<!-- Welcome Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-6 mb-8 text-white">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-blue-100">Berikut adalah ringkasan data sistem SPK Wisata hari ini</p>
        </div>
        <div class="flex items-center space-x-2 bg-white/20 rounded-full px-4 py-2">
            <i class="fas fa-calendar-alt"></i>
            <span class="text-sm">{{ now()->format('l, d F Y') }}</span>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Wisata</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalWisata }}</p>
                <div class="flex items-center mt-2 text-xs text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>+{{ $recentWisatas->count() }} bulan ini</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-umbrella-beach text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Kriteria</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalKriteria }}</p>
                <div class="flex items-center mt-2 text-xs">
                    @if($bobotStatus == 'perfect')
                        <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i> Bobot 100%</span>
                    @elseif($bobotStatus == 'over')
                        <span class="text-red-600"><i class="fas fa-exclamation-triangle mr-1"></i> Bobot > 100%</span>
                    @else
                        <span class="text-yellow-600"><i class="fas fa-info-circle mr-1"></i> Bobot < 100%</span>
                    @endif
                </div>
            </div>
            <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-sliders-h text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Penilaian</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalPenilaian }}</p>
                <div class="flex items-center mt-2 text-xs text-blue-600">
                    <i class="fas fa-percent mr-1"></i>
                    <span>Kelengkapan {{ $kelengkapanData }}%</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-star text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Admin</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalAdmin }}</p>
                <div class="flex items-center mt-2 text-xs text-gray-500">
                    <i class="fas fa-user-shield mr-1"></i>
                    <span>Akses penuh sistem</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">
                <i class="fas fa-users text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Progress Kelengkapan Data -->
<div class="bg-white rounded-2xl p-6 shadow-sm mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="font-bold text-gray-800 flex items-center">
                <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                Kelengkapan Data Penilaian
            </h3>
            <p class="text-xs text-gray-500 mt-1">Target minimal {{ $targetMinimal }}% untuk perhitungan SAW optimal</p>
        </div>
        <span class="text-2xl font-bold {{ $kelengkapanData >= $targetMinimal ? 'text-green-600' : ($kelengkapanData >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
            {{ $kelengkapanData }}%
        </span>
    </div>
    <div class="relative pt-1">
        <div class="overflow-hidden h-3 text-xs flex rounded-full bg-gray-200">
            <div style="width: {{ $kelengkapanData }}%"
                 class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center rounded-full transition-all duration-1000
                        {{ $kelengkapanData >= $targetMinimal ? 'bg-green-500' : ($kelengkapanData >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}">
            </div>
        </div>
        <div class="flex justify-between mt-2 text-xs text-gray-400">
            <span>0%</span>
            <span>50%</span>
            <span>Target {{ $targetMinimal }}%</span>
            <span>100%</span>
        </div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Charts Column (2/3 width) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Chart Wisata per Bulan -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 flex items-center">
                    <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                    Tren Penambahan Wisata
                </h3>
                <span class="text-xs text-gray-400">12 bulan terakhir</span>
            </div>
            <canvas id="wisataChart" height="200"></canvas>
        </div>

        <!-- Chart Penilaian per Kriteria -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
                Jumlah Penilaian per Kriteria
            </h3>
            <canvas id="penilaianChart" height="200"></canvas>
        </div>

        <!-- Distribusi Nilai -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
                Distribusi Nilai Fasilitas & Keindahan
            </h3>
            <canvas id="distribusiChart" height="200"></canvas>
        </div>
    </div>

    <!-- Right Column (1/3 width) -->
    <div class="space-y-6">
        <!-- Bobot Kriteria -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
                Bobot Kriteria
                <span class="ml-auto text-xs px-2 py-1 rounded-full {{ $bobotStatus == 'perfect' ? 'bg-green-100 text-green-600' : ($bobotStatus == 'over' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600') }}">
                    {{ $bobotMessage }}
                </span>
            </h3>
            <div class="space-y-4">
                @foreach($kriterias as $kriteria)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">
                            {{ $kriteria->kode_kriteria }} - {{ $kriteria->nama_kriteria }}
                            <span class="text-xs text-gray-400 ml-1">({{ ucfirst($kriteria->tipe) }})</span>
                        </span>
                        <span class="text-gray-600 font-semibold">{{ ($kriteria->bobot * 100) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-full h-2 transition-all duration-500" style="width: {{ $kriteria->bobot * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
                <div class="pt-3 mt-2 border-t border-gray-200">
                    <div class="flex justify-between text-sm font-bold">
                        <span class="text-gray-800">Total Bobot</span>
                        <span class="{{ $bobotStatus == 'perfect' ? 'text-green-600' : ($bobotStatus == 'over' ? 'text-red-600' : 'text-yellow-600') }}">
                            {{ ($totalBobot * 100) }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wisata Terbaik per Kriteria -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                Wisata Terbaik per Kriteria
            </h3>
            <div class="space-y-3">
                @foreach($wisataTerbaik as $kode => $data)
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-xl">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-crown text-yellow-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $data['nama'] }}</p>
                            <p class="text-xs text-gray-500">Kriteria {{ $kode }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-green-600">
                        @if($kode == 'C2')
                            Rp {{ number_format($data['nilai'], 0, ',', '.') }}
                        @else
                            {{ $data['nilai'] }}/5
                        @endif
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Wisata Terfavorit -->
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl p-6 shadow-sm text-white">
            <div class="text-center">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-crown text-white text-3xl"></i>
                </div>
                <h4 class="text-sm font-medium opacity-90">Wisata Terfavorit</h4>
                <p class="text-xl font-bold mt-1">{{ $topWisata->nama_wisata ?? 'Belum ada' }}</p>
                <p class="text-xs opacity-80 mt-1">{{ $topWisata->lokasi ?? '' }}</p>
                @if($topWisata)
                <div class="mt-3 inline-flex items-center space-x-1 text-sm bg-white/20 rounded-full px-3 py-1">
                    <i class="fas fa-star"></i>
                    <span>{{ $topWisata->penilaians_count ?? 0 }} penilaian</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Data & Activities Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Rata-rata Nilai per Kriteria -->
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-chart-simple text-blue-500 mr-2"></i>
            Rata-rata Nilai per Kriteria
        </h3>
        <div class="space-y-4">
            @foreach($kriteriaStats as $stat)
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-medium text-gray-700">{{ $stat['kriteria']->nama_kriteria }}</span>
                    <span class="text-gray-600">
                        @if($stat['kriteria']->kode_kriteria == 'C2')
                            Rp {{ number_format($stat['rata_rata'], 0, ',', '.') }}
                        @else
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-xs {{ $i <= $stat['rata_rata'] ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                @endfor
                                <span class="ml-2">({{ $stat['rata_rata'] }}/5)</span>
                            </div>
                        @endif
                    </span>
                </div>
                @if($stat['kriteria']->kode_kriteria != 'C2')
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-full h-2" style="width: {{ ($stat['rata_rata'] / 5) * 100 }}%"></div>
                </div>
                @endif
                <div class="flex justify-between text-xs text-gray-400 mt-1">
                    <span>Min: {{ $stat['min_nilai'] }}</span>
                    <span>Terisi: {{ $stat['total_terisi'] }}</span>
                    <span>Max: {{ $stat['max_nilai'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Wisata Terbaru & Aktivitas -->
    <div class="space-y-6">
        <!-- Wisata Terbaru -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 flex items-center">
                    <i class="fas fa-clock text-blue-500 mr-2"></i>
                    Wisata Terbaru
                </h3>
                <a href="{{ route('admin.wisata.index') }}" class="text-xs text-blue-600 hover:text-blue-700">
                    Lihat semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-3">
                @forelse($recentWisatas as $wisata)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-blue-50 transition group">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 group-hover:text-blue-600 transition">{{ $wisata->nama_wisata }}</p>
                            <p class="text-xs text-gray-500">{{ $wisata->lokasi }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-gray-400">{{ $wisata->created_at->diffForHumans() }}</span>
                        <div class="text-xs text-gray-400 mt-1">
                            <i class="fas fa-code-branch mr-1"></i>{{ $wisata->kode_wisata }}
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 py-8">Belum ada data wisata</p>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-6 shadow-sm">
            <h3 class="font-bold text-white mb-4 flex items-center">
                <i class="fas fa-bolt mr-2"></i>
                Akses Cepat
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.wisata.create') }}" class="flex items-center justify-center space-x-2 px-4 py-3 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 transition text-white">
                    <i class="fas fa-plus-circle"></i>
                    <span class="text-sm font-medium">Tambah Wisata</span>
                </a>
                <a href="{{ route('admin.kriteria.create') }}" class="flex items-center justify-center space-x-2 px-4 py-3 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 transition text-white">
                    <i class="fas fa-plus-circle"></i>
                    <span class="text-sm font-medium">Tambah Kriteria</span>
                </a>
                <a href="{{ route('admin.penilaian.index') }}" class="flex items-center justify-center space-x-2 px-4 py-3 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 transition text-white">
                    <i class="fas fa-star"></i>
                    <span class="text-sm font-medium">Input Penilaian</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Rekomendasi Sistem -->
@if(count($recommendations) > 0)
<div class="bg-white rounded-2xl p-6 shadow-sm">
    <h3 class="font-bold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
        Rekomendasi Sistem
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($recommendations as $rec)
        <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-xl">
            <div class="w-10 h-10 {{ $rec['bg_color'] ?? 'bg-gray-100' }} rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="{{ $rec['icon'] }} {{ $rec['color'] }} text-lg"></i>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-gray-800 text-sm">{{ $rec['title'] }}</h4>
                <p class="text-xs text-gray-500 mt-1">{{ $rec['message'] }}</p>
                <a href="{{ $rec['action'] }}" class="text-xs text-blue-600 hover:text-blue-700 mt-2 inline-block">
                    Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Wisata per Bulan
    const ctx1 = document.getElementById('wisataChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: {!! json_encode($bulanLabels) !!},
            datasets: [{
                label: 'Jumlah Wisata Baru',
                data: {!! json_encode($wisataPerBulan) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
            }
        }
    });

    // Chart Penilaian per Kriteria
    const ctx2 = document.getElementById('penilaianChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: {!! json_encode($kriterias->pluck('kode_kriteria')->toArray()) !!},
            datasets: [{
                label: 'Jumlah Penilaian',
                data: {!! json_encode($penilaianPerKriteria) !!},
                backgroundColor: ['#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#ef4444'],
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
            }
        }
    });

    // Chart Distribusi Nilai
    const ctx3 = document.getElementById('distribusiChart').getContext('2d');
    new Chart(ctx3, {
        type: 'doughnut',
        data: {
            labels: ['Nilai 1', 'Nilai 2', 'Nilai 3', 'Nilai 4', 'Nilai 5'],
            datasets: [{
                data: {!! json_encode(array_values($distribusiNilai)) !!},
                backgroundColor: ['#ef4444', '#f59e0b', '#eab308', '#10b981', '#3b82f6'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
@endsection
