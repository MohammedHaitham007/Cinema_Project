<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Models\Movie;

class MovieController extends Controller
{

    public function index()
    {
        $movies = Movie::get();

        return response()->json([
            'message' => 'Movies retrieved successfully',
            'data' => MovieResource::collection($movies),
        ], 200);
    }

    public function show($id)
    {
        $movie = Movie::find($id);

        if (! $movie) {
            return response()->json([
                'message' => 'Movie not found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'message' => 'Movie details retrieved successfully',
            'data' => new MovieResource($movie),
        ], 200);
    }
}
