<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = Gallery::all();
        return view('gallery.index', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'image_path' => $imagePath,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Image uploaded successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Image deleted successfully.');
    }
}