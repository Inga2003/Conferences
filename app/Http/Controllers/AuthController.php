<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

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

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                // Update the user's role to "admin"
                $user->update(['role' => 'admin']);
            }

            // Set a session cookie manually
            $minutes = 60 * 24 * 30; // 30 days
            $response = redirect()->route('home');
            $response->cookie('user_id', $user->id, $minutes);

            return $response;
        }

        // If authentication fails, redirect back with error message
        return redirect()->back()->withErrors(['error' => 'Invalid email or password.']);
    }

    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->role = 'guest';
            $user->save();
            Auth::logout();
        }

        return redirect('/');
    }
}
