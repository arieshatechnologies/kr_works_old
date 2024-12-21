<?php

namespace App\Http\Controllers;

use App\Models\supplier_payment;
use App\Models\SupplierDetails;
use Illuminate\Http\Request;

class SupplierPaymentController extends Controller
{
    /**
     * Display a listing of the supplier payments.
     */
    public function index()
    {
        $supplierPayments = supplier_payment::all();

        if ($supplierPayments->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 404);
        }

        foreach ($supplierPayments as $supplier) {
            $supplierName = SupplierDetails::where('id', $supplier->supplier_id)->value('name');
            $supplier->supplier_name = $supplierName;
        }

        return response()->json(['status' => 'success', 'data' => $supplierPayments], 200);
    }

    /**
     * Store a newly created supplier payment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|integer',
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

        $supplierPayment = supplier_payment::create($validated);

        return response()->json(['status' => 'success', 'data' => $supplierPayment], 201);
    }

    /**
     * Display the specified supplier payment.
     */
    public function show(supplier_payment $supplierPayment)
    {
        if (!$supplierPayment) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $supplierPayment], 200);
    }

    /**
     * Update the specified supplier payment in storage.
     */
    /**
     * Update the specified supplier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\supplier_payment  $supplierPayment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Find the supplier payment by ID
        $supplierPayment = supplier_payment::find($id);

        // If the supplier payment does not exist, return an error
        if (!$supplierPayment) {
            return response()->json(['status' => 'error', 'message' => 'Supplier payment not found'], 404);
        }

        // Validate the incoming data
        $validated = $request->validate([
            'supplier_id' => 'sometimes|integer',
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
        $supplierPayment->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier payment updated successfully',
            'data' => $supplierPayment,
        ], 200);
    }

    /**
     * Remove the specified supplier payment from storage.
     */
    public function destroy(Request $request, $id)
    {
        // Find the supplier payment by ID
        $supplierPayment = supplier_payment::find($id);
        // Check if the supplier payment exists
        if (!$supplierPayment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Supplier payment not found',
            ], 404);
        }
        $supplierPayment->delete();

        return response()->json(['status' => 'success', 'message' => 'Supplier payment deleted successfully'], 200);
    }
}
