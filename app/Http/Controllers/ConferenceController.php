<?php
namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    // Method to fetch all conferences
    public function index()
    {
        $conferences = Conference::all();
        return view('welcome', compact('conferences'));
    }

    // Method to fetch conference description by ID
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

    // Method to create a new conference
    public function create(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Create the conference
        $conference = Conference::create([
            'name' => $request->name,
            'date' => $request->date,
            'address' => $request->address,
            'description' => $request->description,
        ]);
        return redirect()->route('home')->with('success', 'Conference created successfully!');
    }

    // Method to delete a conference
    public function delete($id)
    {
        $conference = Conference::findOrFail($id);
        $conference->delete();
        return redirect()->route('home')->with('success', 'Conference deleted successfully!');
    }

    // Method to fetch conference data for editing
    public function edit($id)
    {
        $conference = Conference::findOrFail($id);
        return response()->json([
            'name' => $conference->name,
            'date' => $conference->date,
            'address' => $conference->address,
            'description' => $conference->description
        ]);
    }

    // Method to update a conference
    public function update(Request $request, $id)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Find the conference by ID
        $conference = Conference::findOrFail($id);

        // Update the conference data
        $conference->update([
            'name' => $request->name,
            'date' => $request->date,
            'address' => $request->address,
            'description' => $request->description,
        ]);

        // Return JSON response indicating success
        return response()->json(['message' => 'Conference updated successfully']);
    }
}
