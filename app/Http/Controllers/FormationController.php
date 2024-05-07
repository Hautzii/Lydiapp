<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormationController extends Controller
{
    // This function is used to display the list of formations
    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->query('search');
        // Search the formations based on the search query
        $formations = Formation::where('name', 'like', "%{$search}%")->orderBy('name')->get();

        // Return the view with the list of formations
        return view('formations.index', compact('formations'));
    }

    // This function is used to store a new formation
    public function store(Request $request): RedirectResponse {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        // Create a new formation with the request data
        Formation::create([
            'name' => $request->input('name'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date')
        ]);

        // Redirect back to the list of formations with a success message
        return redirect()->route('formations.index')->with('success', 'formation created successfully');
    }

    // This function is used to display the form for creating a new formation
    public function create(): View {
        // Get all formations
        $formations = Formation::all();
        // Return the view with the list of formations
        return view('formations.create', ['formations' => $formations]);
    }

    // This function is used to update an existing formation
    public function update(Request $request, $id): RedirectResponse {
        // Validate the request data
        $request->validate([
            'name' => 'string',
            'start_date' => 'date',
            'end_date' => 'date'
        ]);

        // Find the formation by its ID
        $formation = Formation::find($id);

        // Update the formation with the request data
        $formation->update([
            'name' => $request->input('name'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date')
        ]);

        // Redirect back to the list of formations with a success message
        return redirect()->route('formations.index')->with('success', 'formation edited successfully');
    }

    // This function is used to delete a formation
    public function destroy($id): RedirectResponse {
        // Find the formation by its ID
        $formation = Formation::find($id);
        // Delete the formation
        $formation->delete();
        // Redirect back to the list of formations with a success message
        return redirect()->route('formations.index')->with('success', 'formation deleted successfully');
    }

    // This function is used to display the form for editing a formation
    public function edit($id): View {
        // Find the formation by its ID
        $formation = Formation::find($id);
        // Return the view with the formation data
        return view('formations.edit', compact('formation'));
    }
}
