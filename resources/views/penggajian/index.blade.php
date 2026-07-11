@extends('layouts.app')

@section('title', 'Data Penggajian')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-calculator"></i> Proses Penggajian</h5>
        <a href="{{ route('penggajian.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Buat Penggajian
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Pegawai</th>
                        <th>Golongan</th>
                        <th>Periode</th>
                        <th>Gaji Bersih</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $namaBulan = ['', 'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
                    @endphp
                    @forelse($penggajian as $key => $item)
                    <tr>
                        <td>{{ $penggajian->firstItem() + $key }}</td>
                        <td>{{ $item->pegawai->nama }}</td>
                        <td><span class="badge bg-info">{{ $item->pegawai->golongan->kode }}</span></td>
                        <td>{{ $namaBulan[$item->bulan] }} {{ $item->tahun }}</td>
                        <td>Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($item->status == 'diproses')
                                <span class="badge bg-warning text-dark">Diproses</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('penggajian.show', $item->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </a>
                            <a href="{{ route('penggajian.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('penggajian.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada data penggajian</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $penggajian->links() }}
        </div>
    </div>
</div>
@endsection