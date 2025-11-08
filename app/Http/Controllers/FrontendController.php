<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery; // Import the Gallery model

class FrontendController extends Controller
{
    public function index()
    {
        $images = Gallery::all(); // Fetch all gallery images
        return view('posyandu', compact('images')); // Pass images to the view
    }
}