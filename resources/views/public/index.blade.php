<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SPK Wisata - Temukan Wisata Impianmu</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 2000 2000'%3E%3Cpath fill='rgba(255,255,255,0.05)' d='M0,0 L2000,0 L2000,2000 L0,2000 Z M100,100 L1900,100 L1900,1900 L100,1900 Z'/%3E%3Ccircle cx='500' cy='500' r='100' fill='rgba(255,255,255,0.03)'/%3E%3Ccircle cx='1500' cy='1500' r='150' fill='rgba(255,255,255,0.02)'/%3E%3C/svg%3E") repeat;
            pointer-events: none;
        }

        .card-wisata {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .card-wisata:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 40px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(30deg);
            transition: all 0.5s;
        }

        .btn-primary:hover::after {
            left: 100%;
        }

        .input-range {
            transition: all 0.3s ease;
            background: white;
        }

        .input-range:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102,126,234,0.15);
            outline: none;
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
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

        .badge-glow {
            animation: glow 2s ease-in-out infinite;
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 0 5px rgba(102,126,234,0.5); }
            50% { box-shadow: 0 0 20px rgba(102,126,234,0.8); }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-md shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl overflow-hidden shadow-lg floating">
                        <img src="{{ asset('images/logo.jpeg') }}"
                            alt="Logo SPK Wisata"
                            class="w-full h-full object-cover">
                    </div>
                    <div>
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">SPK Wisata</span>
                        <p class="text-xs text-gray-500 hidden md:block">Sistem Pendukung Keputusan</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-1 text-sm text-gray-500">
                        <i class="fas fa-star text-yellow-500"></i>
                        <span>Metode SAW</span>
                    </div>
                    <a href="{{ route('login') }}" class="flex items-center space-x-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl text-sm font-semibold transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin Panel</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white pt-32 pb-20 relative">
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6 badge-glow">
                <i class="fas fa-wand-magic text-yellow-400"></i>
                <span class="text-sm">Smart Recommendation System</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight">
                Temukan Wisata<br>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">Impianmu!</span>
            </h1>
            <p class="text-xl text-purple-100 mb-8 max-w-2xl mx-auto">Masukkan budget dan jarak tempuh, dapatkan rekomendasi wisata terbaik yang sesuai dengan keinginanmu</p>
            <div class="flex flex-wrap items-center justify-center gap-4 text-sm">
                <div class="flex items-center space-x-2 bg-white/10 rounded-full px-4 py-2">
                    <i class="fas fa-check-circle text-green-400"></i>
                    <span>Gratis</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/10 rounded-full px-4 py-2">
                    <i class="fas fa-chart-line text-blue-400"></i>
                    <span>Perhitungan Akurat</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/10 rounded-full px-4 py-2">
                    <i class="fas fa-mobile-alt text-purple-400"></i>
                    <span>Tanpa Login</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Form Input User -->
    <section class="py-16 px-4">
        <div class="container mx-auto max-w-4xl">
            <div class="fade-in-up">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-sliders-h text-white text-2xl"></i>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Temukan Rekomendasi</h2>
                                <p class="text-blue-100 text-sm mt-1">Isi preferensi di bawah ini</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('public.calculate') }}" method="POST" class="p-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Budget -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-3">
                                    <i class="fas fa-wallet text-blue-500 mr-2"></i>
                                    Budget Perjalanan
                                </label>
                                <div class="relative group">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-semibold">Rp</span>
                                    <input type="number"
                                           name="budget"
                                           value="{{ old('budget') }}"
                                           class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl input-range text-gray-700 text-lg @error('budget') border-red-500 @enderror"
                                           placeholder="0"
                                           required>
                                </div>
                                <p class="text-xs text-gray-400 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Budget yang Anda siapkan untuk liburan
                                </p>
                                @error('budget')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jarak Tempuh -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-3">
                                    <i class="fas fa-road text-blue-500 mr-2"></i>
                                    Jarak Tempuh Maksimal
                                </label>
                                <div class="relative group">
                                    <input type="number"
                                           name="jarak"
                                           value="{{ old('jarak') }}"
                                           step="1"
                                           class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl input-range text-gray-700 text-lg @error('jarak') border-red-500 @enderror"
                                           placeholder="0"
                                           required>
                                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">km</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Jarak dari lokasi Anda ke tempat wisata
                                </p>
                                @error('jarak')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Kriteria -->
                        <div class="mt-8 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6">
                            <p class="text-sm font-bold text-gray-700 mb-4 flex items-center">
                                <i class="fas fa-chart-simple text-blue-500 mr-2"></i>
                                Kriteria Penilaian:
                            </p>
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-xs">
                                <div class="bg-white rounded-xl p-3 text-center shadow-sm">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-wallet text-green-600"></i>
                                    </div>
                                    <p class="font-semibold text-gray-800">Budget</p>
                                    <p class="text-gray-400 text-[10px]">Anda input</p>
                                </div>
                                <div class="bg-white rounded-xl p-3 text-center shadow-sm">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-road text-green-600"></i>
                                    </div>
                                    <p class="font-semibold text-gray-800">Jarak</p>
                                    <p class="text-gray-400 text-[10px]">Anda input</p>
                                </div>
                                <div class="bg-white rounded-xl p-3 text-center shadow-sm">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-ticket-alt text-blue-600"></i>
                                    </div>
                                    <p class="font-semibold text-gray-800">Harga Tiket</p>
                                    <p class="text-gray-400 text-[10px]">Data admin</p>
                                </div>
                                <div class="bg-white rounded-xl p-3 text-center shadow-sm">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-building text-yellow-600"></i>
                                    </div>
                                    <p class="font-semibold text-gray-800">Fasilitas</p>
                                    <p class="text-gray-400 text-[10px]">Data admin</p>
                                </div>
                                <div class="bg-white rounded-xl p-3 text-center shadow-sm">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-camera text-purple-600"></i>
                                    </div>
                                    <p class="font-semibold text-gray-800">Keindahan</p>
                                    <p class="text-gray-400 text-[10px]">Data admin</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="mt-8">
                            <button type="submit" class="btn-primary w-full text-white py-4 rounded-2xl font-bold text-lg shadow-xl transition-all">
                                <i class="fas fa-chart-line mr-2"></i>
                                Lihat Rekomendasi Wisata
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Daftar Wisata Tersedia -->
            <div class="mt-20">
                <div class="text-center mb-10">
                    <h3 class="text-3xl font-bold text-white mb-3">Destinasi Wisata</h3>
                    <div class="w-20 h-1 bg-yellow-400 mx-auto rounded-full"></div>
                    <p class="text-purple-100 mt-3">Tersedia {{ $wisatas->count() }} destinasi wisata menarik</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($wisatas as $wisata)
                    <div class="card-wisata bg-white rounded-2xl overflow-hidden shadow-xl">
                        <div class="relative h-48 overflow-hidden">
                            @if($wisata->gambar)
                                <img src="{{ Storage::url($wisata->gambar) }}" alt="{{ $wisata->nama_wisata }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                    <i class="fas fa-mountain text-white text-5xl"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm rounded-full px-2 py-1 text-xs font-semibold text-blue-600">
                                <i class="fas fa-map-marker-alt mr-1"></i> Wisata
                            </div>
                        </div>
                        <div class="p-5">
                            <h4 class="font-bold text-gray-800 text-lg mb-1">{{ $wisata->nama_wisata }}</h4>
                            <p class="text-gray-500 text-sm flex items-center">
                                <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i>
                                {{ $wisata->lokasi }}
                            </p>
                            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex flex-col items-center">
                                    <span class="text-green-600 font-semibold text-sm">
                                        <i class="fas fa-ticket-alt mr-1"></i> Harga
                                    </span>
                                    <span class="text-xs text-gray-500">Rp {{ number_format($wisata->getNilaiKriteria('C2') ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-yellow-600 font-semibold text-sm">
                                        <i class="fas fa-building mr-1"></i> Fasilitas
                                    </span>
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($wisata->getNilaiKriteria('C3') ?? 0) ? 'text-yellow-500' : 'text-gray-300' }} text-xs"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-purple-600 font-semibold text-sm">
                                        <i class="fas fa-camera mr-1"></i> Keindahan
                                    </span>
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($wisata->getNilaiKriteria('C4') ?? 0) ? 'text-yellow-500' : 'text-gray-300' }} text-xs"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white/90 backdrop-blur-md border-t border-gray-200 py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} SPK Wisata - Sistem Pendukung Keputusan Metode SAW
                </p>
                <p class="text-gray-400 text-xs mt-2">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Sistem rekomendasi wisata berbasis multi-kriteria
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
