@extends('layouts.app')

@section('title', 'Data Kriteria')
@section('page-title', 'Data Kriteria')
@section('page-description', 'Kelola kriteria dan bobot untuk perhitungan SAW')



@section('content')
<a href="{{ route('admin.kriteria.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center space-x-2 transition">
    <i class="fas fa-plus"></i>
    <span>Tambah Kriteria</span>
</a>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Info Bobot -->
    <div class="px-6 py-4 bg-blue-50 border-b border-blue-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-chart-pie text-blue-600 text-xl"></i>
                <div>
                    <p class="text-sm text-gray-600">Total Bobot Keseluruhan</p>
                    <p class="text-2xl font-bold text-blue-700">{{ ($totalBobot * 100) }}%</p>
                </div>
            </div>
            @if($totalBobot > 1)
                <div class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm">
                    <i class="fas fa-warning mr-1"></i> Total bobot melebihi 100%
                </div>
            @elseif($totalBobot < 0.99)
                <div class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm">
                    <i class="fas fa-info-circle mr-1"></i> Total bobot kurang dari 100%
                </div>
            @else
                <div class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm">
                    <i class="fas fa-check-circle mr-1"></i> Total bobot: 100% (Valid)
                </div>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Kriteria</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Bobot</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($kriterias as $index => $kriteria)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $kriterias->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-semibold">
                            {{ $kriteria->kode_kriteria }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $kriteria->nama_kriteria }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($kriteria->tipe == 'benefit')
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                <i class="fas fa-arrow-up mr-1"></i> Benefit
                            </span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
                                <i class="fas fa-arrow-down mr-1"></i> Cost
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 rounded-full h-2" style="width: {{ $kriteria->bobot * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 min-w-[45px]">{{ ($kriteria->bobot * 100) }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.kriteria.show', $kriteria) }}"
                               class="text-blue-600 hover:text-blue-800 transition"
                               title="Detail">
                                <i class="fas fa-eye text-lg"></i>
                            </a>
                            <a href="{{ route('admin.kriteria.edit', $kriteria) }}"
                               class="text-green-600 hover:text-green-800 transition"
                               title="Edit">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            <button type="button"
                                    onclick="confirmDelete({{ $kriteria->id }})"
                                    class="text-red-600 hover:text-red-800 transition"
                                    title="Hapus">
                                <i class="fas fa-trash text-lg"></i>
                            </button>
                        </div>

                        <form id="delete-form-{{ $kriteria->id }}"
                              action="{{ route('admin.kriteria.destroy', $kriteria) }}"
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
                        <i class="fas fa-chart-line text-5xl text-gray-300 mb-3 block"></i>
                        <p class="text-gray-500">Belum ada data kriteria</p>
                        <a href="{{ route('admin.kriteria.create') }}" class="text-blue-600 hover:text-blue-700 text-sm mt-3 inline-block font-medium">
                            <i class="fas fa-plus"></i> Tambah kriteria pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kriterias->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $kriterias->links() }}
    </div>
    @endif
</div>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data kriteria ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection
