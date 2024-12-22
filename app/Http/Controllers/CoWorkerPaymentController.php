<?php

namespace App\Http\Controllers;

use App\Models\CoWorkerDetails;
use App\Models\CoWorkerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoWorkerPaymentController extends Controller
{
    public function index()
    {
        $coWorkerPayments = CoWorkerPayment::orderBy('id','desc')->get();;

        if ($coWorkerPayments->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 404);
        }

        foreach ($coWorkerPayments as $coWorker) {
            $coWorkerName = CoWorkerDetails::where('id', $coWorker->co_worker_id)->value('name');
            $coWorker->co_worker_name = $coWorkerName;
        }

        return response()->json(['status' => 'success', 'data' => $coWorkerPayments], 200);
    }
    // Method to calculate the payment for a co-worker
    public function calculatePayment($coWorkerId)
    {
        $totalSarees = 100; // Example saree count, you can fetch from DB
        $returnedSarees = 10; // Example count
        $ratePerSaree = 100; // Example rate

        $totalAmount = ($totalSarees - $returnedSarees) * $ratePerSaree;

        $payment = CoWorkerPayment::updateOrCreate(
            ['co_worker_id' => $coWorkerId],
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'co_worker_id' => 'required|integer',
            'ns' => 'required|integer',
            'bs' => 'required|integer',
            'bbs' => 'required|integer',
            'ans' => 'required|integer',
            'abs' => 'required|integer',
            'abbs' => 'required|integer',
            'total_amount' => 'required|integer',
            'given_amount' => 'required|integer',
            'status' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            
        ]);

        $coWorkerPayment = CoWorkerPayment::create($validated);
    
        $this->updateCoWorkerPayment($request->co_worker_id, $request->start_date, $request->end_date);


        return response()->json(['status' => 'success', 'data' => $coWorkerPayment], 201);
    }


    public function update(Request $request, $id)
    {
        // Find the supplier payment by ID
        $coWorkerPayments= CoWorkerPayment::find($id);

        // If the supplier payment does not exist, return an error
        if (!$coWorkerPayments) {
            return response()->json(['status' => 'error', 'message' => 'Co-Workers payment not found'], 404);
        }

        // Validate the incoming data
        $validated = $request->validate([
            'co_worker_id' => 'sometimes|integer',
            'ns' => 'sometimes|integer',
            'bs' => 'sometimes|integer',
            'bbs' => 'sometimes|integer',
            'ans' => 'sometimes|integer',
            'abs' => 'sometimes|integer',
            'abbs' => 'sometimes|integer',
            'total_amount' => 'sometimes|integer',
            'given_amount' => 'sometimes|integer',
            'status' => 'sometimes|integer',
            'start_date' => 'sometimes|date|nullable',
            'end_date' => 'sometimes|date|nullable',
        ]);

        // Manually update the fields
        $coWorkerPayments->update($validated);
        $this->updateCoWorkerPayment($request->co_worker_id, $request->start_date, $request->end_date);

        return response()->json([
            'status' => 'success',
            'message' => 'Co-Worker payment updated successfully',
            'data' => $coWorkerPayments,
        ], 200);
    }

    // Method to fetch all payments for a specific co-worker
   
     public function updateCoWorkerPayment($co_worker_id,$startDate, $endDate)
    {
        // Update the suppliers table where the date is between start_date and end_date
        DB::table('co_workers')
             ->where('co_worker_id', $co_worker_id)
            ->whereBetween('date_and_time', [$startDate, $endDate])
            ->update(['status' => 1]);
    }
    public function destroy(Request $request, $id)
    {
        // Find the supplier payment by ID
        $coWorkerPayments = CoWorkerPayment::find($id);
        // Check if the supplier payment exists
        if (!$coWorkerPayments) {
            return response()->json([
                'status' => 'error',
                'message' => 'Co-Woeker payment not found',
            ], 404);
        }
        $coWorkerPayments->delete();

        return response()->json(['status' => 'success', 'message' => 'Co-Worker payment deleted successfully'], 200);
    }
}

