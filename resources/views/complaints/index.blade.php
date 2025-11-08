@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Manajemen Laporan Pengaduan</h1>

        <div class="card mb-3">
            <div class="card-header">Filter Laporan</div>
            <div class="card-body">
                <form action="{{ route('complaints.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori Pengaduan</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('complaints.index') }}" class="btn btn-secondary">Reset Filter</a>
                </form>
            </div>
        </div>

        <div class="mb-3">
            <a href="{{ route('complaints.export.pdf', request()->query()) }}" class="btn btn-danger">Export PDF</a>
            <a href="{{ route('complaints.export.excel', request()->query()) }}" class="btn btn-success">Export Excel</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Nomor Whatsapp</th>
                        <th>Kategori Pengaduan</th>
                        <th>Isi Pengaduan</th>
                        <th>Alamat Lengkap</th>
                        <th>RT</th>
                        <th>Bukti</th>
                        <th>Tanggal Laporan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                        <tr>
                            <td>{{ $complaint->nama_lengkap }}</td>
                            <td>{{ $complaint->nomor_whatsapp }}</td>
                            <td>{{ $complaint->kategori_pengaduan }}</td>
                            <td>{{ $complaint->isi_pengaduan }}</td>
                            <td>{{ $complaint->alamat_lengkap }}</td>
                            <td>{{ $complaint->rt }}</td>
                            <td>
                                @if($complaint->bukti)
                                    <a href="{{ Storage::url($complaint->bukti) }}" target="_blank">Lihat Bukti</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                            <td>{{ $complaint->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Tidak ada laporan pengaduan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $complaints->links() }}
    </div>
@endsection