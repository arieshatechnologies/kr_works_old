<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CoWorkerController;
use App\Http\Controllers\SupplierdetailsController;
use App\Http\Controllers\SupplierPaymentController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::apiResource('suppliers', SupplierController::class);
Route::get('/co-workers', [CoWorkerController::class, 'index']);
Route::post('/co-workers', [CoWorkerController::class, 'store']);
Route::get('/co-workers/{id}', [CoWorkerController::class, 'show']);
Route::put('/co-workers/{id}', [CoWorkerController::class, 'update']);
Route::post('/co-workers/delete', [CoWorkerController::class, 'destroy']);


Route::get('/supplierDetails', [SupplierdetailsController::class, 'index']); // List all suppliers
Route::post('/supplierDetails', [SupplierdetailsController::class, 'store']); // Create a new supplier
Route::get('/supplierDetails/{id}', [SupplierdetailsController::class, 'show']); // Get a specific supplier
Route::put('/supplierDetails/{id}', [SupplierdetailsController::class, 'update']); // Update supplier details
Route::delete('/supplierDetails', [SupplierdetailsController::class, 'destroy']); // Delete a supplier by ID

Route::apiResource('suppliersPayments', SupplierPaymentController::class);
