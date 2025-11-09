@extends('layouts.app')

@section('content')
<div class="container py-6">
  <h1 class="h4 mb-4">Import Data Cakupan</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card mb-4">
    <div class="card-body">
      <form action="{{ route('cakupan.import') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="file" class="form-label">File Excel (.xlsx/.xls/.csv)</label>
          <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <p class="small text-muted">
          Format (sheet pertama) untuk multi-metrik: Kolom A = <strong>Kategori</strong>, Kolom B = <strong>Metrik</strong> (mis. "Capaian", "Sasaran", "Hadir"), Kolom C dst = label (bulan/antigen). Baris berikutnya berisi angka per label. <br>
          Contoh kategori: Imunisasi Dasar, ASI Eksklusif, Pelayanan Kesehatan Balita, Pelayanan Kesehatan Lansia, Pelayanan Kesehatan Ibu Hamil, Pelayanan Kesehatan Akseptor Aktif KB. <br>
          Unduh template CSV: <a href="{{ asset('assets/samples/cakupan-template.csv') }}" target="_blank">cakupan-template.csv</a>
        </p>
        <button class="btn btn-primary">Import</button>
        <a class="btn btn-outline-secondary" href="{{ route('cakupan') }}" target="_blank">Lihat Halaman Cakupan</a>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Preview Data Tersimpan</h5>
      @php
        $labels = $data['labels'] ?? [];
        $series = $data['series'] ?? [];
      @endphp
      @if(empty($labels))
        <p class="text-muted">Belum ada data tersimpan.</p>
      @else
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Kategori</th>
                @foreach($labels as $l)
                  <th>{{ $l }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @foreach($series as $name => $values)
                <tr>
                  <td>{{ $name }}</td>
                  @foreach($values as $v)
                    <td>{{ is_null($v) ? '-' : $v }}</td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
