@extends('layouts.app')

@section('title', 'Buat Penggajian')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-calculator"></i> Buat Penggajian Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('penggajian.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Pegawai <span class="text-danger">*</span></label>
                        <select class="form-select @error('pegawai_id') is-invalid @enderror" name="pegawai_id" id="pegawai_id">
                            <option value="">Pilih Pegawai</option>
                            @foreach($pegawai as $item)
                                <option value="{{ $item->id }}"
                                    data-gaji-pokok="{{ $item->golongan->gaji_pokok }}"
                                    data-tunjangan-makan="{{ $item->golongan->tunjangan_makan }}"
                                    data-tunjangan-transport="{{ $item->golongan->tunjangan_transport }}"
                                    {{ old('pegawai_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nip }} - {{ $item->nama }} ({{ $item->golongan->kode }})
                                </option>
                            @endforeach
                        </select>
                        @error('pegawai_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Bulan <span class="text-danger">*</span></label>
                        <select class="form-select @error('bulan') is-invalid @enderror" name="bulan">
                            @php $namaBulan = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember']; @endphp
                            @foreach($namaBulan as $val => $label)
                                <option value="{{ $val }}" {{ old('bulan') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('bulan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('tahun') is-invalid @enderror" name="tahun" value="{{ old('tahun', date('Y')) }}">
                        @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Preview komponen gaji dari golongan -->
            <div class="alert alert-light border">
                <h6><i class="fas fa-info-circle"></i> Komponen Gaji Otomatis (dari Golongan)</h6>
                <div class="row">
                    <div class="col-md-4">Gaji Pokok: <strong id="preview-pokok">Rp 0</strong></div>
                    <div class="col-md-4">Tunjangan Makan: <strong id="preview-makan">Rp 0</strong></div>
                    <div class="col-md-4">Tunjangan Transport: <strong id="preview-transport">Rp 0</strong></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tunjangan Lainnya</label>
                        <input type="number" class="form-control" name="tunjangan_lainnya" value="{{ old('tunjangan_lainnya', 0) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Potongan Absensi</label>
                        <input type="number" class="form-control" name="potongan_absensi" value="{{ old('potongan_absensi', 0) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Potongan Lainnya</label>
                        <input type="number" class="form-control" name="potongan_lainnya" value="{{ old('potongan_lainnya', 0) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status">
                            <option value="draft">Draft</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Gaji <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_gaji') is-invalid @enderror" name="tanggal_gaji" value="{{ old('tanggal_gaji', date('Y-m-d')) }}">
                        @error('tanggal_gaji')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Proses Penggajian
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('pegawai_id').addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        const format = (n) => 'Rp ' + Number(n || 0).toLocaleString('id-ID');
        document.getElementById('preview-pokok').innerText = format(opt.dataset.gajiPokok);
        document.getElementById('preview-makan').innerText = format(opt.dataset.tunjanganMakan);
        document.getElementById('preview-transport').innerText = format(opt.dataset.tunjanganTransport);
    });
</script>
@endpush
@endsection