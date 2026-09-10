<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{

    public function index()
    {
        $movies = Movie::latest()->paginate(9);

        return view('movies.index', compact('movies'));
    }


     function create()
    {
        return view('movies.create');
    }


     function store(CreateMovieRequest $req)
    {
        $data = $req->validated();

        if ($req->hasFile('image')) {
            $data['image'] = $req->file('image')->store('movies', 'public');
        }

        $movie = Movie::create($data);

        return redirect()->route('movies.index')
            ->with('success', 'Movie "' . $movie->title . '" created successfully!');
    }


     function show(Movie $movie)
    {
        return view('movies.show', compact('movie'));
    }


     function edit(Movie $movie)
    {
        return view('movies.edit', compact('movie'));
    }


     function update(UpdateMovieRequest $req, Movie $movie)
{
    $data = $req->validated();

    if ($req->hasFile('image')) {
        if ($movie->image && Storage::disk('public')->exists($movie->image)) {
            Storage::disk('public')->delete($movie->image);
        }
        $data['image'] = $req->file('image')->store('movies', 'public');
    } elseif ($req->boolean('remove_image')) {
        if ($movie->image && Storage::disk('public')->exists($movie->image)) {
            Storage::disk('public')->delete($movie->image);
        }
        $data['image'] = null;
    }

    $movie->update($data);

    return redirect()->route('movies.index')
        ->with('success', 'Movie "' . $movie->title . '" updated successfully!');
}


     function destroy(Movie $movie)
    {
        if ($movie->image && Storage::disk('public')->exists($movie->image)) {
            Storage::disk('public')->delete($movie->image);
        }

        $title = $movie->title;
        $movie->delete();

        return redirect()->route('movies.index')
            ->with('success', 'Movie "' . $title . '" deleted successfully!');
    }
}
