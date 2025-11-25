@extends('layouts.index')

@section('content')
<style>
</style>

<div class="page-header">
  <div>
    <h3>Kelola Departent</h3>
    <p>Daftar departement di sistem.</p>
  </div>
  <a href="#"class="btn-add">+ Tambah Departement</a>
</div>

@if (session('success'))
  <div class="alert-succes">{{ session('success') }}</div>
@endif
@if (session('error'))
  <div class="alert-danger">{{ session('error') }}</div>
@endif

<div class="table-container">
  <table id="departemen" class="display">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Departement</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($data as $index => $departemen)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $departemen->nama-departemen }}</td>
        <td>
          <a href="#" class="btn btn-edit">Edit</a>
          <form action="#" method="POST" style="display:inline;" onsubmit="return confirm('Yakin mau hapus kelas ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-delete">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="3">Belum ada data kelas</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#kelas').DataTable(); 
  });
</script>
@endsection
