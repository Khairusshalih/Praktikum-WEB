@extends('layouts.app')

@section('title', 'Data Golongan')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-layer-group"></i> Data Golongan</h5>
        <a href="{{ route('golongan.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Tambah Golongan
        </a>
    </div>
    <div class="card-body">
        <!-- Search Form -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ route('golongan.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2"
                        placeholder="Cari kode atau nama golongan..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <span class="text-muted">
                    <i class="fas fa-database"></i> Total: {{ $golongan->total() }} data
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Kode</th>
                        <th>Nama Golongan</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan Makan</th>
                        <th>Tunjangan Transport</th>
                        <th>Total Tunjangan</th>
                        <th>Total Gaji</th>
                        <th>Jumlah Pegawai</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($golongan as $key => $item)
                    <tr>
                        <td>{{ $golongan->firstItem() + $key }}</td>
                        <td><span class="badge bg-info">{{ $item->kode }}</span></td>
                        <td><strong>{{ $item->nama_golongan }}</strong></td>
                        <td>Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->tunjangan_makan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->tunjangan_transport, 0, ',', '.') }}</td>
                        <td class="text-success">
                            Rp {{ number_format($item->tunjangan_makan + $item->tunjangan_transport, 0, ',', '.') }}
                        </td>
                        <td class="fw-bold text-primary">
                            Rp {{ number_format($item->gaji_pokok + $item->tunjangan_makan + $item->tunjangan_transport, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $item->pegawai_count }} pegawai</span>
                        </td>
                        <td>
                            <a href="{{ route('golongan.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('golongan.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('golongan.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Yakin ingin menghapus golongan {{ $item->nama_golongan }}?')"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <i class="fas fa-database fa-2x text-muted mb-2 d-block"></i>
                            Belum ada data golongan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Menampilkan <strong>{{ $golongan->firstItem() }}</strong> 
                sampai <strong>{{ $golongan->lastItem() }}</strong> 
                dari <strong>{{ $golongan->total() }}</strong> data
            </div>
            <div>
                {{ $golongan->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection