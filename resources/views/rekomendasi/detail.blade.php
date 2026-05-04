@extends('layouts.app')

@section('title', 'Detail Perhitungan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Detail Perhitungan</h5>
                <small>{{ $history->created_at->format('d/m/Y H:i:s') }}</small>
            </div>
            <div class="card-body">
                @if($history->preferensi)
                    <div class="alert alert-info">
                        <strong><i class="fas fa-tag"></i> Preferensi:</strong> {{ $history->preferensi->nama_sesi }}
                    </div>
                @endif

                <div class="row">
                    @foreach($history->hasil_ranking as $item)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="position-relative">
                                @if($item['gambar'])
                                    <img src="{{ asset('storage/'.$item['gambar']) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-image fa-4x text-white"></i>
                                    </div>
                                @endif
                                <span class="position-absolute top-0 start-0 badge bg-{{ $item['peringkat'] == 1 ? 'warning' : 'secondary' }} m-2">
                                    Peringkat #{{ $item['peringkat'] }}
                                </span>
                            </div>
                            <div class="card-body">
                                <h5>{{ $item['nama_destinasi'] }}</h5>
                                <p class="text-muted">{{ $item['lokasi'] }}</p>
                                <div class="text-center">
                                    <span class="badge bg-success fs-6 p-2">Skor: {{ $item['skor_persen'] }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('rekomendasi.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Hitung Ulang
                    </a>
                    <a href="{{ route('rekomendasi.history') }}" class="btn btn-secondary">
                        <i class="fas fa-history"></i> Kembali ke History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
