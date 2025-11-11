@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div>
                <p class="text-uppercase text-muted mb-1" style="letter-spacing:.2em;">Dashboard Admin</p>
                <h1 class="h3 mb-0" style="background:linear-gradient(90deg,#00B8F0,#E64FC5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Manajemen Galeri Kegiatan</h1>
            </div>
            <div class="px-4 py-3 rounded-4 mt-3 mt-md-0" style="background:rgba(0,184,240,.08);">
                Total Foto: <strong>{{ $images->count() }}</strong>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-end">
                    @csrf
                    <div class="col-md-8">
                        <label for="image" class="form-label">Upload Gambar</label>
                        <input class="form-control form-control-lg" type="file" id="image" name="image" required>
                        @error('image')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Unggah</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            @forelse($images as $image)
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden">
                        <div class="ratio ratio-4x3">
                            <img src="{{ Storage::url($image->image_path) }}" class="w-100 h-100 object-fit-cover" alt="Gallery Image">
                        </div>
                        <div class="card-body">
                            <form action="{{ route('gallery.destroy', $image) }}" method="POST" onsubmit="return confirm('Hapus gambar ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    Belum ada gambar di galeri.
                </div>
            @endforelse
        </div>
    </div>
@endsection
