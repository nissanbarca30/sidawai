<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentPublicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Redirect Halaman Utama ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes (Termasuk fitur reset password)
Auth::routes(['reset' => true]);

// Tes Pengiriman Email via SMTP
Route::get('/test-email', function () {
    try {
        Mail::raw('Halo! Ini adalah pesan tes pengiriman email via SMTP Laravel.', function ($message) {
            $message->to('email_tujuan@gmail.com')
                ->subject('Reset Password SIDAWAI');
        });

        return 'Email berhasil dikirim via SMTP!';
    } catch (\Exception $e) {
        return 'Gagal mengirim email: ' . $e->getMessage();
    }
});

// Dashboard User
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Group Route Terproteksi Auth
Route::middleware(['auth'])->group(function () {

    // 1. ROUTE KHUSUS FRONT-END (PEGAWAI)
    Route::get('/document/create', [DocumentController::class, 'create'])->name('document.create');
    Route::post('/document', [DocumentController::class, 'store'])->name('document.store');

    // Rute Stream Preview File Privat (Pegawai)
    Route::get('/document/preview/{id}', [DocumentController::class, 'previewFile'])->name('document.preview');

    // Rute Spesifik Berdasarkan Bulan & Download ZIP
    Route::get('/document/month/{bulan}', [DocumentController::class, 'byMonth'])->name('document.month');
    Route::get('/document/download/{bulan}', [DocumentController::class, 'downloadZip'])->name('document.download');

    // Route Pengaturan Profil User
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Rute Berdasarkan ID Dokumen
    Route::get('/document/{id}', [DocumentController::class, 'show'])->name('document.show');
    Route::get('/document/{id}/edit', [DocumentController::class, 'edit'])->name('document.edit');
    Route::put('/document/{id}', [DocumentController::class, 'update'])->name('document.update');
    Route::delete('/document/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');

    // 2. ROUTE PANEL ADMIN (Akses Admin Biasa & Superadmin)
    Route::middleware(['admin'])->prefix('admin')->as('admin.')->group(function () {

        // Dashboard Admin & Statistik Monitoring
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // CRUD Data Pegawai / Users
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');

        // Link Aman Stream File Terproteksi (Admin)
        Route::get('/file-preview/{id}', [AdminController::class, 'previewFile'])->name('file.preview');

        // Monitoring Dokumen Pegawai
        Route::get('/documents', [AdminController::class, 'documentsIndex'])->name('documents.index');
        Route::get('/documents/user/{userId}', [AdminController::class, 'userFolders'])->name('documents.user');
        Route::get('/documents/user/{userId}/month/{bulan}', [AdminController::class, 'monthFiles'])->name('documents.files');

        // Rute Edit & Hapus Dokumen oleh Admin
        Route::get('/documents/{id}/edit', [AdminController::class, 'editDocument'])->name('documents.edit');
        Route::put('/documents/{id}', [AdminController::class, 'updateDocument'])->name('documents.update');
        Route::delete('/documents/{id}', [AdminController::class, 'destroyDocument'])->name('documents.destroy');
        Route::post('/documents/store-for-user/{userId}', [AdminController::class, 'storeDocumentForUser'])->name('documents.store_for_user');

        Route::post('/toggle-register', [AdminController::class, 'toggleRegisterStatus'])->name('toggle_register');

        // 3. ROUTE KHUSUS SUPERADMIN (Akses Tertinggi)
        Route::middleware(['superadmin'])->group(function () {
            Route::get('/admins', [AdminController::class, 'manageAdmins'])->name('admins.index');
            Route::post('/users/{id}/promote', [AdminController::class, 'promoteToAdmin'])->name('admins.promote');
            Route::post('/users/{id}/demote', [AdminController::class, 'demoteToPegawai'])->name('admins.demote');
            Route::put('/users/{id}/permissions', [AdminController::class, 'updatePermissions'])->name('admins.update_permissions');
        });
    });
});

// Rute Publik untuk Menampilkan Dokumen yang Dibagikan Via Token
Route::get('/shared/document/{token}', [DocumentPublicController::class, 'previewShared'])
    ->name('document.shared.preview');