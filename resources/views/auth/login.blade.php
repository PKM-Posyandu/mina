@extends('layouts.app')

@section('content')
<style>
    .auth-bg {
        min-height: 100vh;
        background: linear-gradient(120deg, rgba(0,184,240,0.15), rgba(230,79,197,0.2));
        display: flex;
        align-items: center;
    }
    .auth-card {
        border-radius: 24px;
        overflow: hidden;
        border: none;
    }
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
                            <h3 class="fw-bold mb-3">Selamat Datang 👋</h3>
                            <p class="mb-4">Masuk sebagai admin Posyandu Mina untuk mengelola pengaduan, galeri, dan cakupan layanan.</p>
                            <ul class="list-unstyled small">
                                <li class="mb-2">✓ Statistik dan laporan pengaduan</li>
                                <li class="mb-2">✓ Manajemen galeri kegiatan</li>
                                <li>✓ Import data cakupan multi-sheet</li>
                            </ul>
                        </div>
                        <div class="col-md-7 p-5">
                            <h4 class="mb-4 text-gradient">Masuk ke Admin</h4>
                            <form method="POST" action="{{ route('login') }}" class="w-100">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required>
                                    @error('password')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">Masuk</button>
                                    <a class="text-center small" href="{{ route('register') }}">Belum punya akun? Daftar</a>
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
