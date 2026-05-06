@extends('layouts.app')

@section('title', 'Detail Wisata')
@section('page-title', 'Detail Wisata')
@section('page-description', 'Informasi lengkap tempat wisata')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Image Section -->
        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-center">
            @if($wisata->gambar)
                <img src="{{ Storage::url($wisata->gambar) }}"
                     alt="{{ $wisata->nama_wisata }}"
                     class="w-full h-80 object-cover rounded-lg shadow">
            @else
                <div class="w-full h-80 bg-gray-200 rounded-lg flex flex-col items-center justify-center">
                    <i class="fas fa-image text-gray-400 text-5xl mb-2"></i>
                    <p class="text-gray-400">Tidak ada gambar</p>
                </div>
            @endif
        </div>

        <!-- Info Section -->
        <div class="space-y-4">
            <div class="pb-3 border-b border-gray-100">
                <label class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Kode Wisata</label>
                <p class="text-xl font-bold text-gray-800 mt-1">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm">
                        {{ $wisata->kode_wisata }}
                    </span>
                </p>
            </div>

            <div class="pb-3 border-b border-gray-100">
                <label class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Nama Wisata</label>
                <p class="text-xl font-semibold text-gray-800 mt-1">{{ $wisata->nama_wisata }}</p>
            </div>

            <div class="pb-3 border-b border-gray-100">
                <label class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Lokasi</label>
                <p class="text-gray-700 mt-1">
                    <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                    {{ $wisata->lokasi }}
                </p>
            </div>

            <div class="pb-3 border-b border-gray-100">
                <label class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Deskripsi</label>
                <p class="text-gray-600 text-justify mt-1 leading-relaxed">
                    {{ $wisata->deskripsi ?: '-' }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Dibuat Pada</label>
                    <p class="text-sm text-gray-700 mt-1">
                        <i class="far fa-calendar-alt text-gray-400 mr-1"></i>
                        {{ $wisata->created_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i')}}
                    </p>
                </div>
                <div>
                    <label class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Terakhir Update</label>
                    <p class="text-sm text-gray-700 mt-1">
                        <i class="far fa-clock text-gray-400 mr-1"></i>
                       {{ $wisata->updated_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-100">
        <a href="{{ route('admin.wisata.index') }}"
           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
        <a href="{{ route('admin.wisata.edit', $wisata) }}"
           class="btn-premium px-4 py-2 rounded-lg text-white">
            <i class="fas fa-edit mr-2"></i>
            Edit Wisata
        </a>
    </div>
</div>
@endsection
