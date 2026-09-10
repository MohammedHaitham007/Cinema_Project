@extends('layouts.app')
@section('title', 'Add New Movie - Cinema Admin')

@section('content')
<!-- Back Link -->
<div class="mb-6">
    <a href="{{ route('movies.index') }}" class="inline-flex items-center space-x-1.5 text-sm font-medium text-slate-600 hover:text-indigo-600 transition">
        <span>←</span>
        <span>Back to Movies</span>
    </a>
</div>

<!-- Card Form Container -->
<div class="max-w-xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <div class="pb-6 border-b border-slate-100 mb-6">
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Add New Movie</h1>
        <p class="text-xs text-slate-500 mt-1">Fill out the details below to add a movie to the database.</p>
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <div class="font-semibold mb-1">Please fix the following issues:</div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('movies.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Movie Title -->
        <div>
            <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">
                Movie Title <span class="text-rose-500">*</span>
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="{{ old('title') }}" 
                   required 
                   placeholder="e.g. Inception"
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">
                Description / Synopsis
            </label>
            <textarea id="description" 
                      name="description" 
                      rows="4" 
                      placeholder="Short plot summary..."
                      class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition resize-none">{{ old('description') }}</textarea>
        </div>

        <!-- Release Year & Rating Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Release Year -->
            <div>
                <label for="release_year" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">
                    Release Year
                </label>
                <input type="number" 
                       id="release_year" 
                       name="release_year" 
                       min="1888" 
                       max="2100" 
                       value="{{ old('release_year') }}" 
                       placeholder="e.g. 2024"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
            </div>

            <!-- Rating -->
            <div>
                <label for="rating" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">
                    Rating (0.0 - 10.0)
                </label>
                <input type="number" 
                       id="rating" 
                       name="rating" 
                       min="0" 
                       max="10" 
                       step="0.1" 
                       value="{{ old('rating') }}" 
                       placeholder="e.g. 8.5"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
            </div>
        </div>

        <!-- Image Upload Field with Live Preview -->
        <div>
            <label for="image" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">
                Poster Image (Max 2MB)
            </label>
            
            <input type="file" 
                   id="image" 
                   name="image" 
                   accept="image/jpeg,image/png,image/jpg,image/webp"
                   onchange="previewSelectedImage(this)"
                   class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">

            <!-- Live Image Preview Container -->
            <div id="image-preview-container" class="mt-3 hidden">
                <span class="text-xs text-slate-500 block mb-1">Image Preview:</span>
                <img id="image-preview" src="#" alt="Selected Poster Preview" class="h-40 rounded-lg border border-slate-200 object-cover shadow-sm">
            </div>
        </div>

        <!-- Form Actions -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
            <a href="{{ route('movies.index') }}" 
               class="px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                Cancel
            </a>
            <button type="submit" 
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium text-sm rounded-lg shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                Save Movie
            </button>
        </div>
    </form>
</div>

<!-- JS Script for Live Image Preview -->
<script>
    function previewSelectedImage(input) {
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewImage.src = '#';
            previewContainer.classList.add('hidden');
        }
    }
</script>
@endsection
