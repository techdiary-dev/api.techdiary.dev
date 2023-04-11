<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\TagCreateRequest;
use App\Http\Resources\Tag\TagDetails;
use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TagResource::collection(Tag::latest()->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TagCreateRequest $request)
    {
        $data = Tag::create($request->all());

        return response()->json([
            'message' => 'Successfully new tag created',
            'data' => new TagResource($data),
        ]);
    }

    public function show(Tag $tag)
    {
        return new TagDetails($tag);
    }
}
