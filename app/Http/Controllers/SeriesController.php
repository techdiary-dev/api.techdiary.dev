<?php

namespace App\Http\Controllers;

use App\Http\Requests\Series\SeriesStoreRequest;
use App\Http\Resources\Series\SeriesDetailsResource;
use App\Http\Resources\SeriesResource;
use App\Models\Series;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $series = Series::latest();
        return SeriesResource::collection($series->paginate(request()->query('limit', 10)));
    }

    public function mySeries()
    {
        $series = auth()->user()->series()->latest()->paginate();
        return SeriesResource::collection($series);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SeriesStoreRequest $request)
    {
        return auth()->user()->series()->create([
            'name' => $request->name
        ]);
    }

    /**
     * Display the specified resource.
     * @param Series $series
     * @return SeriesDetailsResource
     */
    public function show(Series $series)
    {
        return new SeriesDetailsResource($series);
    }


    /**
     * Update the specified resource in storage.
     * @param SeriesStoreRequest $request
     * @param Series $series
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(SeriesStoreRequest $request, Series $series)
    {
        $this->authorize('update', $series);
        $series->update($request->all());

        return response()->json([
            'message' => 'Updated successfully',
            'data' => $series
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Series $series)
    {
        $this->authorize('delete', $series);
        $series->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
