<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\Pest;
use Illuminate\Http\Request;

class PestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pests = Pest::all();
        return view('dataentry.pests.index', compact('pests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dataentry.pests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pest' => 'required|string|max:255|unique:pests,pest',
        ]);

        Pest::create([
            'pest' => $request->pest,
        ]);

        return redirect()->route('pests.index')->with('success', 'कीरा सफलतापूर्वक थपियो!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pest $pest)
    {
        return view('dataentry.pests.show', compact('pest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pest $pest)
    {
        return view('dataentry.pests.edit', compact('pest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pest $pest)
    {
        $request->validate([
            'pest' => 'required|string|max:255|unique:pests,pest,' . $pest->id,
        ]);

        $pest->update([
            'pest' => $request->pest,
        ]);

        return redirect()->route('pests.index')->with('success', 'कीरा सफलतापूर्वक अपडेट भयो!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pest $pest)
    {
        $pest->delete();
        return redirect()->route('pests.index')->with('success', 'कीरा सफलतापूर्वक मेटाइयो!');
    }
}