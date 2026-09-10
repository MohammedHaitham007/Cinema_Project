@extends('layouts.app')
@section('title', $movie->title . ' - Cinema Admin')

@section('content')
<!-- Back Link -->
<div class="mb-6">
    <a href="{{ route('movies.index') }}" class="inline-flex items-center space-x-1.5 text-sm font-medium text-slate-600 hover:text-indigo-600 transition">
        <span>←</span>
        <span>Back to Movies</span>
    </a>
</div>

<!-- Movie Details Card -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 sm:p-8">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
        <!-- Poster Image Container -->
        <div class="md:col-span-4 lg:col-span-3">
            <div class="rounded-xl overflow-hidden bg-slate-900 border border-slate-200 shadow-md aspect-[2/3] relative">
                @if($movie->image)
                    <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-indigo-900 via-slate-800 to-slate-950 flex flex-col items-center justify-center text-slate-400">
                        <span class="text-6xl mb-2">🎬</span>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">No Image</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Details Info Column -->
        <div class="md:col-span-8 lg:col-span-9 flex flex-col h-full">
            <div class="pb-6 border-b border-slate-100 mb-6">
                <div class="flex flex-wrap items-center gap-3 mb-3">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $movie->title }}</h1>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    @if($movie->release_year)
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700">
                            Released: {{ $movie->release_year }}
                        </span>
                    @endif

                    @if($movie->rating !== null)
                        <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200">
                            <span>★</span>
                            <span>{{ number_format($movie->rating, 1) }} / 10</span>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8 flex-grow">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Plot Summary</h3>
                <p class="text-slate-700 text-base leading-relaxed whitespace-pre-line">
                    {{ $movie->description ?? 'No detailed description provided for this movie.' }}
                </p>
            </div>

            <!-- Admin Actions Footer -->
            @auth
                <div class="pt-6 border-t border-slate-100 flex items-center justify-between gap-4 flex-wrap mt-auto">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('movies.edit', $movie->id) }}" 
                           class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 font-medium text-sm rounded-lg transition border border-slate-200">
                            Edit Movie
                        </a>

                        <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this movie?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                                Delete Movie
                            </button>
                        </form>
                    </div>

                    <span class="text-xs text-slate-400">Added {{ $movie->created_at?->diffForHumans() }}</span>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
