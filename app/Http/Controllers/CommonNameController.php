<?php

namespace App\Http\Controllers;

use App\Models\CommonName;
use App\Models\Source;
use Illuminate\Http\Request;

class CommonNameController extends Controller
{
    public function index()
    {
        $common_names = CommonName::with('source')->get();
        $sources = Source::get();
        return view('dataentry.common-names.index', compact('common_names', 'sources'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'common_name' => 'required|string|max:200',
            'rasayanik_name' => 'nullable|string|max:200',
            'iupac_name' => 'nullable|string|max:200',
            'cas_no' => 'nullable|string|max:100',
            'molecular_formula' => 'nullable|string|max:100',
            'source_id' => 'nullable|integer',
        ]);

        CommonName::create($validated);

        return back()->with('success', 'कमन नाम सफलतापुर्वक थपियो');
    }

    public function edit($common_name)
    {
        $sources = Source::get();

        $commonName = CommonName::findOrFail($common_name);
        return view('dataentry.common-names.edit', compact('commonName', 'sources'));
    }

    public function update(Request $request, $common_name)
    {
        $validated = $request->validate([
            'common_name' => 'required|string|max:200',
            'samanya_naam' => 'nullable|string|max:200',
            'rasayanik_name' => 'nullable|string|max:200',
            'iupac_name' => 'nullable|string|max:200',
            'cas_no' => 'nullable|string|max:100',
            'molecular_formula' => 'nullable|string|max:100',
            'source_id' => 'nullable|integer',
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
