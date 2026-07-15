@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users"></i> Data Pegawai</h5>
        <a href="{{ route('pegawai.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Tambah Pegawai
        </a>
    </div>
    <div class="card-body">
        <!-- Search Form -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ route('pegawai.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2"
                        placeholder="Cari nama atau NIP..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <span class="text-muted">
                    <i class="fas fa-database"></i> Total: {{ $pegawai->total() }} data
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>Golongan</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pegawai as $key => $item)
                    <tr>
                        <td>{{ $pegawai->firstItem() + $key }}</td>
                        <td><span class="badge bg-secondary">{{ $item->nip }}</span></td>
                        <td><strong>{{ $item->nama }}</strong></td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->departemen }}</td>
                        <td>{{ $item->jabatan }}</td>
                        <td>
                            <span class="badge bg-info">{{ $item->golongan->kode ?? '-' }}</span>
                            <br>
                            <small class="text-muted">{{ $item->golongan->nama_golongan ?? '-' }}</small>
                        </td>
                        <td>
                            @if($item->status == 'aktif')
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pegawai.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pegawai.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Yakin ingin menghapus pegawai {{ $item->nama }}?')"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <i class="fas fa-database fa-2x text-muted mb-2 d-block"></i>
                            Belum ada data pegawai
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination dengan Bootstrap 5 -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Menampilkan <strong>{{ $pegawai->firstItem() }}</strong> 
                sampai <strong>{{ $pegawai->lastItem() }}</strong> 
                dari <strong>{{ $pegawai->total() }}</strong> data
            </div>
            <div>
                {{ $pegawai->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection