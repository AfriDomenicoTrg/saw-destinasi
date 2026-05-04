@extends('layouts.app')

@section('title', 'Rekomendasi Wisata Sumatera Utara')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-chart-line me-2"></i>Sistem Pendukung Keputusan Pemilihan Destinasi Wisata</h4>
                <small>Metode SAW (Simple Additive Weighting)</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('rekomendasi.hitung') }}" id="formRekomendasi">
                    @csrf

                    <!-- Step 1: Pilih Destinasi -->
                    <div class="mb-4">
                        <h5><i class="fas fa-map-marker-alt text-primary me-2"></i>1. Pilih Destinasi Wisata (Minimal 2)</h5>
                        <div class="row mt-3" id="destinasi-list">
                            @foreach($destinasi as $d)
                            <div class="col-md-3 col-sm-4 col-6 mb-3">
                                <div class="card destinasi-card h-100 @if(in_array($d->id, $lastDestinasi)) selected @endif"
                                     data-id="{{ $d->id }}">
                                    @if($d->gambar)
                                        <img src="{{ asset('storage/'.$d->gambar) }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="{{ $d->nama_destinasi }}">
                                    @else
                                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <i class="fas fa-image fa-3x text-white"></i>
                                        </div>
                                    @endif
                                    <div class="card-body text-center">
                                        <h6 class="card-title">{{ $d->nama_destinasi }}</h6>
                                        <small class="text-muted">{{ $d->lokasi }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="destinasi_ids" id="destinasi_ids" value="{{ json_encode($lastDestinasi) }}">
                        <div id="destinasi-warning" class="text-danger mt-2" style="display: none;">Pilih minimal 2 destinasi!</div>
                    </div>

                    <hr>

                    <!-- Step 2: Atur Bobot Kriteria -->
                    <div class="mb-4">
                        <h5><i class="fas fa-sliders-h text-primary me-2"></i>2. Atur Bobot Preferensi Anda</h5>
                        <p class="text-muted">Geser slider sesuai preferensi Anda (total bobot harus 100%)</p>

                        <div class="row" id="bobot-container">
                            @foreach($kriteria as $index => $k)
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">{{ $k->nama_kriteria }}</label>
                                @if($k->satuan)
                                    <small class="text-muted"> ({{ $k->satuan }})</small>
                                @endif
                                <small class="text-{{ $k->atribut == 'benefit' ? 'success' : 'danger' }}">
                                    ({{ $k->atribut == 'benefit' ? 'semakin tinggi semakin baik' : 'semakin rendah semakin baik' }})
                                </small>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="text-muted">0%</span>
                                    <input type="range" class="form-range flex-grow-1 bobot-slider"
                                           name="bobot[{{ $index }}]"
                                           data-index="{{ $index }}"
                                           value="{{ $lastBobot[$index] ?? 0 }}"
                                           min="0" max="100" step="1">
                                    <span class="slider-value" id="bobot-value-{{ $index }}">{{ $lastBobot[$index] ?? 0 }}%</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-3 p-3 bg-light rounded">
                            <strong>Total Bobot: <span id="total-bobot" class="text-primary fs-4">0</span>%</strong>
                            <div id="bobot-warning" class="text-danger mt-1" style="display: none;">Total bobot harus 100%!</div>
                        </div>
                    </div>

                    <hr>

                    <!-- Step 3: Opsi Tambahan -->
                    <div class="mb-4">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="simpanPreferensi" name="simpan_preferensi" value="1">
                            <label class="form-check-label" for="simpanPreferensi">
                                <i class="fas fa-save"></i> Simpan preferensi ini untuk digunakan lagi
                            </label>
                        </div>
                        <div id="preferensiNameGroup" style="display: none;">
                            <label class="form-label">Nama Preferensi</label>
                            <input type="text" class="form-control" name="nama_preferensi" placeholder="Contoh: Liburan hemat, Wisata keluarga, ...">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-calculator me-2"></i>Hitung Rekomendasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hasil Rekomendasi -->
        @if(session('hasil'))
        <div class="card shadow mt-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Hasil Rekomendasi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach(session('hasil') as $item)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 card-hover">
                            <div class="position-relative">
                                @if($item['gambar'])
                                    <img src="{{ asset('storage/'.$item['gambar']) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $item['nama_destinasi'] }}">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-image fa-4x text-white"></i>
                                    </div>
                                @endif
                                <span class="position-absolute top-0 start-0 badge bg-{{ $item['peringkat'] == 1 ? 'warning' : 'secondary' }} m-2 fs-6">
                                    <i class="fas fa-star"></i> Peringkat #{{ $item['peringkat'] }}
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $item['nama_destinasi'] }}</h5>
                                <p class="card-text text-muted small">{{ $item['lokasi'] }}</p>
                                <p class="card-text">{{ Str::limit($item['deskripsi'], 100) }}</p>
                                <div class="text-center mt-3">
                                    <span class="badge bg-success fs-6 p-2">
                                        Skor: {{ $item['skor_persen'] }}%
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <button type="button" class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="collapse" data-bs-target="#detail-{{ $loop->index }}">
                                    <i class="fas fa-chart-bar"></i> Lihat Detail Perhitungan
                                </button>
                                <div class="collapse mt-3" id="detail-{{ $loop->index }}">
                                    <div class="card card-body bg-light">
                                        <table class="table table-sm">
                                            <thead>
                                                <table>
                                                    <th>Kriteria</th>
                                                    <th>Nilai</th>
                                                    <th>Normalisasi</th>
                                                    <th>Preferensi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($item['detail_nilai'] as $detail)
                                                <tr>
                                                    <td>{{ $detail['kriteria'] }} ({{ $detail['atribut'] }})</td>
                                                    <td>{{ $detail['nilai_mentah'] }}</td>
                                                    <td>{{ number_format($detail['normalisasi'], 4) }}</td>
                                                    <td>{{ number_format($detail['preferensi'], 4) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <hr>
                                        <strong>Total Skor: {{ number_format($item['skor'], 4) }} ({{ $item['skor_persen'] }}%)</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Seleksi destinasi
    let selectedDestinasi = $('#destinasi_ids').val() ? JSON.parse($('#destinasi_ids').val()) : [];

    $('.destinasi-card').click(function() {
        let id = $(this).data('id');
        let index = selectedDestinasi.indexOf(id);

        if (index === -1) {
            if (selectedDestinasi.length < 10) {
                selectedDestinasi.push(id);
                $(this).addClass('selected');
            } else {
                alert('Maksimal pilih 10 destinasi');
            }
        } else {
            selectedDestinasi.splice(index, 1);
            $(this).removeClass('selected');
        }

        $('#destinasi_ids').val(JSON.stringify(selectedDestinasi));
        validateForm();
    });

    // Slider bobot
    function updateBobot() {
        let total = 0;
        $('.bobot-slider').each(function() {
            let val = parseInt($(this).val());
            let index = $(this).data('index');
            $('#bobot-value-' + index).text(val + '%');
            total += val;
        });
        $('#total-bobot').text(total);

        if (total === 100) {
            $('#bobot-warning').hide();
        } else {
            $('#bobot-warning').show();
        }

        validateForm();
    }

    $('.bobot-slider').on('input', updateBobot);
    updateBobot();

    // Simpan preferensi checkbox
    $('#simpanPreferensi').change(function() {
        if ($(this).is(':checked')) {
            $('#preferensiNameGroup').show();
        } else {
            $('#preferensiNameGroup').hide();
        }
    });

    function validateForm() {
        let isValid = true;

        if (selectedDestinasi.length < 2) {
            $('#destinasi-warning').show();
            isValid = false;
        } else {
            $('#destinasi-warning').hide();
        }

        if (parseInt($('#total-bobot').text()) !== 100) {
            isValid = false;
        }

        if (isValid && $('#simpanPreferensi').is(':checked')) {
            let namaPreferensi = $('input[name="nama_preferensi"]').val();
            if (!namaPreferensi) {
                isValid = false;
            }
        }

        return isValid;
    }

    $('#formRekomendasi').submit(function(e) {
        if (!validateForm()) {
            e.preventDefault();
            alert('Mohon lengkapi: pilih minimal 2 destinasi dan total bobot harus 100%');
        }
    });
});
</script>
@endpush
