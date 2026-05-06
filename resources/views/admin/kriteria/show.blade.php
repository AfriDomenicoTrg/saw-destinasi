@extends('layouts.app')

@section('title', 'Detail Kriteria')
@section('page-title', 'Detail Kriteria')
@section('page-description', 'Informasi lengkap kriteria')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informasi Kriteria -->
        <div class="space-y-4">
            <div class="pb-3 border-b border-gray-100">
                <label class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Kode Kriteria</label>
                <p class="text-xl font-bold text-gray-800 mt-1">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm">
                        {{ $kriteria->kode_kriteria }}
                    </span>
                </p>
            </div>

            <div class="pb-3 border-b border-gray-100">
                <label class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Nama Kriteria</label>
                <p class="text-xl font-semibold text-gray-800 mt-1">{{ $kriteria->nama_kriteria }}</p>
            </div>

            <div class="pb-3 border-b border-gray-100">
                <label class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Tipe Kriteria</label>
                <p class="mt-1">
                    @if($kriteria->tipe == 'benefit')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-sm font-semibold">
                            <i class="fas fa-arrow-up mr-1"></i> Benefit
                        </span>
                        <p class="text-xs text-gray-500 mt-2">Semakin besar nilai, semakin baik</p>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-sm font-semibold">
                            <i class="fas fa-arrow-down mr-1"></i> Cost
                        </span>
                        <p class="text-xs text-gray-500 mt-2">Semakin kecil nilai, semakin baik</p>
                    @endif
                </p>
            </div>

            <div class="pb-3 border-b border-gray-100">
                <label class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Bobot</label>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ ($kriteria->bobot * 100) }}%</p>
                <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 rounded-full h-2" style="width: {{ $kriteria->bobot * 100 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="bg-gray-50 rounded-xl p-6">
            <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                Informasi Tambahan
            </h3>
            <div class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Dibuat Pada</label>
                    <p class="text-gray-700 mt-1">
                        <i class="far fa-calendar-alt text-gray-400 mr-1"></i>
                        {{ $kriteria->created_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}
                    </p>
                </div>
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Terakhir Diupdate</label>
                    <p class="text-gray-700 mt-1">
                        <i class="far fa-clock text-gray-400 mr-1"></i>
                        {{ $kriteria->updated_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}
                    </p>
                </div>
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold">Status</label>
                    <p class="mt-1">
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs">
                            <i class="fas fa-check-circle mr-1"></i> Aktif
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
        <a href="{{ route('admin.kriteria.index') }}"
           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
        <a href="{{ route('admin.kriteria.edit', $kriteria) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition shadow-sm">
            <i class="fas fa-edit mr-2"></i>
            Edit Kriteria
        </a>
    </div>
</div>
@endsection
