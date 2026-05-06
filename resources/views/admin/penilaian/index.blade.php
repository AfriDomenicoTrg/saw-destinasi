@extends('layouts.app')

@section('title', 'Penilaian Wisata')
@section('page-title', 'Penilaian Kriteria Wisata')
@section('page-description', 'Input nilai untuk kriteria Fasilitas, Keindahan, dan Harga Tiket')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
        <div class="flex items-center space-x-3">
            <i class="fas fa-info-circle text-blue-600 text-xl"></i>
            <div>
                <p class="text-sm text-gray-700">
                    <span class="font-semibold">Petunjuk:</span> Isi nilai untuk setiap wisata pada kriteria berikut:
                </p>
                <ul class="text-xs text-gray-600 mt-1 flex flex-wrap gap-3">
                    <li><span class="text-green-600 font-semibold">C3 (Fasilitas):</span> Skala 1-5 (1=Sangat Kurang, 5=Sangat Baik)</li>
                    <li><span class="text-green-600 font-semibold">C4 (Keindahan):</span> Skala 1-5 (1=Tidak Indah, 5=Sangat Indah)</li>
                    <li><span class="text-red-600 font-semibold">C5 (Harga Tiket):</span> Nominal dalam Rupiah (Rp)</li>
                </ul>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.penilaian.store') }}" method="POST">
        @csrf

        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 w-40">Wisata</th>
                        @foreach($kriterias as $kriteria)
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">
                                {{ $kriteria->kode_kriteria }}
                                <div class="text-xs text-gray-500 font-normal mt-1">{{ $kriteria->nama_kriteria }}</div>
                                <div class="text-xs {{ $kriteria->tipe == 'benefit' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $kriteria->tipe == 'benefit' ? '📈 Benefit' : '📉 Cost' }}
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($wisatas as $wisata)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">{{ $wisata->nama_wisata }}</div>
                            <div class="text-xs text-gray-500">{{ $wisata->kode_wisata }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $wisata->lokasi }}</div>
                        </td>

                        @foreach($kriterias as $kriteria)
                            @php
                                $key = $wisata->id . '_' . $kriteria->id;
                                $nilai = $penilaians[$key]->nilai ?? '';

                                // Set placeholder dan step berdasarkan kriteria
                                if ($kriteria->kode_kriteria == 'C5') {
                                    $placeholder = 'Rp 0';
                                    $step = '1000';
                                    $type = 'number';
                                    $min = '0';
                                } else {
                                    $placeholder = 'Skala 1-5';
                                    $step = '1';
                                    $type = 'number';
                                    $min = '1';
                                    $max = '5';
                                }
                            @endphp
                            <td class="px-4 py-3 text-center">
                                @if($kriteria->kode_kriteria == 'C5')
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-gray-400 text-sm">Rp</span>
                                        <input type="{{ $type }}"
                                               name="penilaian[{{ $wisata->id }}][{{ $kriteria->id }}]"
                                               value="{{ old('penilaian.' . $wisata->id . '.' . $kriteria->id, $nilai) }}"
                                               class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-center"
                                               step="{{ $step }}"
                                               min="{{ $min }}"
                                               placeholder="{{ $placeholder }}">
                                    </div>
                                @else
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center space-x-1 mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button"
                                                        class="rating-star text-2xl transition hover:scale-110
                                                               {{ $nilai >= $i ? 'text-yellow-500' : 'text-gray-300' }}"
                                                        data-wisata="{{ $wisata->id }}"
                                                        data-kriteria="{{ $kriteria->id }}"
                                                        data-value="{{ $i }}">
                                                    <i class="{{ $nilai >= $i ? 'fas fa-star' : 'far fa-star' }}"></i>
                                                </button>
                                            @endfor
                                        </div>
                                        <input type="hidden"
                                               name="penilaian[{{ $wisata->id }}][{{ $kriteria->id }}]"
                                               id="rating_{{ $wisata->id }}_{{ $kriteria->id }}"
                                               class="rating-input-hidden"
                                               value="{{ $nilai ?: 3 }}">
                                        <span class="text-xs text-gray-400 mt-1">Klik bintang untuk memberi nilai</span>
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-between items-center">
            <div class="text-sm text-gray-500">
                <i class="fas fa-database mr-1"></i>
                Total Wisata: {{ $wisatas->count() }} | Kriteria yang dinilai: {{ $kriterias->count() }}
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition shadow-sm">
                <i class="fas fa-save mr-2"></i>
                Simpan Semua Penilaian
            </button>
        </div>
    </form>
</div>

@push('scripts')
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
            stars.forEach((s, index) => {
                const starValue = parseInt(s.dataset.value);
                if (starValue <= value) {
                    s.innerHTML = '<i class="fas fa-star"></i>';
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-500');
                } else {
                    s.innerHTML = '<i class="far fa-star"></i>';
                    s.classList.remove('text-yellow-500');
                    s.classList.add('text-gray-300');
                }
            });

            // Update hidden input value
            if (hiddenInput) {
                hiddenInput.value = value;
            }
        });
    });

    // Initialize tooltip or additional features
    document.addEventListener('DOMContentLoaded', function() {
        // Auto format untuk harga tiket (C5)
        document.querySelectorAll('input[placeholder*="Rp"]').forEach(input => {
            input.addEventListener('blur', function() {
                let value = parseInt(this.value);
                if (!isNaN(value) && value > 0) {
                    this.value = value;
                }
            });
        });
    });
</script>
@endpush
@endsection
