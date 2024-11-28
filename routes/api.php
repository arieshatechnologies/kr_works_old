<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CoWorkerController;
use App\Http\Controllers\SupplierdetailsController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Route::apiResource('suppliers', SupplierController::class);
Route::get('/co-workers', [CoWorkerController::class, 'index']);
Route::post('/co-workers', [CoWorkerController::class, 'store']);
Route::get('/co-workers/{id}', [CoWorkerController::class, 'show']);
Route::put('/co-workers/{id}', [CoWorkerController::class, 'update']);
Route::post('/co-workers/delete', [CoWorkerController::class, 'destroy']);


Route::get('/suppliers', [SupplierdetailsController::class, 'index']); // List all suppliers
Route::post('/suppliers', [SupplierdetailsController::class, 'store']); // Create a new supplier
Route::get('/suppliers/{id}', [SupplierdetailsController::class, 'show']); // Get a specific supplier
Route::put('/suppliers/{id}', [SupplierdetailsController::class, 'update']); // Update supplier details
Route::delete('/suppliers', [SupplierdetailsController::class, 'destroy']); // Delete a supplier by ID


