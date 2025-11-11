@extends('layouts.app')

@section('content')
<style>
  .bg-bubble {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at top left, rgba(0,184,240,0.08), transparent 45%),
                radial-gradient(circle at bottom right, rgba(230,79,197,0.08), transparent 40%);
    z-index: 0;
  }
</style>

<div class="position-relative">
  <div class="bg-bubble"></div>
  <div class="container py-4 position-relative" style="z-index:1;">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
      <p class="text-uppercase text-muted mb-1" style="letter-spacing:.2em;">Dashboard Admin</p>
      <h1 class="h3 mb-0" style="background:linear-gradient(90deg,#00B8F0,#E64FC5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Manajemen Cakupan</h1>
    </div>
    <div class="mt-3 mt-md-0 px-4 py-3 rounded-4" style="background:rgba(0,184,240,.1);">
      <span class="text-muted small">File terakhir diunggah:</span>
      <strong>{{ optional(App\Models\IndikatorPosyandu::latest()->first())->updated_at?->format('d M Y') ?? 'Belum ada data' }}</strong>
    </div>
  </div>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
      <form action="{{ route('admin.cakupan.import') }}" method="post" enctype="multipart/form-data" class="row g-3 align-items-end">
        @csrf
        <div class="col-12">
          <label class="form-label">Upload &amp; Import Excel</label>
          <input type="file" name="file" accept=".xlsx,.xls" class="form-control form-control-lg" required>
        </div>
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="replace" name="replace">
            <label class="form-check-label" for="replace">
              Ganti data lama per kategori (hapus data kategori yang ada lalu import dari file ini)
            </label>
          </div>
        </div>
        <div class="col-lg-6 d-grid gap-2">
          <button type="submit" class="btn btn-primary btn-lg">Upload & Import</button>
        </div>
        <div class="col-lg-6 text-lg-end">
          <a href="{{ asset('assets/samples/Cakupan_MultiSheet_Template.xlsx') }}" class="btn btn-outline-primary btn-lg">Lihat Template Excel</a>
        </div>
      </form>
      <small class="text-muted d-block mt-3">Gunakan Excel multi-sheet dengan nama sheet sesuai spesifikasi.</small>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Tautan Cepat (Publik)</h5>
        <a href="{{ route('cakupan.index') }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat semua grafik</a>
      </div>
      <div class="row g-3">
        @php
          $cats = [
            'Imunisasi Dasar', 'ASI Eksklusif',
            'Pelayanan Kesehatan Balita', 'Pelayanan Kesehatan Lansia',
            'Pelayanan Kesehatan Ibu Hamil', 'Akseptor Aktif KB'
          ];
        @endphp
        @foreach($cats as $c)
          <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ url('/cakupan/'.rawurlencode($c)) }}" target="_blank" class="btn w-100" style="background:rgba(0,184,240,0.08); border:none;">
                {{ $c }}
              </a>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
</div>
@endsection
