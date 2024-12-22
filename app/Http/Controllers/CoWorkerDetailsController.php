<?php

namespace App\Http\Controllers;
use App\Models\CoWorkerDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoWorkerDetailsController extends Controller
{   
    public function index()
    {
        $coWorkers = CoWorkerDetails::orderBy('id','desc')->get();;
    
        if ($coWorkers->isEmpty()) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No co-workers found',
                'data' => [],
            ], 404);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Co-workers found',
            'data' => $coWorkers,
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

        $coWorker = CoWorkerDetails::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Co-worker created successfully',
            'data' => $coWorker,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $coWorker = CoWorkerDetails::find($id);

        if (!$coWorker) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Co-worker not found',
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

        $coWorker->update($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Co-worker details updated successfully',
            'data' => $coWorker,
        ], 200);
    }

    public function destroy(Request $request)
    {
        $coWorker = CoWorkerDetails::find($request->id);

        if (!$coWorker) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Co-worker not found',
            ], 404);
        }

        $coWorker->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Co-worker details deleted successfully',
        ], 200);
    }

    public function show($id)
    {
        $coWorker = CoWorkerDetails::find($id);

        if (!$coWorker) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Co-worker details not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Co-worker details found',
            'data' => $coWorker,
        ], 200);
    }
}
