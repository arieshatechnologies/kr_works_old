<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CoWorkerController;
use App\Http\Controllers\SupplierdetailsController;
use App\Http\Controllers\CoWorkerDetailsController;
use App\Http\Controllers\SupplierPaymentController;
use App\Http\Controllers\CoWorkerPaymentController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OtpController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::apiResource('suppliers', SupplierController::class);
Route::get('/suppliers/filter', [SupplierController::class, 'filterByDate']);


Route::post('/getSareeCountByDate', [SupplierController::class, 'getSareeCountByDate']); 

Route::get('/co-workers', [CoWorkerController::class, 'index']);
Route::post('/co-workers', [CoWorkerController::class, 'store']);
Route::get('/co-workers/{id}', [CoWorkerController::class, 'show']);
Route::put('/co-workers/{id}', [CoWorkerController::class, 'update']);
Route::delete('/co-workers/{id}', [CoWorkerController::class, 'destroy']); // Delete a supplier by ID
Route::post('/co-workers/getFilteredData', [CoWorkerController::class, 'getFilteredData']);
Route::post('/getCoWorkersSareeCountByDate', [CoWorkerController::class, 'getSareeCountByDate']); 


Route::get('/supplierDetails', [SupplierdetailsController::class, 'index']); // List all suppliers
Route::post('/supplierDetails', [SupplierdetailsController::class, 'store']); // Create a new supplier
Route::get('/supplierDetails/{id}', [SupplierdetailsController::class, 'show']); // Get a specific supplier
Route::put('/supplierDetails/{id}', [SupplierdetailsController::class, 'update']); // Update supplier details
Route::delete('/supplierDetails/{id}', [SupplierdetailsController::class, 'destroy']); // Delete a supplier by ID

Route::apiResource('suppliersPayments', SupplierPaymentController::class);



Route::post('/coWorkerPayments', [CoWorkerPaymentController::class, 'store']);
Route::get('/coWorkerPayments', [CoWorkerPaymentController::class, 'index']);
Route::put('/coWorkerPayments/{id}', [CoWorkerPaymentController::class, 'update']);
Route::delete('/coWorkerPayments/{id}', [CoWorkerPaymentController::class, 'destroy']); // Delete a supplier by ID



Route::get('/co-worker-details', [CoWorkerDetailsController::class, 'index']);
Route::post('/co-worker-details', [CoWorkerDetailsController::class, 'store']);
Route::get('/co-worker-details/{id}', [CoWorkerDetailsController::class, 'show']);
Route::put('/co-worker-details/{id}', [CoWorkerDetailsController::class, 'update']);
Route::delete('/co-worker-details/{id}', [CoWorkerDetailsController::class, 'destroy']);



Route::get('/send-email', [MailController::class, 'sendEmail']);
Route::post('send-otp', [OtpController::class,'send']);
Route::post('verify-otp', [OtpController::class,'verify']);

