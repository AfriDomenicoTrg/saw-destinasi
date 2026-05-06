@extends('layouts.app')

@section('title', 'Tambah Kriteria')
@section('page-title', 'Tambah Kriteria')
@section('page-description', 'Tambah kriteria baru untuk perhitungan SAW')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <form action="{{ route('admin.kriteria.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kode Kriteria -->
            <div>
                <label for="kode_kriteria" class="block text-sm font-semibold text-gray-800 mb-2">
                    Kode Kriteria <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="kode_kriteria"
                       id="kode_kriteria"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-gray-900 uppercase @error('kode_kriteria') border-red-500 @enderror"
                       value="{{ old('kode_kriteria') }}"
                       placeholder="Contoh: C1, C2, C3"
                       required>
                <p class="text-xs text-gray-500 mt-1">Contoh: C1, C2, C3, dst</p>
                @error('kode_kriteria')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Kriteria -->
            <div>
                <label for="nama_kriteria" class="block text-sm font-semibold text-gray-800 mb-2">
                    Nama Kriteria <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="nama_kriteria"
                       id="nama_kriteria"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-gray-900 @error('nama_kriteria') border-red-500 @enderror"
                       value="{{ old('nama_kriteria') }}"
                       placeholder="Contoh: Harga Tiket, Jarak Tempuh"
                       required>
                @error('nama_kriteria')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipe Kriteria -->
            <div>
                <label for="tipe" class="block text-sm font-semibold text-gray-800 mb-2">
                    Tipe Kriteria <span class="text-red-500">*</span>
                </label>
                <select name="tipe"
                        id="tipe"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition @error('tipe') border-red-500 @enderror"
                        required>
                    <option value="">Pilih Tipe</option>
                    <option value="benefit" {{ old('tipe') == 'benefit' ? 'selected' : '' }}>
                        <i class="fas fa-arrow-up"></i> Benefit (Semakin besar semakin baik)
                    </option>
                    <option value="cost" {{ old('tipe') == 'cost' ? 'selected' : '' }}>
                        <i class="fas fa-arrow-down"></i> Cost (Semakin kecil semakin baik)
                    </option>
                </select>
                <p class="text-xs text-gray-500 mt-1">
                    <span class="text-green-600">Benefit:</span> Nilai besar = lebih baik (contoh: fasilitas, keindahan)<br>
                    <span class="text-red-600">Cost:</span> Nilai kecil = lebih baik (contoh: harga, jarak)
                </p>
                @error('tipe')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bobot -->
            <div>
                <label for="bobot" class="block text-sm font-semibold text-gray-800 mb-2">
                    Bobot (%) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="number"
                           name="bobot"
                           id="bobot"
                           step="0.01"
                           min="0"
                           max="1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-gray-900 @error('bobot') border-red-500 @enderror"
                           value="{{ old('bobot') }}"
                           placeholder="0.25"
                           required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">× 100 = <span id="bobotPersen">0</span>%</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">Masukkan bobot dalam desimal (contoh: 0.25 = 25%)</p>
                @error('bobot')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Info Total Bobot -->
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-info-circle text-blue-600"></i>
                    <span class="text-sm text-gray-700">Total bobot saat ini:</span>
                </div>
                <span class="font-bold text-blue-700" id="totalBobotDisplay">0%</span>
            </div>
            <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                <div id="totalBobotBar" class="bg-blue-600 rounded-full h-2" style="width: 0%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Total bobot semua kriteria harus 100% (1.00)</p>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.kriteria.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition shadow-sm">
                <i class="fas fa-save mr-2"></i>
                Simpan
            </button>
        </div>
    </form>
</div>

<script>
    // Hitung bobot persen
    const bobotInput = document.getElementById('bobot');
    const bobotPersen = document.getElementById('bobotPersen');

    bobotInput.addEventListener('input', function() {
        let value = parseFloat(this.value) || 0;
        bobotPersen.textContent = (value * 100).toFixed(0);
    });

    // Trigger initial calculation
    bobotInput.dispatchEvent(new Event('input'));

    // Calculate total bobot (if needed)
    async function fetchTotalBobot() {
        try {
            const response = await fetch('{{ route("admin.kriteria.total-bobot") }}');
            const data = await response.json();
            const totalPersen = (data.total * 100).toFixed(0);
            document.getElementById('totalBobotDisplay').textContent = totalPersen + '%';
            document.getElementById('totalBobotBar').style.width = data.total * 100 + '%';

            if (data.total > 1) {
                document.getElementById('totalBobotDisplay').classList.add('text-red-600');
            } else if (data.total < 0.99) {
                document.getElementById('totalBobotDisplay').classList.add('text-yellow-600');
            } else {
                document.getElementById('totalBobotDisplay').classList.add('text-green-600');
            }
        } catch (error) {
            console.log('Error fetching total bobot');
        }
    }

    // Call on page load
    fetchTotalBobot();
</script>
@endsection
