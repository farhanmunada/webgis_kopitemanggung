<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EntrepreneurController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

// Group 1: Public
Route::get('/', [MapController::class, 'index'])->name('map.index');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/umkm', [KatalogController::class, 'umkmIndex'])->name('umkm.index');
Route::get('/katalog/umkm/{slug}', [KatalogController::class, 'showUmkm'])->name('katalog.umkm');
Route::get('/product/{type}/{slug}', [KatalogController::class, 'showProduct'])->name('product.show');
Route::post('/product/{type}/{id}/review', [KatalogController::class, 'storeReview'])->name('product.review.store')->middleware('auth');

// Support Pages
Route::get('/help', [\App\Http\Controllers\SupportController::class, 'help'])->name('support.help');
Route::get('/privacy', [\App\Http\Controllers\SupportController::class, 'privacy'])->name('support.privacy');
Route::get('/terms', [\App\Http\Controllers\SupportController::class, 'terms'])->name('support.terms');

// Group 2: Auth routes for socialite
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Group 3: Entrepreneur (UMKM) - Restricted to Approved Only
Route::middleware(['auth', 'role:umkm'])->prefix('dashboard')->name('entrepreneur.')->group(function () {
    Route::get('/', [EntrepreneurController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [EntrepreneurController::class, 'indexProducts'])->name('product.index');
    Route::post('/product', [EntrepreneurController::class, 'storeProduct'])->name('product.store');
    Route::get('/product/{type}/{id}/edit', [EntrepreneurController::class, 'editProduct'])->name('product.edit');
    Route::put('/product/{type}/{id}', [EntrepreneurController::class, 'updateProduct'])->name('product.update');
    Route::delete('/product/{type}/{id}', [EntrepreneurController::class, 'destroyProduct'])->name('product.destroy');

    // Profile Settings
    Route::get('/entrepreneur/profile', [EntrepreneurController::class, 'editProfile'])->name('profile.settings');
    Route::put('/entrepreneur/profile', [EntrepreneurController::class, 'updateProfile'])->name('profile.update');
    Route::get('/entrepreneur/notifications', [EntrepreneurController::class, 'notifications'])->name('notifications');
});

// Group 4: Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [AdminController::class, 'productsIndex'])->name('products.index');
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    
    // UMKM Approval
    Route::get('/umkm/{id}', [AdminController::class, 'showUmkm'])->name('umkm.show');
    Route::post('/umkm/{id}/approve', [AdminController::class, 'approveUmkm'])->name('umkm.approve');
    Route::post('/umkm/{id}/reject', [AdminController::class, 'rejectUmkm'])->name('umkm.reject');
    
    // Product Approval
    Route::get('/product/{type}/{id}', [AdminController::class, 'showProduct'])->name('product.show');
    Route::post('/product/{type}/{id}/approve', [AdminController::class, 'approveProduct'])->name('product.approve');
    Route::post('/product/{type}/{id}/reject', [AdminController::class, 'rejectProduct'])->name('product.reject');
});

Route::middleware('auth')->group(function () {
    // Redirect route named 'dashboard' for Breeze's default redirection
    Route::get('/auth/redirect', function () {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'umkm') {
            return redirect()->route('entrepreneur.dashboard');
        } elseif ($user->umkms()->exists()) {
            // Public user but has UMKM application
            return redirect('/')->with('show_umkm_status', true);
        }
        
        return redirect('/')->with('success', 'Selamat datang! Gunakan fitur "Daftarkan UMKM" di peta untuk bergabung sebagai mitra.');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // UMKM Registration for elevation to Entrepreneur
    Route::get('/register-umkm', [EntrepreneurController::class, 'createUmkm'])->name('umkm.register');
    Route::post('/register-umkm', [EntrepreneurController::class, 'storeUmkm'])->name('umkm.register.store');
});

require __DIR__.'/auth.php';
