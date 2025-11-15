@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <p class="text-uppercase text-muted mb-1" style="letter-spacing:.2em;">Dashboard Admin</p>
            <h1 class="h3 mb-0" style="background:linear-gradient(90deg,#00B8F0,#E64FC5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Manajemen Jadwal Posyandu</h1>
        </div>
        <div class="px-4 py-3 rounded-4 mt-3 mt-md-0" style="background:rgba(0,184,240,.08);">
            Total Agenda: <strong>{{ $schedules->count() }}</strong>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan.</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Tambah Jadwal Baru</h2>
            <form action="{{ route('schedules.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label for="title" class="form-label">Nama Kegiatan</label>
                    <input type="text" class="form-control form-control-lg" id="title" name="title" value="{{ old('title') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="event_date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control form-control-lg" id="event_date" name="event_date" value="{{ old('event_date') }}" required>
                </div>
                <div class="col-md-3">
                    <label for="start_time" class="form-label">Jam Mulai</label>
                    <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_time" class="form-label">Jam Selesai</label>
                    <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}">
                </div>
                <div class="col-md-6">
                    <label for="location" class="form-label">Lokasi (opsional)</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" placeholder="Contoh: Posyandu Mina">
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Deskripsi Singkat</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Tujuan kegiatan atau catatan lainnya">{{ old('description') }}</textarea>
                </div>
                <div class="col-12 d-flex align-items-center gap-2">
                    <input class="form-check-input" type="checkbox" value="1" id="is_published" name="is_published" {{ old('is_published', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Tampilkan di halaman publik
                    </label>
                </div>
                <div class="col-12 d-grid d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary btn-lg">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">Daftar Jadwal Aktif</h2>
                <span class="badge bg-primary-subtle text-primary">{{ $schedules->count() }} kegiatan</span>
            </div>
            @if($schedules->isEmpty())
                <p class="text-muted mb-0">Belum ada jadwal. Silakan tambahkan terlebih dahulu.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                                @php
                                    $dateObj = \Illuminate\Support\Carbon::parse($schedule->event_date)->locale('id');
                                    $timeRange = $schedule->start_time ? substr($schedule->start_time, 0, 5) : null;
                                    if($schedule->end_time){
                                        $timeRange = $timeRange ? $timeRange.' - '.substr($schedule->end_time, 0, 5) : substr($schedule->end_time, 0, 5);
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $dateObj->translatedFormat('d M Y') }}</strong>
                                        <div class="text-muted small">{{ $dateObj->translatedFormat('l') }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $schedule->title }}</div>
                                        @if($schedule->description)
                                            <div class="text-muted small">{{ $schedule->description }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($timeRange)
                                            <span class="badge bg-info-subtle text-info">{{ $timeRange }} WIB</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                        @if($schedule->location)
                                            <div class="text-muted small">{{ $schedule->location }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($schedule->is_published)
                                            <span class="badge bg-success-subtle text-success">Ditampilkan</span>
                                        @else
                                            <span class="badge bg-secondary">Disembunyikan</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editScheduleModal-{{ $schedule->id }}">Edit</button>
                                            <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @foreach($schedules as $schedule)
                    <div class="modal fade" id="editScheduleModal-{{ $schedule->id }}" tabindex="-1" aria-labelledby="editScheduleModalLabel-{{ $schedule->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editScheduleModalLabel-{{ $schedule->id }}">Edit Jadwal</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('schedules.update', $schedule) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Nama Kegiatan</label>
                                                <input type="text" class="form-control" name="title" value="{{ $schedule->title }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" name="event_date" value="{{ $schedule->event_date->format('Y-m-d') }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Jam Mulai</label>
                                                <input type="time" class="form-control" name="start_time" value="{{ $schedule->start_time ? substr($schedule->start_time, 0, 5) : null }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Jam Selesai</label>
                                                <input type="time" class="form-control" name="end_time" value="{{ $schedule->end_time ? substr($schedule->end_time, 0, 5) : null }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" name="location" value="{{ $schedule->location }}" placeholder="Opsional">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea class="form-control" name="description" rows="3">{{ $schedule->description }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="publishCheck{{ $schedule->id }}" name="is_published" {{ $schedule->is_published ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="publishCheck{{ $schedule->id }}">
                                                        Tampilkan jadwal ini di halaman publik
                                                    </label>
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
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
