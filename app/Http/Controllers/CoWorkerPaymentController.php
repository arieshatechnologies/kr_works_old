<?php

namespace App\Http\Controllers;

use App\Models\CoWorker;
use App\Models\CoWorkerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoWorkerPaymentController extends Controller
{
    public function calculatePayment($id)
    {
        $coWorker = CoWorker::find($id);

        if (!$coWorker) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Co-worker not found',
            ], 404);
        }

        $totalSarees = $coWorker->ns + $coWorker->bs + $coWorker->bbs;
        $returnedSarees = $coWorker->rns + $coWorker->rbs + $coWorker->rbbs;
        $paymentPerSaree = 100; // Example rate

        $totalAmount = ($totalSarees - $returnedSarees) * $paymentPerSaree;

        $payment = CoWorkerPayment::updateOrCreate(
            ['co_worker_id' => $coWorker->id],
            [
                'total_sarees' => $totalSarees,
                'returned_sarees' => $returnedSarees,
                'total_amount' => $totalAmount,
                'paid_amount' => 0,
                'balance_amount' => $totalAmount,
                'status' => 0,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Payment calculated successfully',
            'data' => $payment,
        ], 200);
    }

    public function updatePayment(Request $request, $id)
    {
        $payment = CoWorkerPayment::find($id);

        if (!$payment) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Payment record not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'paid_amount' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $payment->paid_amount += $request->paid_amount;
        $payment->balance_amount = $payment->total_amount - $payment->paid_amount;

        if ($payment->balance_amount <= 0) {
            $payment->status = 2; // Fully paid
            $payment->balance_amount = 0;
        } else {
            $payment->status = 1; // Partially paid
        }

        $payment->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment updated successfully',
            'data' => $payment,
        ], 200);
    }

    public function showPayments($id)
    {
        $payments = CoWorkerPayment::where('co_worker_id', $id)->get();

        if ($payments->isEmpty()) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No payment records found for this co-worker',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Payment records retrieved successfully',
            'data' => $payments,
        ], 200);
    }

    public function index()
    {
        $payments = CoWorkerPayment::all();

        if ($payments->isEmpty()) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No payment records found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Payment records retrieved successfully',
            'data' => $payments,
        ], 200);
    }
}
