<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::all();
        return view('welcome', compact('conferences'));
    }

// app/Http/Controllers/ConferenceController.php
    public function getDescription($id)
    {
        $conference = Conference::findOrFail($id);
        return response()->json([
            'name' => $conference->name,
            'date' => $conference->date,
            'address' => $conference->address,
            'description' => $conference->description
        ]);
    }
}
