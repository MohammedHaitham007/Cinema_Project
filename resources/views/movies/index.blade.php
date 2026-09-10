@extends('layouts.app')
@section('title', 'Movies Collection - Cinema Admin')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-slate-200 mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Movies Collection</h1>
        <p class="text-sm text-slate-500 mt-1">Manage cinema movies for the admin dashboard and public mobile API.</p>
    </div>
    @auth
        <a href="{{ route('movies.create') }}" 
           class="inline-flex items-center justify-center space-x-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium text-sm rounded-lg shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Add New Movie</span>
        </a>
    @endauth
</div>

@if($movies->count())
    <!-- Movies Responsive Card Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($movies as $movie)
            <div class="bg-white rounded-xl border border-slate-200/90 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col overflow-hidden group">
                <!-- Poster Banner Image or Fallback -->
                <div class="relative h-60 w-full bg-slate-900 overflow-hidden">
                    @if($movie->image)
                        <img src="{{ asset('storage/' . $movie->image) }}" 
                             alt="{{ $movie->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-900 via-slate-800 to-slate-950 flex flex-col items-center justify-center text-slate-400">
                            <span class="text-5xl mb-1">🎬</span>
                            <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">No Image</span>
                        </div>
                    @endif

                    <!-- Rating Badge Overlay -->
                    @if($movie->rating !== null)
                        <div class="absolute top-3 right-3 bg-amber-400/95 backdrop-blur-sm text-slate-950 px-2.5 py-1 rounded-full text-xs font-bold shadow-md flex items-center space-x-1">
                            <span>★</span>
                            <span>{{ number_format($movie->rating, 1) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Card Body -->
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <h2 class="font-bold text-lg text-slate-900 group-hover:text-indigo-600 transition line-clamp-1">
                            <a href="{{ route('movies.show', $movie->id) }}">{{ $movie->title }}</a>
                        </h2>
                        @if($movie->release_year)
                            <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md flex-shrink-0">
                                {{ $movie->release_year }}
                            </span>
                        @endif
                    </div>

                    <p class="text-slate-600 text-sm line-clamp-2 mb-4 leading-relaxed">
                        {{ $movie->description ?? 'No summary provided for this movie.' }}
                    </p>

                    <!-- Card Footer Actions -->
                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                        <a href="{{ route('movies.show', $movie->id) }}" 
                           class="text-xs font-semibold text-slate-700 hover:text-indigo-600 py-1.5 px-3 rounded-md hover:bg-slate-100 transition">
                            View Details →
                        </a>

                        @auth
                            <div class="flex items-center space-x-1.5">
                                <a href="{{ route('movies.edit', $movie->id) }}" 
                                   class="px-2.5 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-indigo-600 transition">
                                    Edit
                                </a>

                                <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this movie?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-2.5 py-1.5 text-xs font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if(method_exists($movies, 'links'))
        <div class="mt-8">
            {{ $movies->links() }}
        </div>
    @endif

@else
    <!-- Empty State -->
    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center max-w-md mx-auto my-12 shadow-sm">
        <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner">
            🎬
        </div>
        <h3 class="text-lg font-bold text-slate-900 mb-1">No movies yet</h3>
        <p class="text-slate-500 text-sm mb-6 leading-relaxed">Start building your cinema collection by adding your first movie.</p>
        @auth
            <a href="{{ route('movies.create') }}" 
               class="inline-flex items-center justify-center space-x-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                <span>+ Add First Movie</span>
            </a>
        @endauth
    </div>
@endif
@endsection
