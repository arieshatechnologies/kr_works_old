<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
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
        $suppliers = Supplier::all();
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

        return response()->json(["status" =>"suceess","message"=>"New supplier details created successfully","data" => $supplier], 201);
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
            'ns' => 'sometimes|required|integer',
            'rns' => 'sometimes|required|integer',
            'bs' => 'sometimes|required|integer',
            'rbs' => 'sometimes|required|integer',
            'bbs' => 'sometimes|required|integer',
            'rbbs' => 'sometimes|required|integer',
        ]);

        $supplier->update($validated);

        return response()->json(["status"=>"suceess","message"=>"Supplier details updated successfully","data"=>$supplier], 200);
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
                'message' => 'Supplier not found',
            ], 404);
        }
        $supplier->delete();

        return response()->json(["status" => "Success","message" => "Record deleted successfully."], 204);
    }
}