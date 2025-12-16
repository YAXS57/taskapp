<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckDosen; // Panggil Middleware Satpam

// 1. HALAMAN DEPAN (Bisa diakses siapa saja)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 2. RUTE LOGIN DOSEN
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. RUTE DOSEN (DILINDUNGI PASSWORD)
// Semua rute di dalam grup ini wajib login dulu
Route::middleware([CheckDosen::class])->group(function () {
    
    Route::resource('assignments', AssignmentController::class);
    Route::get('assignments/{id}/submissions', [AssignmentController::class, 'showSubmissions'])->name('assignments.submissions');

});

// 4. RUTE MAHASISWA (Bebas Akses)
Route::get('/student', [SubmissionController::class, 'create'])->name('student.create');
Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');

Route::get('/submissions/{id}/download', [SubmissionController::class, 'download'])->name('submissions.download');