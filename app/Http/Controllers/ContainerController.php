<?php

namespace App\Http\Controllers;

use App\Models\Container;
use Illuminate\Http\Request;

class ContainerController extends Controller
{
    public function index()
    {
        $containers = Container::all();
        return view('dataentry.containers.index', compact('containers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'container_name' => 'required|string|max:200',
        ]);

        Container::create($validated);

        return back()->with('success', 'कन्टेनर सफलतापुर्वक थपियो');
    }

    public function edit(Container $container)
    {
        return view('dataentry.containers.edit', compact('container'));
    }

    public function update(Request $request, Container $container)
    {
        $validated = $request->validate([
            'container_name' => 'required|string|max:200',
        ]);

        $container->update($validated);

        return redirect()->route('containers.index')
            ->with('success', 'कन्टेनर सफलतापुर्वक अद्यावधिक गरियो');
    }

    public function destroy($container)
    {
        $container = Container::findOrFail($container);
        $container->delete();

        return redirect()->route('containers.index')
            ->with('success', 'कन्टेनर सफलतापुर्वक मेटियो');
    }
}
