<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the suppliers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('id','desc')->get();;

        foreach ($suppliers as $supplier) {
            $supplierName = SupplierDetails::where('id', $supplier->supplier_id)->value('name');
            $supplier->supplier_name = $supplierName;
        }

         // Check if the suppliers list is empty
        if ($suppliers->isEmpty()) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No suppliers found',
                'data' => [],
            ], 404);
        }
        return response()->json(["status"=>"success","message"=>"Suppliers found", "data" => $suppliers], 200);
    }

    public function getSareeCountByDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'supplier_id' => 'required|integer'
        ]);

            // Check if validation fails
        if ($validator->fails()) {
            // Return the first error message
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(), // Get the first validation error
            ], 422);
        }
        // $suppliers = Supplier::all()->where('supplier_id',$request->supplier_id)->whereBetween('date',[$request->start_date,$request->end_date]);
        //  // Check if the suppliers list is empty
        // if ($suppliers->isEmpty()) {
        //     return response()->json([
        //         'status' => 'failure',
        //         'message' => 'No data found',
        //         'data' => [],
        //     ], 404);
        // }

        $sums = Supplier::where('supplier_id', $request->supplier_id)
        ->whereBetween('date', [$request->start_date, $request->end_date])
        ->selectRaw('SUM(ns) as total_ns, SUM(bs) as total_bs, SUM(bbs) as total_bbs')
        ->first();
        
        //Access the sums
        $totalNs = $sums->total_ns;
        $totalBs = $sums->total_bs;
        $totalBbs = $sums->total_bbs;

        if ($totalNs == null || $totalBs == null || $totalBbs == null) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No data found',
                'data' => [],
            ], 404);
        }

        return response()->json(["status"=>"success","message"=>"Data found", "ns" => $totalNs, "bs" => $totalBs, "bbs" => $totalBbs], 200);
    }

    /**
     * Store a newly created supplier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'supplier_id' => 'required|integer',
            'ns' => 'required|integer',
            'bs' => 'required|integer',
            'bbs' => 'required|integer',
        ]);

            // Check if validation fails
        if ($validator->fails()) {
            // Return the first error message
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(), // Get the first validation error
            ], 422);
        }

        // Proceed with storing the data
        $validated = $validator->validated();
        $supplier = Supplier::create($validated);

        return response()->json(["status" =>"success","message"=>"New supplier details created successfully","data" => $supplier], 201);
    }
    /**
     * Display the specified supplier.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Supplier $supplier)
    {
        return response()->json($supplier, 200);
    }

    /**
     * Update the specified supplier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'date' => 'sometimes|required|date',
            'supplier_id' => 'sometimes|required|integer',
            'ns' => 'sometimes|required|integer',
            'rns' => 'sometimes|required|integer',
            'bs' => 'sometimes|required|integer',
            'rbs' => 'sometimes|required|integer',
            'bbs' => 'sometimes|required|integer',
            'rbbs' => 'sometimes|required|integer',
            'a_status' => 'required|integer',
        ]);

        $supplier->update($validated);

        return response()->json(["status"=>"success","message"=>"Supplier details updated successfully","data"=>$supplier], 200);
    }

    /**
     * Remove the specified supplier from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $supplier = Supplier::find($request->id);

        if (!$supplier) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Co-worker not found',
            ], 404);
        }

        $supplier->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Co-worker deleted successfully',
        ], 200);
    }
    public function filterByDate(Request $request)
{
    // Validate the incoming request parameters
    $validator = Validator::make($request->all(), [
        'start_date' => 'required|date',
        'end_date' => 'required|date',
    ]);

    // If validation fails, return a failure response with validation errors
    if ($validator->fails()) {
        return response()->json([
            'status' => 'failure',
            'message' => $validator->errors()->first(), // Get the first validation error
        ], 422);
    }

    // Retrieve the start and end dates from the request
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    // Query suppliers between the given date range
    $suppliers = Supplier::whereBetween('date', [$startDate, $endDate])
        ->orderBy('date', 'desc')
        ->get();

    // If no suppliers found in the date range, return a failure response
    if ($suppliers->isEmpty()) {
        return response()->json([
            'status' => 'failure',
            'message' => 'No suppliers found in the specified date range',
            'data' => [],
        ], 404);
    }

    // Otherwise, return a success response with the filtered suppliers
    return response()->json([
        'status' => 'success',
        'message' => 'Suppliers found within the specified date range',
        'data' => $suppliers,
    ], 200);
}

}