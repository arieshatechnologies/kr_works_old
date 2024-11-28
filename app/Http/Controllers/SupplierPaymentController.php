<?php

namespace App\Http\Controllers;
use App\Models\supplier_payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierPaymentController extends Controller
{
    public function index()
    {
        $suppliers = supplier_payment::all();

        if ($suppliers->isEmpty()) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No supplier payments found',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Suppliers payments found',
            'data' => $suppliers,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $supplier = supplier_payment::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier payments created successfully',
            'data' => $supplier,
        ], 201);
    }


    public function show(supplier_payment $supplier)
    {
        return response()->json($supplier, 200);
    }

    public function update(Request $request, supplier_payment $supplier)
    {
        $validator = Validator::make($request->all(), [
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

        $supplier->update($validated);

        return response()->json(["status"=>"suceess","message"=>"Supplier payments details updated successfully","data"=>$supplier], 200);
    }

    public function destroy(Request $request)
    {
    
        $supplier = supplier_payment::find($request->id);
    
        if (!$supplier) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Supplier payments not found',
            ], 404);
        }
        $supplier->delete();

        return response()->json(["status" => "success","message" => "Record deleted successfully."], 204);
    }
}
