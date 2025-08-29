<?php

namespace App\Http\Controllers;

use App\Models\Formulation;
use Illuminate\Http\Request;

class FormulationController extends Controller
{
    public function index()
    {
        $formulations = Formulation::all();
        return view('dataentry.formulations.index', compact('formulations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'formulation_name' => 'required|string|max:200',
        ]);

        Formulation::create($validated);

        return back()->with('success', 'फर्मुलेसन विवरण सफलतापुर्वक थपियो');
    }

    public function edit($formulation_name)
    {
        $formulation = Formulation::findOrFail($formulation_name);
        return view('dataentry.formulations.edit', compact('formulation'));
    }

    public function update(Request $request, $formulation_name)
    {
        $validated = $request->validate([
            'formulation_name' => 'required|string|max:200',
        ]);
        $formulation = Formulation::findOrFail($formulation_name);

        $formulation->update($validated);

        return redirect()->route('formulations.index')
            ->with('success', 'फर्मुलेसन विवरण सफलतापुर्वक अद्यावधिक गरियो');
    }

    public function destroy($formulation_name)
    {
        $formulation_name = Formulation::findOrFail($formulation_name);
        $formulation_name->delete();

        return redirect()->route('formulations.index')
            ->with('success', 'फर्मुलेसन विवरण सफलतापुर्वक मेटियो');
    }
}
