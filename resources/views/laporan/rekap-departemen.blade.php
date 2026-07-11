@extends('layouts.app')

@section('title', 'Rekap per Departemen')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-building"></i> Rekap Gaji per Departemen</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto">
                <select name="bulan" class="form-select">
                    @php $namaBulan = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember']; @endphp
                    @foreach($namaBulan as $val => $label)
                        <option value="{{ $val }}" {{ $bulan == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <input type="number" name="tahun" class="form-control" value="{{ $tahun }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Departemen</th>
                        <th>Jumlah Pegawai</th>
                        <th>Total Gaji</th>
                        <th>Rata-rata Gaji</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekap as $item)
                    <tr>
                        <td>{{ $item->departemen }}</td>
                        <td>{{ $item->jumlah_pegawai }}</td>
                        <td>Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->rata_gaji, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Belum ada data pada periode ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Laporan
        </a>
    </div>
</div>
@endsection