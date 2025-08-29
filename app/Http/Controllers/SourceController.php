<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sources = Source::all();
        return view('dataentry.sources.index', compact('sources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dataentry.sources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sourcename' => 'required|string|max:255|unique:sources,sourcename',
        ]);

        Source::create([
            'sourcename' => $request->sourcename,
        ]);

        return redirect()->route('sources.index')->with('success', 'स्रोत सफलतापूर्वक थपियो!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source)
    {
        return view('dataentry.sources.show', compact('source'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Source $source)
    {
        return view('dataentry.sources.edit', compact('source'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Source $source)
    {
        $request->validate([
            'sourcename' => 'required|string|max:255|unique:sources,sourcename,' . $source->id,
        ]);

        $source->update([
            'sourcename' => $request->sourcename,
        ]);

        return redirect()->route('sources.index')->with('success', 'स्रोत सफलतापूर्वक अपडेट भयो!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Source $source)
    {
        $source->delete();
        return redirect()->route('sources.index')->with('success', 'स्रोत सफलतापूर्वक मेटाइयो!');
    }
}
