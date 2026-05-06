<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beri Penilaian - SPK Wisata</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
        }

        .rating-input {
            transition: all 0.2s ease;
        }

        .rating-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102,126,234,0.4);
        }

        .progress-step {
            transition: all 0.3s ease;
        }

        .progress-step.active {
            background: #3b82f6;
            color: white;
            transform: scale(1.1);
        }

        .progress-step.completed {
            background: #10b981;
            color: white;
        }

        .criteria-card {
            transition: all 0.2s ease;
        }

        .criteria-card:hover {
            background: #f8fafc;
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
                <div class="text-sm text-gray-500">
                    <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                    Penilaian Wisata
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="progress-step text-center">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-2 progress-step completed">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <p class="text-sm text-gray-600">Pilih Wisata</p>
                    </div>
                </div>
                <div class="w-16 h-0.5 bg-gray-300"></div>
                <div class="flex-1">
                    <div class="progress-step text-center">
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center mx-auto mb-2 progress-step active">
                            2
                        </div>
                        <p class="text-sm font-semibold text-blue-600">Beri Penilaian</p>
                    </div>
                </div>
                <div class="w-16 h-0.5 bg-gray-300"></div>
                <div class="flex-1">
                    <div class="progress-step text-center">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-2">
                            3
                        </div>
                        <p class="text-sm text-gray-600">Lihat Ranking</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h1 class="text-xl font-bold text-white">Beri Penilaian untuk Setiap Wisata</h1>
                <p class="text-blue-100 text-sm mt-1">Berikan nilai sesuai dengan kriteria yang ada (1-5 atau nilai mentah)</p>
            </div>

            <form action="{{ route('public.result') }}" method="POST">
                @csrf

                <!-- Info Wisata Terpilih -->
                <div class="bg-blue-50 px-6 py-3 border-b border-blue-100">
                    <div class="flex items-center flex-wrap gap-2">
                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                        <span class="text-sm text-gray-700">Wisata yang dibandingkan:</span>
                        @foreach($selectedWisatas as $wisata)
                            <span class="bg-white px-3 py-1 rounded-full text-sm shadow-sm">
                                {{ $wisata->nama_wisata }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Matriks Penilaian -->
                <div class="overflow-x-auto p-4">
                    <table class="w-full min-w-[800px]">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 sticky left-0 bg-gray-100">Wisata / Kriteria</th>
                                @foreach($kriterias as $kriteria)
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">
                                        {{ $kriteria->kode_kriteria }}
                                        <div class="text-gray-500 font-normal text-xs mt-1">{{ $kriteria->nama_kriteria }}</div>
                                        <div class="text-xs {{ $kriteria->tipe == 'benefit' ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $kriteria->tipe == 'benefit' ? '📈 Benefit' : '📉 Cost' }}
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selectedWisatas as $wisata)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="px-4 py-3 font-semibold text-gray-800 sticky left-0 bg-white border-r">
                                    <div>{{ $wisata->nama_wisata }}</div>
                                    <div class="text-xs text-gray-500">{{ $wisata->lokasi }}</div>
                                    <input type="hidden" name="wisata_ids[]" value="{{ $wisata->id }}">
                                </td>

                                @foreach($kriterias as $kriteria)
                                    @php
                                        $fieldName = "nilai[{$wisata->id}][{$kriteria->id}]";
                                        $placeholder = '';
                                        $step = 'any';

                                        if ($kriteria->nama_kriteria == 'Jarak Tempuh') {
                                            $placeholder = 'Jarak (km)';
                                            $step = '1';
                                        } elseif ($kriteria->nama_kriteria == 'Harga Tiket') {
                                            $placeholder = 'Harga (Rp)';
                                            $step = '1000';
                                        } else {
                                            $placeholder = 'Skala 1-5';
                                            $step = '1';
                                        }
                                    @endphp
                                    <td class="px-4 py-3 text-center">
                                        <div class="inline-flex flex-col items-center">
                                            @if(in_array($kriteria->nama_kriteria, ['Fasilitas', 'Keindahan', 'Keamanan']))
                                                <div class="flex items-center space-x-1 mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <button type="button" class="rating-star text-2xl text-gray-300 hover:text-yellow-500 transition" data-wisata="{{ $wisata->id }}" data-kriteria="{{ $kriteria->id }}" data-value="{{ $i }}">
                                                            <i class="far fa-star"></i>
                                                        </button>
                                                    @endfor
                                                </div>
                                                <input type="hidden"
                                                       name="{{ $fieldName }}"
                                                       id="rating_{{ $wisata->id }}_{{ $kriteria->id }}"
                                                       class="rating-input-hidden"
                                                       value="{{ old($fieldName, 3) }}">
                                            @else
                                                <input type="number"
                                                       name="{{ $fieldName }}"
                                                       class="rating-input w-28 px-3 py-2 border border-gray-300 rounded-lg text-center text-sm"
                                                       placeholder="{{ $placeholder }}"
                                                       step="{{ $step }}"
                                                       value="{{ old($fieldName, '') }}">
                                            @endif
                                            <div class="text-xs text-gray-400 mt-1">
                                                @if($kriteria->nama_kriteria == 'Jarak Tempuh')
                                                    km
                                                @elseif($kriteria->nama_kriteria == 'Harga Tiket')
                                                    Rp
                                                @else
                                                    1-5
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Aksi -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
                    <a href="{{ route('public.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali Pilih Wisata
                    </a>
                    <button type="submit" class="btn-primary text-white px-8 py-2 rounded-lg font-semibold shadow-lg">
                        <i class="fas fa-calculator mr-2"></i>
                        Hitung & Lihat Ranking
                    </button>
                </div>
            </form>
        </div>

        <!-- Informasi Panduan -->
        <div class="mt-8 bg-blue-50 rounded-xl p-4">
            <div class="flex items-start space-x-3">
                <i class="fas fa-lightbulb text-yellow-500 text-xl mt-0.5"></i>
                <div class="text-sm text-gray-700">
                    <p class="font-semibold mb-1">Panduan Penilaian:</p>
                    <ul class="list-disc list-inside space-y-1 text-gray-600">
                        <li><span class="font-medium text-green-600">Benefit:</span> Semakin besar nilai, semakin baik (Fasilitas, Keindahan, Keamanan)</li>
                        <li><span class="font-medium text-red-600">Cost:</span> Semakin kecil nilai, semakin baik (Jarak Tempuh, Harga Tiket)</li>
                        <li>Isi nilai sesuai dengan kondisi wisata yang Anda ketahui</li>
                        <li>Untuk Fasilitas, Keindahan, Keamanan: beri nilai 1-5 (5 = terbaik)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Star rating functionality
        document.querySelectorAll('.rating-star').forEach(star => {
            star.addEventListener('click', function() {
                const wisataId = this.dataset.wisata;
                const kriteriaId = this.dataset.kriteria;
                const value = parseInt(this.dataset.value);
                const container = this.parentElement;
                const stars = container.querySelectorAll('.rating-star');
                const hiddenInput = document.getElementById(`rating_${wisataId}_${kriteriaId}`);

                // Update stars visual
                stars.forEach((star, index) => {
                    if (index < value) {
                        star.innerHTML = '<i class="fas fa-star"></i>';
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-500');
                    } else {
                        star.innerHTML = '<i class="far fa-star"></i>';
                        star.classList.remove('text-yellow-500');
                        star.classList.add('text-gray-300');
                    }
                });

                // Update hidden input value
                if (hiddenInput) {
                    hiddenInput.value = value;
                }
            });
        });

        // Initialize default star values
        document.querySelectorAll('.rating-star').forEach(star => {
            const wisataId = star.dataset.wisata;
            const kriteriaId = star.dataset.kriteria;
            const hiddenInput = document.getElementById(`rating_${wisataId}_${kriteriaId}`);

            if (hiddenInput && hiddenInput.value) {
                const defaultValue = parseInt(hiddenInput.value);
                const container = star.parentElement;
                const stars = container.querySelectorAll('.rating-star');

                stars.forEach((s, idx) => {
                    if (idx < defaultValue) {
                        s.innerHTML = '<i class="fas fa-star"></i>';
                        s.classList.add('text-yellow-500');
                        s.classList.remove('text-gray-300');
                    }
                });
            }
        });
    </script>
</body>
</html>
