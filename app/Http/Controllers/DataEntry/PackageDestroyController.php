<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\PackageDestroy;
use Illuminate\Http\Request;

class PackageDestroyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packagedestroys = PackageDestroy::all();
        return view('dataentry.packagedestroys.index', compact('packagedestroys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dataentry.packagedestroys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'packagedestroy_name' => 'required|string|max:255|unique:package_destroys,packagedestroy_name',
        ]);

        PackageDestroy::create([
            'packagedestroy_name' => $request->packagedestroy_name,
        ]);

        return redirect()->route('packagedestroys.index')->with('success', 'प्याकेज नष्ट विधि सफलतापूर्वक थपियो!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PackageDestroy $packagedestroy)
    {
        return view('dataentry.packagedestroys.show', compact('packagedestroy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageDestroy $packagedestroy)
    {
        return view('dataentry.packagedestroys.edit', compact('packagedestroy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PackageDestroy $packagedestroy)
    {
        $request->validate([
            'packagedestroy_name' => 'required|string|max:255|unique:package_destroys,packagedestroy_name,' . $packagedestroy->id,
        ]);

        $packagedestroy->update([
            'packagedestroy_name' => $request->packagedestroy_name,
        ]);

        return redirect()->route('packagedestroys.index')->with('success', 'प्याकेज नष्ट विधि सफलतापूर्वक अपडेट भयो!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageDestroy $packagedestroy)
    {
        $packagedestroy->delete();
        return redirect()->route('packagedestroys.index')->with('success', 'प्याकेज नष्ट विधि सफलतापूर्वक मेटाइयो!');
    }
}