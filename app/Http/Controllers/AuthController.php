<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password for security
        ]);

        return redirect('/');
    }

    // Method to handle login form submission
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user is an admin
            if ($user->role !== 'admin') {
                // Update the user's role to "admin"
                $user->update(['role' => 'admin']);
            }

            return redirect()->route('home');
        }

        // If authentication fails, redirect back with error message
        return redirect()->back()->withErrors(['error' => 'Invalid email or password.']);
    }

    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->role = 'guest'; // Update the user's role to "guest"
            $user->save(); // Save the changes
            Auth::logout(); // Log the user out
        }

        return redirect('/'); // Redirect the user to the welcome page
    }
}
