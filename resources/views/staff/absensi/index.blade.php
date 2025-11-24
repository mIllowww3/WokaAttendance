@extends('layouts.index')

@section('title', 'Kelola Absensi')

@section('content')
<div class="page-header mb-4">
  <h3>Kelola Absensi</h3>
  <p>Data kehadiran siswa selama PKL.</p>
</div>

{{-- Pesan sukses / error --}}
@if (session('success'))
  <div class="alert alert-success small">{{ session('success') }}</div>
@endif
@if (session('error'))
  <div class="alert alert-danger small">{{ session('error') }}</div>
@endif
@if ($errors->any())
  <div class="alert alert-danger small">{{ $errors->first() }}</div>
@endif

{{-- Form Absen --}}
<div class="card mb-4 p-3">
  <form action="{{ route('siswa.absen.store') }}" method="POST" class="d-flex gap-2 flex-wrap">
    @csrf
    <div class="flex-fill">
      <select name="status" id="statusSelect" class="form-control">
        <option value="hadir">Hadir</option>
        <option value="izin">Izin</option>
        <option value="sakit">Sakit</option>
        <option value="libur">Libur</option>
      </select>
    </div>
    <div class="flex-fill-2">
      <input type="text" name="keterangan" id="keteranganInput" class="form-control" 
             placeholder="Keterangan (contoh: sakit demam, izin urusan keluarga)" disabled>
    </div>
    <div>
      <button type="submit" class="btn btn-blue">Masuk</button>
    </div>
  </form>
</div>

{{-- Tabel Absensi --}}
<div class="card p-3">
  <table class="table table-striped table-bordered">
    <thead class="table-primary">
      <tr>
        <th>ID</th>
        <th>Nama Siswa</th>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Jam Pulang</th>
        <th>Status</th>
        <th>Keterangan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($absen as $a)
        <tr>
          <td>{{ $a->id }}</td>
          <td>{{ $a->absensiswa->user->name ?? '-' }}</td>
          <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
          <td>{{ $a->waktu_masuk ?? '-' }}</td>
          <td>{{ $a->waktu_keluar ?? '-' }}</td>
          <td>{{ ucfirst($a->status) ?? '-' }}</td>
          <td>{{ $a->keterangan ?? '-' }}</td>
          <td>
            @if(strtolower($a->status) == 'hadir' && $a->waktu_keluar == null)
              <a href="{{ route('siswa.absen.pulang', $a->id) }}" class="btn btn-purple btn-sm">Pulang</a>
            @else
              <span class="badge bg-secondary">Selesai</span>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8" class="text-center">Belum ada data absensi</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection

@section('scripts')
<script>
document.getElementById('statusSelect').addEventListener('change', function() {
  const inputKet = document.getElementById('keteranganInput');
  if (['izin','sakit','libur'].includes(this.value)) {
    inputKet.disabled = false;
    inputKet.placeholder = 'Tuliskan alasan ' + this.value;
  } else {
    inputKet.value = '';
    inputKet.disabled = true;
    inputKet.placeholder = 'Keterangan (izin/sakit)';
  }
});
</script>
@endsection
 