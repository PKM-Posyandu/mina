@extends('layouts.app')

@section('content')
<div class="container py-3">
  <h1 class="mb-4">Manajemen Cakupan</h1>

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

  <div class="card mb-4">
    <div class="card-header">Upload & Import Excel</div>
    <div class="card-body">
      <form action="{{ route('admin.cakupan.import') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label class="form-label">File Excel (.xlsx, .xls)</label>
          <input type="file" name="file" accept=".xlsx,.xls" class="form-control" required>
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" value="1" id="replace" name="replace">
          <label class="form-check-label" for="replace">
            Ganti data lama per kategori (hapus data kategori yang ada lalu import dari file ini)
          </label>
        </div>
        <button type="submit" class="btn btn-primary">Upload & Import</button>
        <a href="{{ asset('assets/samples/Cakupan_MultiSheet_Template.xlsx') }}" class="btn btn-link">Lihat Template Excel</a>
      </form>
      <small class="text-muted d-block mt-2">Gunakan Excel multi-sheet dengan nama sheet sesuai spesifikasi.</small>
    </div>
  </div>

  <div class="card">
    <div class="card-header">Tautan Cepat (Publik)</div>
    <div class="card-body">
      <div class="row g-2">
        @php
          $cats = [
            'Imunisasi Dasar', 'ASI Eksklusif',
            'Pelayanan Kesehatan Balita', 'Pelayanan Kesehatan Lansia',
            'Pelayanan Kesehatan Ibu Hamil', 'Akseptor Aktif KB'
          ];
        @endphp
        @foreach($cats as $c)
          <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ url('/cakupan/'.rawurlencode($c)) }}" target="_blank" class="btn btn-outline-secondary w-100">{{ $c }}</a>
          </div>
        @endforeach
        <div class="col-12 mt-2">
          <a href="{{ route('cakupan.index') }}" target="_blank" class="btn btn-outline-primary">Lihat Semua Grafik di Satu Halaman</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
