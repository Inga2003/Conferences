<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function showLoginForm()
    {
        return view('login');
    }

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
            'password' => Hash::make($request->password),
        ]);

        return redirect('/');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                $user->update(['role' => 'admin']);
            }

            // Set a session cookie
            $minutes = 60 * 24 * 30; // 30 days
            $response = redirect()->route('home');
            $response->cookie('user_id', $user->id, $minutes);

            return $response;
        }
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
