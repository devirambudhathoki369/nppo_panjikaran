<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('dataentry.countries.index', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_name' => 'required|string|max:200',
        ]);

        Country::create($validated);

        return back()->with('success', 'देशको नाम सफलतापुर्वक थपियो');
    }

    public function edit(Country $country)
    {
        return view('dataentry.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'country_name' => 'required|string|max:200',
        ]);

        $country->update($validated);

        return redirect()->route('countries.index')
            ->with('success', 'देशको नाम सफलतापुर्वक अद्यावधिक गरियो');
    }

    public function destroy($country)
    {
        $country = Country::findOrFail($country);
        $country->delete();

        return redirect()->route('countries.index')
            ->with('success', 'देशको नाम सफलतापुर्वक मेटियो');
    }
}
