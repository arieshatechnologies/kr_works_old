<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CoWorkerController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::apiResource('suppliers', SupplierController::class);
Route::get('/co-workers', [CoWorkerController::class, 'index']);
Route::post('/co-workers', [CoWorkerController::class, 'store']);
Route::get('/co-workers/{id}', [CoWorkerController::class, 'show']);
Route::put('/co-workers/{id}', [CoWorkerController::class, 'update']);
Route::post('/co-workers/delete', [CoWorkerController::class, 'destroy']);