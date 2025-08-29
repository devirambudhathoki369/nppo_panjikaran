<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use Illuminate\Http\Request;

class CropController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crops = Crop::all();
        return view('dataentry.crops.index', compact('crops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dataentry.crops.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'crop_name' => 'required|string|max:255|unique:crops,crop_name',
        ]);

        Crop::create([
            'crop_name' => $request->crop_name,
        ]);

        return redirect()->route('crops.index')->with('success', 'बाली सफलतापूर्वक थपियो!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Crop $crop)
    {
        return view('dataentry.crops.show', compact('crop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crop $crop)
    {
        return view('dataentry.crops.edit', compact('crop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Crop $crop)
    {
        $request->validate([
            'crop_name' => 'required|string|max:255|unique:crops,crop_name,' . $crop->id,
        ]);

        $crop->update([
            'crop_name' => $request->crop_name,
        ]);

        return redirect()->route('crops.index')->with('success', 'बाली सफलतापूर्वक अपडेट भयो!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crop $crop)
    {
        $crop->delete();
        return redirect()->route('crops.index')->with('success', 'बाली सफलतापूर्वक मेटाइयो!');
    }
}