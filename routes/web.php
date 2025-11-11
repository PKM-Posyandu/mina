<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\FrontendController; // Import FrontendController
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\CakupanController as AdminCakupanController;
use App\Http\Controllers\Front\CakupanController as FrontCakupanController;

Route::get('/', [FrontendController::class, 'index'])->name('home'); // Update root route

// Public coverage charts
Route::get('/cakupan', [FrontCakupanController::class, 'index'])->name('cakupan.index');
Route::get('/cakupan/{kategori}', [FrontCakupanController::class, 'show'])->name('cakupan.show');
Route::get('/api/cakupan/{kategori}', [FrontCakupanController::class, 'api'])->name('cakupan.api');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});


Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('/pengaduan', [ComplaintController::class, 'create'])->name('complaints.create');

Route::redirect('/admin', '/dashboard');

Route::middleware(['auth', 'admin.access'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/chart-data', [ComplaintController::class, 'chartData'])->name('complaints.chartData');
    // Complaint Management
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/export/pdf', [ComplaintController::class, 'exportPdf'])->name('complaints.export.pdf');
    Route::get('/complaints/export/excel', [ComplaintController::class, 'exportExcel'])->name('complaints.export.excel');
    Route::patch('/complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');

    // Gallery Management
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    // Cakupan upload (admin)
    Route::get('/cakupan/upload', [AdminCakupanController::class, 'form'])->name('admin.cakupan.upload');
    Route::post('/cakupan/upload', [AdminCakupanController::class, 'import'])->name('admin.cakupan.import');
});
