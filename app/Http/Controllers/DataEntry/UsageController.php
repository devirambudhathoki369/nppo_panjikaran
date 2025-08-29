<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\Usage;
use Illuminate\Http\Request;

class UsageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usages = Usage::all();
        return view('dataentry.usages.index', compact('usages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dataentry.usages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usage_name' => 'required|string|max:255|unique:usages,usage_name',
        ]);

        Usage::create([
            'usage_name' => $request->usage_name,
        ]);

        return redirect()->route('usages.index')->with('success', 'उपयोग सफलतापूर्वक थपियो!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Usage $usage)
    {
        return view('dataentry.usages.show', compact('usage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usage $usage)
    {
        return view('dataentry.usages.edit', compact('usage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usage $usage)
    {
        $request->validate([
            'usage_name' => 'required|string|max:255|unique:usages,usage_name,' . $usage->id,
        ]);

        $usage->update([
            'usage_name' => $request->usage_name,
        ]);

        return redirect()->route('usages.index')->with('success', 'उपयोग सफलतापूर्वक अपडेट भयो!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usage $usage)
    {
        $usage->delete();
        return redirect()->route('usages.index')->with('success', 'उपयोग सफलतापूर्वक मेटाइयो!');
    }
}