<?php

namespace App\Http\Controllers;

use App\Models\CoWorker;
use App\Models\supplierdetails;
use App\Models\CoWorkerDetails;
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
        $coWorkers = CoWorker::orderBy('id','desc')->get();

        if ($coWorkers->isEmpty()) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No co-workers found',
                'data' => [],
            ], 404);
        }


        foreach ($coWorkers as $data) {
            $supplierName = SupplierDetails::where('id', $data->supplier_id)->value('name');
            $data->supplier_name = $supplierName;
            $coWorkerName = CoWorkerDetails::where('id', $data->co_worker_id)->value('name');
            $data->co_worker_name = $coWorkerName;
        }


        return response()->json([
            'status' => 'success',
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
            'co_worker_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'date_and_time' => 'required|date',
            'ns' => 'required|integer',
            'bs' => 'required|integer',
            'bbs' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $coWorker = CoWorker::create($validator->validated());

        return response()->json([
            'status' => 'success',
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
            'co_worker_id' => 'sometimes|required|integer',
            'supplier_id' => 'sometimes|required|integer',
            'date_and_time' => 'sometimes|required|date',
            'ns' => 'sometimes|required|integer',
            'bs' => 'sometimes|required|integer',
            'bbs' => 'sometimes|required|integer',
            'rns' => 'sometimes|required|integer',
            'rbs' => 'sometimes|required|integer',
            'rbbs' => 'sometimes|required|integer',
            'status' => 'sometimes|required|integer', // Changed to sometimes|required
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
            'status' => 'success',
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
            'status' => 'success',
            'message' => 'Co-worker found',
            'data' => $coWorker,
        ], 200);
    }
    public function getFilteredData(Request $request)
    {
        // Retrieve the start and end dates from the request
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $coWorkerId = $request->co_worker_id;

        // Check if both dates are provided
        if (!$startDate || !$endDate) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Both start_date and end_date are required',
            ], 400);
        }

        try {
            // Parse the start and end dates to Carbon objects
            $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
            $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Invalid date format',
            ], 400);
        }
        $coWorkers = [];
        if ($coWorkerId != null) {
            // Query co-workers in the given date range
            $coWorkers = CoWorker::whereBetween('date_and_time', [$startDate, $endDate])->where('co_worker_id', $coWorkerId)->get();
        } else {
            // Query co-workers in the given date range
            $coWorkers = CoWorker::whereBetween('date_and_time', [$startDate, $endDate])->get();
        }
        // Check if co-workers are found
        if ($coWorkers->isEmpty()) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No co-workers found in the specified date range',
                'data' => [],
            ], 404);
        }

        // Add additional information (e.g., supplier_name, co_worker_name)
        foreach ($coWorkers as $data) {
            $supplierName = SupplierDetails::where('id', $data->supplier_id)->value('name');
            $data->supplier_name = $supplierName;
            $coWorkerName = CoWorkerDetails::where('id', $data->co_worker_id)->value('name');
            $data->co_worker_name = $coWorkerName;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Co-workers found within the date range',
            'data' => $coWorkers,
        ], 200);
    }
    public function getSareeCountByDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'co_worker_id' => 'required|integer'
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

        $sums = CoWorker::where('co_worker_id', $request->co_worker_id)
        ->whereBetween('date_and_time', [$request->start_date, $request->end_date])
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



}
