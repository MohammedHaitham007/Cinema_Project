@extends('layouts.app')
@section('title', 'Sign In - Cinema Admin')

@section('content')
<div class="max-w-md mx-auto my-12 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <div class="text-center pb-6 border-b border-slate-100 mb-6">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-3 text-2xl shadow-inner">
            🎬
        </div>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">Sign In</h1>
        <p class="text-xs text-slate-500 mt-1">Enter your credentials to access the admin dashboard.</p>
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">
                Email Address
            </label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   placeholder="admin@cinema.com"
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">
                Password
            </label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required 
                   placeholder="••••••••"
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
        </div>

        <button type="submit" 
                class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium text-sm rounded-lg shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-500/20 mt-2">
            Sign In
        </button>
    </form>

    <div class="text-center mt-6 pt-4 border-t border-slate-100 text-xs text-slate-500">
        Don't have an account? 
        <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Create one</a>
    </div>
</div>
@endsection
