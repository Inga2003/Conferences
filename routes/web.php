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

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route to create a new conference
Route::post('/create-conference', [ConferenceController::class, 'create'])->name('conference.create');

Route::delete('/conference/{id}', [ConferenceController::class, 'delete'])->name('conference.delete');

// Route to fetch conference data for editing
Route::get('/conference/{id}/edit', [ConferenceController::class, 'edit'])->name('conference.edit');

Route::put('/conference/{id}', [ConferenceController::class, 'update'])->name('conference.update');


