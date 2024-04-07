<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Method to show registration form
    public function showRegistrationForm()
    {
        return view('register');
    }

    // Method to show login form
    public function showLoginForm()
    {
        return view('login');
    }
    // Method to handle registration form submission
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed', // Ensure password matches password_confirmation
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password for security
        ]);

        // Optionally, you may want to log in the user automatically after registration
        // Auth::login($user);

        // Redirect the user to a success page or any other page
        return redirect('/');
    }
}
