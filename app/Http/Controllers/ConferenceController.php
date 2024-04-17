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

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $conference = Conference::create([
            'name' => $request->name,
            'date' => $request->date,
            'address' => $request->address,
            'description' => $request->description,
        ]);
        return redirect()->route('home')->with('success', 'Conference created successfully!');
    }

    public function delete($id)
    {
        $conference = Conference::findOrFail($id);
        $conference->delete();
        return redirect()->route('home')->with('success', 'Conference deleted successfully!');
    }

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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $conference = Conference::findOrFail($id);

        $conference->update([
            'name' => $request->name,
            'date' => $request->date,
            'address' => $request->address,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Conference updated successfully']);
    }
}
