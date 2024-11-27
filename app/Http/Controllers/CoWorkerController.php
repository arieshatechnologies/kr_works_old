<?php

namespace App\Http\Controllers;

use App\Models\CoWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoWorkerController extends Controller
{
    /**
     * Display a listing of the suppliers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
{
    $coWorkers = CoWorker::all();

    if ($coWorkers->isEmpty()) {
        return response()->json([
            'status' => 'failure',
            'message' => 'No co-workers found',
            'data' => [],
        ], 404);
    }

    return response()->json([
        'status' => 'Success',
        'message' => 'Co-workers found',
        'data' => $coWorkers,
    ], 200);
}


    /**
     * Store a newly created supplier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    
    /**
     * Display the specified supplier.
     *
     * @param  \App\Models\CoWorker  $coWorkers
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'co_worker_name' => 'required|string|max:255',
        'date_and_time' => 'required|date',
        'normal_saree' => 'required|integer',
        'border_saree' => 'required|integer',
        'big_border_saree' => 'required|integer',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'failure',
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $coWorker = CoWorker::create($validator->validated());

    return response()->json([
        'status' => 'Success',
        'message' => 'Co-worker created successfully',
        'data' => $coWorker,
    ], 201);
}

    /**
     * Update the specified supplier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CoWorker  $coWorkers
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
{
    $coWorker = CoWorker::find($id);

    if (!$coWorker) {
        return response()->json([
            'status' => 'failure',
            'message' => 'Co-worker not found',
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'co_worker_name' => 'sometimes|required|string|max:255',
        'date_and_time' => 'sometimes|required|date',
        'normal_saree' => 'sometimes|required|integer',
        'border_saree' => 'sometimes|required|integer',
        'big_border_saree' => 'sometimes|required|integer',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'failure',
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $coWorker->update($validator->validated());

    return response()->json([
        'status' => 'Success',
        'message' => 'Co-worker updated successfully',
        'data' => $coWorker,
    ], 200);
}

    /**
     * Remove the specified supplier from storage.
     *
     * @param  \App\Models\CoWorker  $coWorkers
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
{
    $coWorker = CoWorker::find($request->id);

    if (!$coWorker) {
        return response()->json([
            'status' => 'failure',
            'message' => 'Co-worker not found',
        ], 404);
    }

    $coWorker->delete();

    return response()->json([
        'status' => 'Success',
        'message' => 'Co-worker deleted successfully',
    ], 200);
}

public function show($id)
{
    $coWorker = CoWorker::find($id);

    if (!$coWorker) {
        return response()->json([
            'status' => 'failure',
            'message' => 'Co-worker not found',
        ], 404);
    }

    return response()->json([
        'status' => 'Success',
        'message' => 'Co-worker found',
        'data' => $coWorker,
    ], 200);
}


}