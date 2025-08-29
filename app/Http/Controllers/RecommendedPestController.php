<?php

namespace App\Http\Controllers;

use App\Models\RecommendedPest;
use App\Models\Panjikaran;
use App\Models\Pest;
use Illuminate\Http\Request;

class RecommendedPestController extends Controller
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
            $recommendedPests = RecommendedPest::with(['checklist', 'panjikaran', 'pest'])
                                             ->where('panjikaran_id', $panjikaranId)
                                             ->latest()
                                             ->get();
        } else {
            $recommendedPests = RecommendedPest::with(['checklist', 'panjikaran', 'pest'])
                                             ->latest()
                                             ->get();
        }

        $pests = Pest::all();

        return view('recommended_pest.index', compact('recommendedPests', 'panjikaran', 'panjikaranId', 'pests'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'panjikaran_id' => 'required|exists:panjikarans,id',
            'pest_id' => 'required|exists:pests,id',
        ]);

        // Check if this combination already exists
        $exists = RecommendedPest::where('panjikaran_id', $request->panjikaran_id)
                                ->where('pest_id', $request->pest_id)
                                ->exists();

        if ($exists) {
            // Handle workflow redirect for error case
            if ($request->has('from_workflow')) {
                return redirect()->route('panjikaran.workflow', ['panjikaran' => $request->panjikaran_id, 'step' => 3])
                               ->with('error', 'यो कीरा पहिले नै सिफारिस गरिएको छ!');
            }

            return redirect()->route('recommended-pests.index', ['panjikaran_id' => $request->panjikaran_id])
                           ->with('error', 'यो कीरा पहिले नै सिफारिस गरिएको छ!');
        }

        // Get the checklist_id from the panjikaran
        $panjikaran = Panjikaran::findOrFail($request->panjikaran_id);

        RecommendedPest::create([
            'checklist_id' => $panjikaran->ChecklistID,
            'panjikaran_id' => $request->panjikaran_id,
            'pest_id' => $request->pest_id,
        ]);

        // Check if request comes from workflow
        if ($request->has('from_workflow')) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $request->panjikaran_id, 'step' => 3])
                           ->with('success', 'सिफारिस गरिएको कीरा सफलतापूर्वक थपियो!');
        }

        return redirect()->route('recommended-pests.index', ['panjikaran_id' => $request->panjikaran_id])
                        ->with('success', 'सिफारिस गरिएको कीरा सफलतापूर्वक थपियो!');
    }

    /**
     * Display the specified resource.
     */
    public function show(RecommendedPest $recommendedPest)
    {
        $recommendedPest->load(['checklist', 'panjikaran', 'pest']);
        return view('recommended_pest.show', compact('recommendedPest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecommendedPest $recommendedPest)
    {
        $pests = Pest::all();
        return view('recommended_pest.edit', compact('recommendedPest', 'pests'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecommendedPest $recommendedPest)
    {
        $request->validate([
            'pest_id' => 'required|exists:pests,id',
        ]);

        // Check if this combination already exists (excluding current record)
        $exists = RecommendedPest::where('panjikaran_id', $recommendedPest->panjikaran_id)
                                ->where('pest_id', $request->pest_id)
                                ->where('id', '!=', $recommendedPest->id)
                                ->exists();

        if ($exists) {
            // Handle workflow redirect for error case
            if ($request->has('from_workflow')) {
                return redirect()->route('panjikaran.workflow', ['panjikaran' => $recommendedPest->panjikaran_id, 'step' => 3])
                               ->with('error', 'यो कीरा पहिले नै सिफारिस गरिएको छ!');
            }

            return redirect()->back()->with('error', 'यो कीरा पहिले नै सिफारिस गरिएको छ!');
        }

        $recommendedPest->update([
            'pest_id' => $request->pest_id,
        ]);

        // Check if request comes from workflow
        if ($request->has('from_workflow')) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $recommendedPest->panjikaran_id, 'step' => 3])
                           ->with('success', 'सिफारिस गरिएको कीरा सफलतापूर्वक अपडेट भयो!');
        }

        return redirect()->route('recommended-pests.index', ['panjikaran_id' => $recommendedPest->panjikaran_id])
                        ->with('success', 'सिफारिस गरिएको कीरा सफलतापूर्वक अपडेट भयो!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecommendedPest $recommendedPest)
    {
        $panjikaranId = $recommendedPest->panjikaran_id;
        $fromWorkflow = request()->has('from_workflow');

        $recommendedPest->delete();

        // Check if request comes from workflow
        if ($fromWorkflow) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $panjikaranId, 'step' => 3])
                           ->with('success', 'सिफारिस गरिएको कीरा सफलतापूर्वक मेटाइयो!');
        }

        return redirect()->route('recommended-pests.index', ['panjikaran_id' => $panjikaranId])
                        ->with('success', 'सिफारिस गरिएको कीरा सफलतापूर्वक मेटाइयो!');
    }
}
