<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Formation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternController extends Controller
{
    // This function is used to display the list of interns
    public function index(Request $request): View
    {
        // Get the search query and favorites flag from the request
        $search = $request->query('search');
        $favorites = $request->query('favorites', 0);

        // If favorites flag is set, get the favorite interns of the authenticated user
        if ($favorites) {
            $interns = auth()->user()->favoriteInterns()
                ->with('formation')
                ->orderBy('last_name')
                ->get()
                ->groupBy('formation.name');
        }
        // If search query is set, search the interns based on the query
        else if ($search) {
            $interns = Intern::with('formation')
                ->where('last_name', 'like', '%' . $search . '%')
                ->orWhere('first_name', 'like', '%' . $search . '%')
                ->orWhereHas('formation', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orderBy('last_name')
                ->get()
                ->groupBy('formation.name');
        }
        // If neither is set, get all interns ordered by formation name and last name
        else {
            $interns = Intern::join('formations', 'formations.id', '=', 'interns.formation_id')
                ->select('interns.*')
                ->with('formation')
                ->orderBy('formations.name')
                ->orderBy('last_name')
                ->get()
                ->groupBy('formation.name');
        }

        // Return the view with the list of interns
        return view('interns.index', compact('interns'));
    }

    // This function is used to store a new intern
    public function store(Request $request): RedirectResponse {
        // Validate the request data
        $request->validate([
            'profile_picture' => 'image',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'formation_id' => 'required|exists:formations,id'
        ]);

        // Create a new intern with the request data
        $intern = new Intern($request->except('first_name', 'last_name', 'profile_picture', 'formation_id'));
        $intern->first_name = ucfirst(strtolower($request->input('first_name')));
        $intern->last_name = strtoupper($request->input('last_name'));
        $intern->formation_id = $request->input('formation_id');

        // If a profile picture is uploaded, store it and set the filename in the intern object
        if($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $intern->profile_picture = $filename;
        }

        // Save the intern object
        $intern->save();

        // Redirect back to the list of interns with a success message
        return redirect()->route('interns.index')->with('success', 'Intern created successfully');
    }

    // This function is used to update an existing intern
    public function update(Request $request, $id): RedirectResponse {
        // Validate the request data
        $request->validate([
            'profile_picture' => 'image',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'formation_id' => 'required|exists:formations,id'
        ]);

        // Find the intern by its ID
        $intern = Intern::find($id);

        // If a new profile picture is uploaded, store it and set the filename in the intern object
        if($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $intern->profile_picture = $filename;
        }

        // Update the intern with the request data
        $intern->first_name = ucfirst($request->first_name);
        $intern->last_name = strtoupper($request->last_name);
        $intern->phone_number = $request->phone_number;
        $intern->email = $request->email;
        $intern->formation_id = $request->formation_id;

        // Save the intern object
        $intern->save();

        // Redirect back to the list of interns with a success message
        return redirect()->route('interns.index')->with('success', 'Intern updated successfully');
    }

    // This function is used to delete an intern
    public function destroy($id): RedirectResponse {
        // Find the intern by its ID
        $intern = Intern::find($id);
        // Delete the intern
        $intern->delete();
        // Redirect back to the list of interns with a success message
        return redirect()->route('interns.index')->with('success', 'Intern deleted successfully');
    }

    // This function is used to display the form for creating a new intern
    public function create(): View {
        // Get all formations
        $formations = Formation::all();
        // Return the view with the list of formations
        return view('interns.create', ['formations' => $formations]);
    }

    // This function is used to display an intern
    public function show($id): View {
        // Find the intern by its ID
        $intern = Intern::find($id);
        // Return the view with the intern data
        return view('interns.show', compact('intern'));
    }

    // This function is used to display the form for editing an intern
    public function edit($id): View {
        // Find the intern by its ID
        $intern = Intern::find($id);
        // Get all formations
        $formations = Formation::all();
        // Return the view with the intern and formations data
        return view('interns.edit', compact('intern', 'formations'));
    }

    // This function is used to add an intern to the favorites of the authenticated user
    public function favorite(Intern $intern): RedirectResponse
    {
        auth()->user()->favoriteInterns()->attach($intern);

        return back();
    }

    // This function is used to remove an intern from the favorites of the authenticated user
    public function unfavorite(Intern $intern): RedirectResponse
    {
        auth()->user()->favoriteInterns()->detach($intern);

        return back();
    }

    // This function is used to display the favorite interns of the authenticated user
    public function favorites(): View
    {
        $interns = auth()->user()->favoriteInterns()
            ->with('formation')
            ->orderBy('last_name')
            ->get()
            ->groupBy('formation.name');

        return view('interns.index', compact('interns'));
    }

    // This function is used to toggle the favorites flag in the session
    public function toggleFavorites(Request $request): RedirectResponse
    {
        $favorites = $request->session()->get('favorites', 0);
        $request->session()->put('favorites', $favorites ? 0 : 1);

        return redirect()->route('interns.index');
    }
}
