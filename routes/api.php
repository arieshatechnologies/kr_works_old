<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CoWorkerController;
use App\Http\Controllers\SupplierdetailsController;
use App\Http\Controllers\CoWorkerDetailsController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\CoWorkerPaymentController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::apiResource('suppliers', SupplierController::class);

Route::post('/getSareeCountByDate', [SupplierController::class, 'getSareeCountByDate']); 

Route::get('/co-workers', [CoWorkerController::class, 'index']);
Route::post('/co-workers', [CoWorkerController::class, 'store']);
Route::get('/co-workers/{id}', [CoWorkerController::class, 'show']);
Route::put('/co-workers/{id}', [CoWorkerController::class, 'update']);
Route::post('/co-workers/delete', [CoWorkerController::class, 'destroy']);


Route::get('/supplierDetails', [SupplierdetailsController::class, 'index']); // List all suppliers
Route::post('/supplierDetails', [SupplierdetailsController::class, 'store']); // Create a new supplier
Route::get('/supplierDetails/{id}', [SupplierdetailsController::class, 'show']); // Get a specific supplier
Route::put('/supplierDetails/{id}', [SupplierdetailsController::class, 'update']); // Update supplier details
Route::delete('/supplierDetails/{id}', [SupplierdetailsController::class, 'destroy']); // Delete a supplier by ID

Route::apiResource('suppliersPayments', SupplierPaymentController::class);

Route::get('/co_worker_payments', [CoWorkerPaymentController::class, 'index']);
Route::get('/co_worker_payments/{id}', [CoWorkerPaymentController::class, 'showPayments']);
Route::post('/co_worker_payments/{id}/calculate', [CoWorkerPaymentController::class, 'calculatePayment']);
Route::put('/co_worker_payments/{id}', [CoWorkerPaymentController::class, 'updatePayment']);


Route::get('/co-worker-details', [CoWorkerDetailsController::class, 'index']);
Route::post('/co-worker-details', [CoWorkerDetailsController::class, 'store']);
Route::get('/co-worker-details/{id}', [CoWorkerDetailsController::class, 'show']);
Route::put('/co-worker-details/{id}', [CoWorkerDetailsController::class, 'update']);
Route::delete('/co-worker-details/{id}', [CoWorkerDetailsController::class, 'destroy']);
