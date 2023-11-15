<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Menampilkan seluruh data
Route::get('/patients', [PatientsController::class, 'index']);

// Menambah data
Route::post('/patients', [PatientsController::class, 'store']);

// Menampilakn data Spesifik By Id
Route::get('/patients/{id}', [PatientsController::class, 'show']);

// Mengubah data/Edit data
Route::put('/patients/{id}', [PatientsController::class, 'update']);

// Menghapus data
Route::delete('/patients/{id}', [PatientsController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
   
});


