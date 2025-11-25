@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Data Pegawai</h4>
        <a href="{{ route('pegawai.create') }}" class="btn btn-primary">+ Tambah Pegawai</a>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Departemen</th>
                        <th>Kantor</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawai as $p)
                    <tr>
                        <td width="70">
                            @if($p->foto)
                                <img src="{{ asset('storage/'.$p->foto) }}" width="60" class="rounded">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        
                        <td>{{ $p->user->name ?? '-' }}</td>
                        <td>{{ $p->departemen->nama ?? '-' }}</td>
                        <td>{{ $p->kantor->nama ?? '-' }}</td>
                        <td>{{ $p->no_hp }}</td>
                        <td>
                            <span class="badge bg-{{ $p->status == 'aktif' ? 'success' : 'secondary' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pegawai.show',$p->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('pegawai.edit',$p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('pegawai.destroy',$p->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus data?')" class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
