@extends('layouts.app')

@section('title', 'Edit Wisata')
@section('page-title', 'Edit Wisata')
@section('page-description', 'Edit data tempat wisata')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form action="{{ route('admin.wisata.update', $wisata) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kode Wisata -->
            <div>
                <label for="kode_wisata" class="block text-sm font-semibold text-gray-700 mb-2">
                    Kode Wisata <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="kode_wisata"
                       id="kode_wisata"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition @error('kode_wisata') border-red-500 @enderror"
                       value="{{ old('kode_wisata', $wisata->kode_wisata) }}"
                       required>
                @error('kode_wisata')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Wisata -->
            <div>
                <label for="nama_wisata" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Wisata <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="nama_wisata"
                       id="nama_wisata"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition @error('nama_wisata') border-red-500 @enderror"
                       value="{{ old('nama_wisata', $wisata->nama_wisata) }}"
                       required>
                @error('nama_wisata')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lokasi -->
            <div>
                <label for="lokasi" class="block text-sm font-semibold text-gray-700 mb-2">
                    Lokasi <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="lokasi"
                       id="lokasi"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition @error('lokasi') border-red-500 @enderror"
                       value="{{ old('lokasi', $wisata->lokasi) }}"
                       required>
                @error('lokasi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar -->
            <div>
                <label for="gambar" class="block text-sm font-semibold text-gray-700 mb-2">
                    Gambar
                </label>

                @if($wisata->gambar)
                <div class="mb-3">
                    <img src="{{ Storage::url($wisata->gambar) }}"
                         alt="{{ $wisata->nama_wisata }}"
                         class="w-24 h-24 object-cover rounded-lg shadow">
                    <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                </div>
                @endif

                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition cursor-pointer"
                     onclick="document.getElementById('gambar').click()">
                    <div class="space-y-1 text-center">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl"></i>
                        <div class="flex text-sm text-gray-600">
                            <span class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500">
                                Upload file baru
                            </span>
                            <p class="pl-1">untuk mengganti</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
                <input id="gambar" name="gambar" type="file" class="hidden" accept="image/*" onchange="previewImage(event)">
                <div id="imagePreview" class="mt-3 hidden">
                    <img id="preview" class="w-24 h-24 object-cover rounded-lg shadow">
                </div>
                @error('gambar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="md:col-span-2">
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea name="deskripsi"
                          id="deskripsi"
                          rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition resize-none">{{ old('deskripsi', $wisata->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-100">
            <a href="{{ route('admin.wisata.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="btn-premium px-4 py-2 rounded-lg text-white">
                <i class="fas fa-save mr-2"></i>
                Update
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    const preview = document.getElementById('preview');
    const imagePreview = document.getElementById('imagePreview');

    reader.onload = function() {
        preview.src = reader.result;
        imagePreview.classList.remove('hidden');
    }

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>
@endsection
