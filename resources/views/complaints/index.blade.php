@extends('layouts.app')

@section('content')
    @php use App\Models\Complaint; @endphp
    <div class="container py-4">
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div>
                <p class="text-uppercase text-muted mb-1" style="letter-spacing: .2em;">Dashboard Admin</p>
                <h1 class="h3 mb-0" style="background:linear-gradient(90deg,#00B8F0,#E64FC5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Manajemen Laporan Pengaduan</h1>
            </div>
            @php $total = $complaints->total(); $today = $complaints->where('created_at','>=', now()->startOfDay())->count(); @endphp
            <div class="d-flex gap-3 mt-3 mt-md-0">
                <div class="px-4 py-3 rounded-4 text-center" style="background:rgba(0,184,240,.1); min-width:160px;">
                    <p class="text-muted mb-1 small">Total Laporan</p>
                    <p class="h4 mb-0">{{ $total }}</p>
                </div>
                <div class="px-4 py-3 rounded-4 text-center" style="background:rgba(230,79,197,.1); min-width:160px;">
                    <p class="text-muted mb-1 small">Hari Ini</p>
                    <p class="h4 mb-0">{{ $today }}</p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('complaints.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="category" class="form-label">Kategori Pengaduan</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                        <a href="{{ route('complaints.index') }}" class="btn btn-outline-secondary">Reset</a>
                        <div class="ms-auto">
                            <a href="{{ route('complaints.export.pdf', request()->query()) }}" class="btn btn-outline-danger">Export PDF</a>
                            <a href="{{ route('complaints.export.excel', request()->query()) }}" class="btn btn-outline-success">Export Excel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Nomor Whatsapp</th>
                        <th>Kategori Pengaduan</th>
                        <th>Isi Pengaduan</th>
                        <th>Alamat Lengkap</th>
                        <th>RT</th>
                        <th>Status</th>
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
                                <form action="{{ route('complaints.updateStatus', $complaint) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_resolved" value="0">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_resolved" value="1" onchange="this.form.submit()" {{ $complaint->is_resolved ? 'checked' : '' }}>
                                        <label class="form-check-label small">{{ $complaint->is_resolved ? 'Selesai' : 'Proses' }}</label>
                                    </div>
                                </form>
                            </td>
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
        </div>
    </div>
@endsection
