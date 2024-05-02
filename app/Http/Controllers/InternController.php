<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Formation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternController extends Controller
{

    public function index(Request $request): View
{
    $search = $request->query('search');
    $favorites = $request->query('favorites', 0);

    if ($favorites) {
        $interns = auth()->user()->favoriteInterns()
            ->with('formation')
            ->orderBy('last_name')
            ->get()
            ->groupBy('formation.name');
    } else if ($search) {
            $interns = Intern::with('formation')
                ->where('last_name', 'like', '%' . $search . '%')
                ->orWhere('first_name', 'like', '%' . $search . '%')
                ->orWhereHas('formation', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orderBy('last_name')
                ->get()
                ->groupBy('formation.name');
        } else {
            $interns = Intern::join('formations', 'formations.id', '=', 'interns.formation_id')
                ->select('interns.*')
                ->with('formation')
                ->orderBy('formations.name')
                ->orderBy('last_name')
                ->get()
                ->groupBy('formation.name');
        }

        return view('interns.index', compact('interns'));
    }

    public function store(Request $request): RedirectResponse {
        $request->validate([
            'profile_picture' => 'image',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'formation_id' => 'required|exists:formations,id'
        ]);

        if($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);

            $intern = new Intern($request->except('first_name', 'last_name', 'profile_picture', 'formation_id'));
            $intern->profile_picture = $filename;
            $intern->first_name = ucfirst($request->input('first_name'));
            $intern->last_name = strtoupper($request->input('last_name'));
            $intern->formation_id = $request->input('formation_id');
            $intern->save();
        }

        return redirect()->route('interns.index')->with('success', 'Intern created successfully');
    }

    public function update(Request $request, $id): RedirectResponse {
        $request->validate([
            'profile_picture' => 'image',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'formation_id' => 'required|exists:formations,id'
        ]);

        $intern = Intern::find($id);

        if($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $intern->profile_picture = $filename;
        }

        $intern->first_name = ucfirst($request->first_name);
        $intern->last_name = strtoupper($request->last_name);
        $intern->phone_number = $request->phone_number;
        $intern->email = $request->email;
        $intern->formation_id = $request->formation_id;

        $intern->save();

        return redirect()->route('interns.index')->with('success', 'Intern updated successfully');
    }

    public function destroy($id): RedirectResponse {
        $intern = Intern::find($id);
        $intern->delete();
        return redirect()->route('interns.index')->with('success', 'Intern deleted successfully');
    }

    public function create(): View {
        $formations = Formation::all();
        return view('interns.create', ['formations' => $formations]);
    }

    public function show($id): View {
        $intern = Intern::find($id);
        return view('interns.show', compact('intern'));
    }

    public function edit($id): View {
        $intern = Intern::find($id);
        $formations = Formation::all();
        return view('interns.edit', compact('intern', 'formations'));
    }

    public function favorite(Intern $intern): RedirectResponse
    {
    auth()->user()->favoriteInterns()->attach($intern);

    return back();
}

public function unfavorite(Intern $intern): RedirectResponse
{
    auth()->user()->favoriteInterns()->detach($intern);

    return back();
}

public function favorites(): View
{
    $interns = auth()->user()->favoriteInterns()
        ->with('formation')
        ->orderBy('last_name')
        ->get()
        ->groupBy('formation.name');

    return view('interns.index', compact('interns'));
}

public function toggleFavorites(Request $request): RedirectResponse
{
    $favorites = $request->session()->get('favorites', 0);
    $request->session()->put('favorites', $favorites ? 0 : 1);

    return redirect()->route('interns.index');
}

}
