<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi - SPK Wisata</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102,126,234,0.4);
        }

        .rank-1 { background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); }
        .rank-2 { background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%); }
        .rank-3 { background: linear-gradient(135deg, #fb923c 0%, #c2410c 100%); }

        .card-winner {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-mountain text-blue-600 text-xl"></i>
                    <span class="font-bold text-gray-800">SPK Wisata</span>
                </div>
                <a href="{{ route('public.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                    <i class="fas fa-home mr-1"></i> Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <!-- Summary User Input -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                <i class="fas fa-sliders-h text-blue-500 mr-2"></i>
                Preferensi Anda:
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-50 rounded-lg p-3 text-center">
                    <p class="text-sm text-gray-500">Budget Perjalanan</p>
                    <p class="text-xl font-bold text-blue-600">Rp {{ number_format($userBudget ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-3 text-center">
                    <p class="text-sm text-gray-500">Jarak Tempuh Maksimal</p>
                    <p class="text-xl font-bold text-green-600">{{ number_format($userJarak ?? 0, 0) }} km</p>
                </div>
            </div>
        </div>

        <!-- Winner Announcement -->
        @if($ranking->isNotEmpty())
            <div class="card-winner text-center mb-8">
                <div class="inline-block bg-white rounded-2xl shadow-xl p-6 max-w-md">
                    <div class="text-5xl mb-3">🏆</div>
                    <h2 class="text-2xl font-bold text-gray-800">Rekomendasi Terbaik Untukmu!</h2>
                    <div class="mt-4">
                        @php $winner = $ranking->first(); @endphp
                        <div class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-orange-600">
                            {{ $winner['wisata']->nama_wisata }}
                        </div>
                        <div class="mt-2 text-gray-500">{{ $winner['wisata']->lokasi }}</div>
                        <div class="mt-3 inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                            Skor: {{ number_format($winner['nilai'] * 100, 2) }}%
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Ranking Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Ranking Rekomendasi Wisata</h2>
                <p class="text-blue-100 text-sm mt-1">Berdasarkan preferensi budget dan jarak yang Anda masukkan</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Rank</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Wisata</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Lokasi</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Harga Tiket</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Fasilitas</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Keindahan</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Skor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($ranking as $item)
                            @php
                                $rankBg = $item['rank'] == 1 ? 'bg-yellow-50' : ($item['rank'] == 2 ? 'bg-gray-50' : ($item['rank'] == 3 ? 'bg-orange-50' : ''));
                                $rankIcon = $item['rank'] == 1 ? '🥇' : ($item['rank'] == 2 ? '🥈' : ($item['rank'] == 3 ? '🥉' : $item['rank']));
                            @endphp
                            <tr class="{{ $rankBg }} hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-lg">
                                        {{ $rankIcon }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-800">{{ $item['wisata']->nama_wisata }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $item['wisata']->kode_wisata ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    <i class="fas fa-map-marker-alt text-blue-500 mr-1"></i>
                                    {{ $item['wisata']->lokasi }}
                                </td>
                                <td class="px-6 py-4 text-center text-sm">
                                    Rp {{ number_format($item['harga_tiket'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($item['fasilitas'] ?? 0) ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($item['keindahan'] ?? 0) ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex items-center space-x-2">
                                        <div class="w-20 bg-gray-200 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-full h-2" style="width: {{ ($item['nilai'] ?? 0) * 100 }}%"></div>
                                        </div>
                                        <span class="font-bold text-gray-800">{{ number_format(($item['nilai'] ?? 0) * 100, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tombol Aksi - HAPUS $wisataIds karena tidak digunakan -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-center">
                <a href="{{ route('public.index') }}" class="btn-primary text-white px-8 py-3 rounded-lg font-semibold shadow-lg">
                    <i class="fas fa-redo mr-2"></i>
                    Hitung Ulang dengan Preferensi Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-8">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} SPK Wisata - Sistem Pendukung Keputusan Metode SAW
            </p>
        </div>
    </footer>
</body>
</html>
