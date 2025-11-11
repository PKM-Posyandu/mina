@extends('layouts.app')

@section('content')
<style>
    .auth-bg {
        min-height: 100vh;
        background: linear-gradient(120deg, rgba(0,184,240,0.15), rgba(230,79,197,0.2));
        display: flex;
        align-items: center;
    }
    .auth-card { border-radius: 24px; overflow: hidden; border: none; }
    .auth-info {
        background: linear-gradient(135deg, #00B8F0, #E64FC5);
        color: #fff;
        min-height: 100%;
    }
    .text-gradient {
        background: linear-gradient(90deg,#00B8F0,#E64FC5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<div class="auth-bg py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow-lg auth-card">
                    <div class="row g-0">
                        <div class="col-md-5 auth-info p-5 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold mb-3">Daftar Admin</h3>
                            <p class="mb-4">Hanya pengguna bersertifikat yang dapat mendaftar. Gunakan kode registrasi yang diberikan oleh koordinator.</p>
                            <div class="small">
                                <p class="mb-1">✓ Akses penuh ke dashboard</p>
                                <p class="mb-1">✓ Kelola pengaduan & galeri</p>
                                <p>✓ Upload data cakupan terbaru</p>
                            </div>
                        </div>
                        <div class="col-md-7 p-5">
                            <h4 class="mb-4 text-gradient">Buat Akun Admin</h4>
                            <form method="POST" action="{{ route('register') }}" class="w-100">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required>
                                        @error('password')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                                        <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="registration_code" class="form-label">Kode Registrasi</label>
                                    <input id="registration_code" type="text" class="form-control form-control-lg @error('registration_code') is-invalid @enderror" name="registration_code" required>
                                    @error('registration_code')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Daftar Sekarang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
