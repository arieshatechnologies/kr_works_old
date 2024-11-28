<?php

namespace App\Http\Controllers;

use App\Models\SupplierDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierdetailsController extends Controller
{
    public function index()
    {
        $suppliers = SupplierDetails::all();

        if ($suppliers->isEmpty()) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No suppliers found',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Suppliers found',
            'data' => $suppliers,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_no' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $supplier = SupplierDetails::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier created successfully',
            'data' => $supplier,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $supplier = SupplierDetails::find($id);

        if (!$supplier) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Supplier not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
            'phone_no' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $supplier->update($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier details updated successfully',
            'data' => $supplier,
        ], 200);
    }

    public function destroy(Request $request)
    {
        $supplier = SupplierDetails::find($request->id);

        if (!$supplier) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Supplier not found',
            ], 404);
        }

        $supplier->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier details deleted successfully',
        ], 200);
    }

    public function show($id)
    {
        $supplier = SupplierDetails::find($id);

        if (!$supplier) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Supplier details not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier details found',
            'data' => $supplier,
        ], 200);
    }
}
