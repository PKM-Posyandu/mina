@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Manajemen Galeri Kegiatan</h1>

        <div class="card mb-3">
            <div class="card-header">Upload Gambar Baru</div>
            <div class="card-body">
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="image" class="form-label">Pilih Gambar</label>
                        <input class="form-control" type="file" id="image" name="image" required>
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>

        <h2>Galeri Gambar</h2>
        <div class="row">
            @forelse($images as $image)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="{{ Storage::url($image->image_path) }}" class="card-img-top" alt="Gallery Image">
                        <div class="card-body">
                            <form action="{{ route('gallery.destroy', $image) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this image?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>Tidak ada gambar di galeri.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection