@extends('layouts.app')

@section('title', 'History Perhitungan')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-history me-2"></i>History Perhitungan Rekomendasi</h5>
    </div>
    <div class="card-body">
        @if($histories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Preferensi</th>
                            <th>Jumlah Destinasi</th>
                            <th>Rekomendasi Terbaik</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $history)
                        <tr>
                            <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($history->preferensi)
                                    {{ $history->preferensi->nama_sesi }}
                                @else
                                    <span class="text-muted">Tanpa nama</span>
                                @endif
                            </td>
                            <td>{{ count($history->hasil_ranking) }}</td>
                            <td>
                                <strong>{{ $history->hasil_ranking[0]['nama_destinasi'] }}</strong>
                                <span class="badge bg-success">Skor: {{ $history->hasil_ranking[0]['skor_persen'] }}%</span>
                            </td>
                            <td>
                                <a href="{{ route('rekomendasi.detail', $history->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <form action="{{ route('rekomendasi.hapus', $history->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $histories->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                <p>Belum ada history perhitungan</p>
                <a href="{{ route('rekomendasi.index') }}" class="btn btn-primary">Mulai Hitung</a>
            </div>
        @endif
    </div>
</div>
@endsection
