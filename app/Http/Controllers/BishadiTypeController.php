<?php

namespace App\Http\Controllers;

use App\Models\BishadiType;
use Illuminate\Http\Request;

class BishadiTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bishadiTypes = BishadiType::orderBy('id', 'desc')->get();
        return view('bishadi-types.index', compact('bishadiTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bishadi-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prakar' => 'required|string|max:255',
            'type_code' => 'required|string|max:50|unique:bishadi_types,type_code'
        ]);

        BishadiType::create([
            'prakar' => $request->prakar,
            'type_code' => $request->type_code
        ]);

        return redirect()->route('bishadi-types.index')
            ->with('success', 'बिषादिको प्रकार सफलतापूर्वक थपियो!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BishadiType $bishadiType)
    {
        return view('bishadi-types.show', compact('bishadiType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BishadiType $bishadiType)
    {
        return view('bishadi-types.edit', compact('bishadiType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BishadiType $bishadiType)
    {
        $request->validate([
            'prakar' => 'required|string|max:255',
            'type_code' => 'required|string|max:50|unique:bishadi_types,type_code,' . $bishadiType->id
        ]);

        $bishadiType->update([
            'prakar' => $request->prakar,
            'type_code' => $request->type_code
        ]);

        return redirect()->route('bishadi-types.index')
            ->with('success', 'बिषादिको प्रकार सफलतापूर्वक अपडेट भयो!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BishadiType $bishadiType)
    {
        $bishadiType->delete();

        return redirect()->route('bishadi-types.index')
            ->with('success', 'बिषादिको प्रकार सफलतापूर्वक मेटाइयो!');
    }
}
