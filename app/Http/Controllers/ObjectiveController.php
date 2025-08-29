<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objectives = Objective::all();
        return view('dataentry.objectives.index', compact('objectives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dataentry.objectives.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'objective' => 'required|string|max:255|unique:objectives,objective',
        ]);

        Objective::create([
            'objective' => $request->objective,
        ]);

        return redirect()->route('objectives.index')->with('success', 'उद्देश्य सफलतापूर्वक थपियो!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Objective $objective)
    {
        return view('dataentry.objectives.show', compact('objective'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Objective $objective)
    {
        return view('dataentry.objectives.edit', compact('objective'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Objective $objective)
    {
        $request->validate([
            'objective' => 'required|string|max:255|unique:objectives,objective,' . $objective->id,
        ]);

        $objective->update([
            'objective' => $request->objective,
        ]);

        return redirect()->route('objectives.index')->with('success', 'उद्देश्य सफलतापूर्वक अपडेट भयो!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Objective $objective)
    {
        $objective->delete();
        return redirect()->route('objectives.index')->with('success', 'उद्देश्य सफलतापूर्वक मेटाइयो!');
    }
}