@extends('layout.app')

@section('content')

@section('title', 'Profil')

<style>
    .profile-container {
        max-width: 1200px;
        margin: 30px auto;
        display: flex;
        gap: 25px;
    }

    .profile-card {
        display: flex;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
    }

    .profile-sidebar {
        width: 320px;
        background: linear-gradient(135deg, #4A90E2, #0061A8);
        padding: 35px 25px;
        text-align: center;
        color: white;
    }

    .profile-sidebar img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        margin-bottom: 20px;
    }

    .profile-sidebar h3 {
        margin-bottom: 5px;
        font-size: 22px;
        font-weight: bold;
    }

    .profile-sidebar .email {
        font-size: 14px;
        opacity: 0.9;
    }

    .btn-edit {
        margin-top: 20px;
        padding: 10px 25px;
        border: none;
        display: block;
        width: 100%;
        background: white;
        color: #0061A8;
        font-weight: bold;
        border-radius: 50px;
        transition: 0.3s;
    }

    .btn-edit:hover {
        background: #f1f1f1;
        transform: scale(1.03);
    }

    .profile-content {
        flex: 1;
        padding: 35px 40px;
    }

    .section-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
        border-left: 5px solid #0061A8;
        padding-left: 10px;
    }

    .quick-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .info-box {
        background: #f8f9fc;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
    }

    .info-box label {
        font-weight: bold;
        color: #555;
    }

    .info-box span {
        display: block;
        margin-top: 5px;
        font-size: 18px;
        font-weight: 600;
        color: #222;
    }

    @media (max-width: 992px) {
        .profile-container {
            flex-direction: column;
        }

        .quick-info {
            grid-template-columns: 1fr;
        }

        .profile-sidebar {
            width: 100%;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-card">

        <!-- SIDEBAR -->
        <div class="profile-sidebar">
            <img src="{{ $pegawai->foto ? asset('storage/' . $pegawai->foto) : asset('images/default-profile.png') }}" alt="Foto Profil">
            <h3>{{ $pegawai->user->name }}</h3>
            <p class="email"><i class="bi bi-envelope-fill me-2"></i>{{ $pegawai->user->email ?? '-' }}</p>

            <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editProfileModal{{ $pegawai->id }}">
                Edit Profil
            </button>
        </div>

        <!-- KONTEN -->
        <div class="profile-content">

            <div class="section-title">Informasi Singkat</div>

            <div class="quick-info">
                <div class="info-box">
                    <label>Departemen:</label>
                    <span>{{ $pegawai->departemen->nama_departemen ?? '-' }}</span>
                </div>

                <div class="info-box">
                    <label>Perusahaan:</label>
                    <span>{{ $pegawai->kantor->nama_kantor ?? '-' }}</span>
                </div>

                <div class="info-box">
                    <label>No HP:</label>
                    <span>{{ $pegawai->no_hp ?? '-' }}</span>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal{{ $pegawai->id }}" tabindex="-1" aria-labelledby="editProfileModalLabel{{ $pegawai->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel{{ $pegawai->id }}">Edit Profil Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('staff.profile.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4 text-center">
                            <img src="{{ $pegawai->foto ? asset('storage/' . $pegawai->foto) : asset('images/default-profile.png') }}" class="img-fluid rounded-circle mb-2">
                            <label for="foto" class="form-label mt-2">Ganti Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>

                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $pegawai->user->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $pegawai->user->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ $pegawai->no_hp }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection