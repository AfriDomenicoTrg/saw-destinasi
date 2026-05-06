@extends('layouts.app')

@section('title', 'Data Wisata')
@section('page-title', 'Data Wisata')
@section('page-description', 'Kelola data tempat wisata')



@section('content')
<a href="{{ route('admin.wisata.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center space-x-2 transition">
    <i class="fas fa-plus"></i>
    <span>Tambah Wisata</span>
</a>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Wisata</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($wisatas as $index => $wisata)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $wisatas->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-semibold">
                            {{ $wisata->kode_wisata }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $wisata->nama_wisata }}</div>
                        @if($wisata->deskripsi)
                            <div class="text-xs text-gray-500 truncate max-w-xs mt-1">{{ Str::limit($wisata->deskripsi, 50) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <i class="fas fa-map-marker-alt text-gray-500 mr-1"></i>
                        {{ $wisata->lokasi }}
                    </td>
                    <td class="px-6 py-4">
                        @if($wisata->gambar)
                            <img src="{{ Storage::url($wisata->gambar) }}"
                                 alt="{{ $wisata->nama_wisata }}"
                                 class="w-10 h-10 object-cover rounded-lg shadow-sm">
                        @else
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-lg"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.wisata.show', $wisata) }}"
                               class="text-blue-600 hover:text-blue-800 transition"
                               title="Detail">
                                <i class="fas fa-eye text-lg"></i>
                            </a>
                            <a href="{{ route('admin.wisata.edit', $wisata) }}"
                               class="text-green-600 hover:text-green-800 transition"
                               title="Edit">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            <button type="button"
                                    onclick="confirmDelete({{ $wisata->id }})"
                                    class="text-red-600 hover:text-red-800 transition"
                                    title="Hapus">
                                <i class="fas fa-trash text-lg"></i>
                            </button>
                        </div>

                        <form id="delete-form-{{ $wisata->id }}"
                              action="{{ route('admin.wisata.destroy', $wisata) }}"
                              method="POST"
                              style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <i class="fas fa-database text-5xl text-gray-300 mb-3 block"></i>
                        <p class="text-gray-500">Belum ada data wisata</p>
                        <a href="{{ route('admin.wisata.create') }}" class="text-blue-600 hover:text-blue-700 text-sm mt-3 inline-block font-medium">
                            <i class="fas fa-plus"></i> Tambah wisata pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($wisatas->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $wisatas->links() }}
    </div>
    @endif
</div>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data wisata ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection
