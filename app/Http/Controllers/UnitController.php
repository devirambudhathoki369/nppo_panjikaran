<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        return view('dataentry.units.index', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_name' => 'required|string|max:200',
            'unit_type' => 'required|in:formulation,container',

        ]);

        Unit::create($validated);

        return back()->with('success', 'युनिट सफलतापुर्वक थपियो');
    }

    public function edit(Unit $unit)
    {
        return view('dataentry.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'unit_name' => 'required|string|max:200',
            'unit_type' => 'required|in:formulation,container',

        ]);

        $unit->update($validated);

        return redirect()->route('units.index')
            ->with('success', 'युनिट सफलतापुर्वक अद्यावधिक गरियो');
    }

    public function destroy($unit)
    {
        $unit = Unit::findOrFail($unit);
        $unit->delete();

        return redirect()->route('units.index')
            ->with('success', 'युनिट सफलतापुर्वक मेटियो');
    }
}
