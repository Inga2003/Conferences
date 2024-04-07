<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConferenceController;

// Route for the welcome page
Route::get('/', [ConferenceController::class, 'index'])->name('home');

// Route to fetch conference description by ID
Route::get('/conference/description/{id}', [ConferenceController::class, 'getDescription']);

// Route to show registration form
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// Route to handle registration form submission
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');


