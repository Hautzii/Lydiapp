<?php

namespace App\Http\Controllers;

use App\Models\formation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormationController extends Controller
{
    public function index(Request $request)
{
    $search = $request->query('search');
    $formations = Formation::where('name', 'like', "%{$search}%")->orderBy('name')->get();

    return view('formations.index', compact('formations'));
}

    public function store(Request $request): RedirectResponse {
        $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        Formation::create([
            'name' => $request->input('name'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date')
        ]);

        return redirect()->route('formations.index')->with('success', 'formation created successfully');
    }

    public function create(): View {
        $formations = Formation::all();
        return view('formations.create', ['formations' => $formations]);
    }

    public function update(Request $request, $id): RedirectResponse {
        $request->validate([
            'name' => 'string',
            'start_date' => 'date',
            'end_date' => 'date'
        ]);

        $formation = Formation::find($id);

        $formation->update([
            'name' => $request->input('name'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date')
        ]);

        return redirect()->route('formations.index')->with('success', 'formation edited successfully');
    }

    public function destroy($id): RedirectResponse {
        $formation = Formation::find($id);
        $formation->delete();
        return redirect()->route('formations.index')->with('success', 'formation deleted successfully');
    }

    public function edit($id): View {
        $formation = Formation::find($id);
        return view('formations.edit', compact('formation'));
    }
}
