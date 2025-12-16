<?php

use App\Http\Controllers\AssignmentController; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TelegramBotController;


Route::middleware('api')->group(function () {
    // API Tugas (Dosen: index, store)
    Route::resource('assignments', AssignmentController::class)->only(['index', 'store']); 

    // API Pengumpulan Tugas (Mahasiswa: store)
    Route::post('submissions', [SubmissionController::class, 'store']);
    
    // API Webhook Telegram
    Route::post('telegram/webhook', [TelegramBotController::class, 'handleWebhook']);

    Route::delete('assignments/{id}', [AssignmentController::class, 'destroy']);

    Route::get('assignments/{id}/submissions', [AssignmentController::class, 'getSubmissions']);

    Route::put('assignments/{id}', [AssignmentController::class, 'update']);

    // Contoh rute user bawaan Laravel
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});