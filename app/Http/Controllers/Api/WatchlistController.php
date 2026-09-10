<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWatchlistRequest;
use App\Http\Resources\MovieResource;
use App\Http\Resources\WatchlistResource;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{

    function index(Request $req)
    {
        $deviceId = $req->query('device_id');

        if (! $deviceId) {
            return response()->json([
                'message' => 'The device_id query parameter is required.',
                'errors' => [
                    'device_id' => ['The device_id query parameter is required.'],
                ],
            ], 422);
        }

        $watchlists = Watchlist::where('device_id', $deviceId)
            ->with('movie')
            ->get();

        $movies = $watchlists->pluck('movie')->filter()->values();

        return response()->json([
            'message' => 'Watchlist movies retrieved successfully',
            'data' => MovieResource::collection($movies),
        ], 200);
    }


    function store(StoreWatchlistRequest $req)
    {
        $data = $req->validated();

        $watchlist = Watchlist::where('device_id', $data['device_id'])
            ->where('movie_id', $data['movie_id'])
            ->first();

        if ($watchlist) {
            $watchlist->load('movie');

            return response()->json([
                'message' => 'Movie is already in watchlist',
                'data' => new WatchlistResource($watchlist),
            ], 200);
        }

        $watchlist = Watchlist::create([
            'device_id' => $data['device_id'],
            'movie_id' => $data['movie_id'],
        ]);

        $watchlist->load('movie');

        return response()->json([
            'message' => 'Movie added to watchlist successfully',
            'data' => new WatchlistResource($watchlist),
        ], 201);
    }


    function destroy($id, Request $req)
    {
        $deviceId = $req->input('device_id') ?? $req->query('device_id');

        $query = Watchlist::query();

        if ($deviceId) {
            $query->where('device_id', $deviceId)
                ->where(function ($q) use ($id) {
                    $q->where('id', $id)
                        ->orWhere('movie_id', $id);
                });
        } else {
            $query->where('id', $id);
        }

        $watchlist = $query->first();

        if (! $watchlist) {
            return response()->json([
                'message' => 'Watchlist item not found',
                'data' => null,
            ], 404);
        }

        $watchlist->delete();

        return response()->json([
            'message' => 'Movie removed from watchlist successfully',
            'data' => null,
        ], 200);
    }
}
