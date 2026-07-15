@extends('layouts.app')

@section('title', 'Tambah Golongan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Golongan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('golongan.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Golongan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror"
                            id="kode" name="kode" value="{{ old('kode') }}" placeholder="I, II, III, IV">
                        @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_golongan" class="form-label">Nama Golongan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_golongan') is-invalid @enderror"
                            id="nama_golongan" name="nama_golongan" value="{{ old('nama_golongan') }}" 
                            placeholder="Golongan I (Junior Staff)">
                        @error('nama_golongan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="gaji_pokok" class="form-label">Gaji Pokok <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('gaji_pokok') is-invalid @enderror"
                                id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}" 
                                placeholder="3500000" min="0">
                        </div>
                        @error('gaji_pokok')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tunjangan_makan" class="form-label">Tunjangan Makan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('tunjangan_makan') is-invalid @enderror"
                                id="tunjangan_makan" name="tunjangan_makan" value="{{ old('tunjangan_makan', 0) }}" 
                                placeholder="500000" min="0">
                        </div>
                        @error('tunjangan_makan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tunjangan_transport" class="form-label">Tunjangan Transport</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('tunjangan_transport') is-invalid @enderror"
                                id="tunjangan_transport" name="tunjangan_transport" value="{{ old('tunjangan_transport', 0) }}" 
                                placeholder="300000" min="0">
                        </div>
                        @error('tunjangan_transport')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror"
                    id="keterangan" name="keterangan" rows="3" 
                    placeholder="Deskripsi golongan...">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Ringkasan -->
            <div class="alert alert-info">
                <h6><i class="fas fa-calculator"></i> Ringkasan Komponen Gaji</h6>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <small>Gaji Pokok</small><br>
                        <strong id="summary_gaji_pokok">Rp 0</strong>
                    </div>
                    <div class="col-md-4">
                        <small>Total Tunjangan</small><br>
                        <strong id="summary_tunjangan" class="text-success">Rp 0</strong>
                    </div>
                    <div class="col-md-4">
                        <small>Total Gaji</small><br>
                        <strong id="summary_total" class="text-primary">Rp 0</strong>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('golongan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function hitungRingkasan() {
        let gajiPokok = parseInt(document.getElementById('gaji_pokok').value) || 0;
        let tunjanganMakan = parseInt(document.getElementById('tunjangan_makan').value) || 0;
        let tunjanganTransport = parseInt(document.getElementById('tunjangan_transport').value) || 0;

        let totalTunjangan = tunjanganMakan + tunjanganTransport;
        let totalGaji = gajiPokok + totalTunjangan;

        document.getElementById('summary_gaji_pokok').innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(gajiPokok);
        document.getElementById('summary_tunjangan').innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalTunjangan);
        document.getElementById('summary_total').innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalGaji);
    }

    document.getElementById('gaji_pokok').addEventListener('input', hitungRingkasan);
    document.getElementById('tunjangan_makan').addEventListener('input', hitungRingkasan);
    document.getElementById('tunjangan_transport').addEventListener('input', hitungRingkasan);

    // Initial calculation
    hitungRingkasan();
</script>
@endpush