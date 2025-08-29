<?php

namespace App\Http\Controllers;

use App\Models\CommonName;
use Illuminate\Http\Request;

class CommonNameController extends Controller
{
    public function index()
    {
        $common_names = CommonName::all();
        return view('dataentry.common-names.index', compact('common_names'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'common_name' => 'required|string|max:200',
        ]);

        CommonName::create($validated);

        return back()->with('success', 'कमन नाम सफलतापुर्वक थपियो');
    }

    public function edit($common_name)
    {
        $commonName = CommonName::findOrFail($common_name);
        return view('dataentry.common-names.edit', compact('commonName'));
    }

    public function update(Request $request, $common_name)
    {
        $validated = $request->validate([
            'common_name' => 'required|string|max:200',
        ]);
        $commonName = CommonName::findOrFail($common_name);

        $commonName->update($validated);

        return redirect()->route('common-names.index')
            ->with('success', 'कमन नाम सफलतापुर्वक अद्यावधिक गरियो');
    }

    public function destroy($common_name)
    {
        $common_name = CommonName::findOrFail($common_name);
        $common_name->delete();

        return redirect()->route('common-names.index')
            ->with('success', 'कमन नाम सफलतापुर्वक मेटियो');
    }
}
