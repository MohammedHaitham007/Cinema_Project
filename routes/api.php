<?php

use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\WatchlistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotController;



    Route::get('/movies', [MovieController::class, 'index']);
    Route::get('/movies/{id}', [MovieController::class, 'show']);

    Route::get('/watchlist', [WatchlistController::class, 'index']);
    Route::post('/watchlist', [WatchlistController::class, 'store']);
    Route::delete('/watchlist/{id}', [WatchlistController::class, 'destroy']);
    
    Route::post('/chatbot/send', [ChatbotController::class, 'send']);
