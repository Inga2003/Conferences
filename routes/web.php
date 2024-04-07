<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConferenceController;

// Route for the welcome page
Route::get('/', [ConferenceController::class, 'index']);

// Route to fetch conference description by ID
Route::get('/conference/description/{id}', [ConferenceController::class, 'getDescription']);



