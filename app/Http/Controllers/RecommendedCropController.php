<?php

namespace App\Http\Controllers;

use App\Models\RecommendedCrop;
use App\Models\Panjikaran;
use App\Models\Crop;
use Illuminate\Http\Request;

class RecommendedCropController extends Controller
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
            $recommendedCrops = RecommendedCrop::with(['checklist', 'panjikaran', 'crop'])
                                             ->where('panjikaran_id', $panjikaranId)
                                             ->latest()
                                             ->get();
        } else {
            $recommendedCrops = RecommendedCrop::with(['checklist', 'panjikaran', 'crop'])
                                             ->latest()
                                             ->get();
        }

        $crops = Crop::all();

        return view('recommended_crop.index', compact('recommendedCrops', 'panjikaran', 'panjikaranId', 'crops'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'panjikaran_id' => 'required|exists:panjikarans,id',
            'crop_id' => 'required|exists:crops,id',
        ]);

        // Check if this combination already exists
        $exists = RecommendedCrop::where('panjikaran_id', $request->panjikaran_id)
                                ->where('crop_id', $request->crop_id)
                                ->exists();

        if ($exists) {
            // Handle workflow redirect for error case
            if ($request->has('from_workflow')) {
                return redirect()->route('panjikaran.workflow', ['panjikaran' => $request->panjikaran_id, 'step' => 2])
                               ->with('error', 'यो बाली पहिले नै सिफारिस गरिएको छ!');
            }

            return redirect()->route('recommended-crops.index', ['panjikaran_id' => $request->panjikaran_id])
                           ->with('error', 'यो बाली पहिले नै सिफारिस गरिएको छ!');
        }

        // Get the checklist_id from the panjikaran
        $panjikaran = Panjikaran::findOrFail($request->panjikaran_id);

        RecommendedCrop::create([
            'checklist_id' => $panjikaran->ChecklistID,
            'panjikaran_id' => $request->panjikaran_id,
            'crop_id' => $request->crop_id,
        ]);

        // Check if request comes from workflow
        if ($request->has('from_workflow')) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $request->panjikaran_id, 'step' => 2])
                           ->with('success', 'सिफारिस गरिएको बाली सफलतापूर्वक थपियो!');
        }

        return redirect()->route('recommended-crops.index', ['panjikaran_id' => $request->panjikaran_id])
                        ->with('success', 'सिफारिस गरिएको बाली सफलतापूर्वक थपियो!');
    }

    /**
     * Display the specified resource.
     */
    public function show(RecommendedCrop $recommendedCrop)
    {
        $recommendedCrop->load(['checklist', 'panjikaran', 'crop']);
        return view('recommended_crop.show', compact('recommendedCrop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecommendedCrop $recommendedCrop)
    {
        $crops = Crop::all();
        return view('recommended_crop.edit', compact('recommendedCrop', 'crops'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecommendedCrop $recommendedCrop)
    {
        $request->validate([
            'crop_id' => 'required|exists:crops,id',
        ]);

        // Check if this combination already exists (excluding current record)
        $exists = RecommendedCrop::where('panjikaran_id', $recommendedCrop->panjikaran_id)
                                ->where('crop_id', $request->crop_id)
                                ->where('id', '!=', $recommendedCrop->id)
                                ->exists();

        if ($exists) {
            // Handle workflow redirect for error case
            if ($request->has('from_workflow')) {
                return redirect()->route('panjikaran.workflow', ['panjikaran' => $recommendedCrop->panjikaran_id, 'step' => 2])
                               ->with('error', 'यो बाली पहिले नै सिफारिस गरिएको छ!');
            }

            return redirect()->back()->with('error', 'यो बाली पहिले नै सिफारिस गरिएको छ!');
        }

        $recommendedCrop->update([
            'crop_id' => $request->crop_id,
        ]);

        // Check if request comes from workflow
        if ($request->has('from_workflow')) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $recommendedCrop->panjikaran_id, 'step' => 2])
                           ->with('success', 'सिफारिस गरिएको बाली सफलतापूर्वक अपडेट भयो!');
        }

        return redirect()->route('recommended-crops.index', ['panjikaran_id' => $recommendedCrop->panjikaran_id])
                        ->with('success', 'सिफारिस गरिएको बाली सफलतापूर्वक अपडेट भयो!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecommendedCrop $recommendedCrop)
    {
        $panjikaranId = $recommendedCrop->panjikaran_id;
        $fromWorkflow = request()->has('from_workflow');

        $recommendedCrop->delete();

        // Check if request comes from workflow
        if ($fromWorkflow) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $panjikaranId, 'step' => 2])
                           ->with('success', 'सिफारिस गरिएको बाली सफलतापूर्वक मेटाइयो!');
        }

        return redirect()->route('recommended-crops.index', ['panjikaran_id' => $panjikaranId])
                        ->with('success', 'सिफारिस गरिएको बाली सफलतापूर्वक मेटाइयो!');
    }
}
