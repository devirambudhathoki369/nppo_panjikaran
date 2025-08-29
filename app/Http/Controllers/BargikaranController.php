<?php

// BargikaranController.php
namespace App\Http\Controllers;

use App\Models\Bargikaran;
use App\Models\Panjikaran;
use App\Models\Checklist;
use Illuminate\Http\Request;

class BargikaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $panjikaranId = $request->get('panjikaran_id');
        $panjikaran = null;

        if ($panjikaranId) {
            $panjikaran = Panjikaran::with('checklist')->findOrFail($panjikaranId);
            $bargikarans = Bargikaran::with(['checklist', 'panjikaran'])
                                    ->where('panjikaran_id', $panjikaranId)
                                    ->latest()
                                    ->get();
        } else {
            $bargikarans = Bargikaran::with(['checklist', 'panjikaran'])
                                    ->latest()
                                    ->get();
        }

        return view('bargikaran.index', compact('bargikarans', 'panjikaran', 'panjikaranId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'panjikaran_id' => 'required|exists:panjikarans,id',
            'code' => 'required|integer',
            'make' => 'required|string|max:255',
        ]);

        // Get the checklist_id from the panjikaran
        $panjikaran = Panjikaran::findOrFail($request->panjikaran_id);

        Bargikaran::create([
            'checklist_id' => $panjikaran->ChecklistID,
            'panjikaran_id' => $request->panjikaran_id,
            'code' => $request->code,
            'make' => $request->make,
        ]);

        // Check if request comes from workflow
        if ($request->has('from_workflow')) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $request->panjikaran_id, 'step' => 1])
                           ->with('success', 'वर्गीकरण सफलतापूर्वक थपियो!');
        }

        return redirect()->route('bargikarans.index', ['panjikaran_id' => $request->panjikaran_id])
                        ->with('success', 'वर्गीकरण सफलतापूर्वक थपियो!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bargikaran $bargikaran)
    {
        $bargikaran->load(['checklist', 'panjikaran']);
        return view('bargikaran.show', compact('bargikaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bargikaran $bargikaran)
    {
        return view('bargikaran.edit', compact('bargikaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bargikaran $bargikaran)
    {
        $request->validate([
            'code' => 'required|integer',
            'make' => 'required|string|max:255',
        ]);

        $bargikaran->update([
            'code' => $request->code,
            'make' => $request->make,
        ]);

        // Check if request comes from workflow
        if ($request->has('from_workflow')) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $bargikaran->panjikaran_id, 'step' => 1])
                           ->with('success', 'वर्गीकरण सफलतापूर्वक अपडेट भयो!');
        }

        return redirect()->route('bargikarans.index', ['panjikaran_id' => $bargikaran->panjikaran_id])
                        ->with('success', 'वर्गीकरण सफलतापूर्वक अपडेट भयो!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bargikaran $bargikaran)
    {
        $panjikaranId = $bargikaran->panjikaran_id;
        $fromWorkflow = request()->has('from_workflow');

        $bargikaran->delete();

        // Check if request comes from workflow
        if ($fromWorkflow) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $panjikaranId, 'step' => 1])
                           ->with('success', 'वर्गीकरण सफलतापूर्वक मेटाइयो!');
        }

        return redirect()->route('bargikarans.index', ['panjikaran_id' => $panjikaranId])
                        ->with('success', 'वर्गीकरण सफलतापूर्वक मेटाइयो!');
    }
}
