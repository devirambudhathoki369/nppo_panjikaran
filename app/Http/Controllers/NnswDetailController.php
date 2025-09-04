<?php

namespace App\Http\Controllers;

use App\Models\NnswDetail;
use App\Models\Panjikaran;
use Illuminate\Http\Request;

class NnswDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'checklist_id' => 'required|exists:checklists,id',
            'panjikaran_id' => 'required|exists:panjikarans,id',
            'nepal_rastriya_ekdwar_pranalima_anurodh_no' => 'nullable|string|max:255',
            'nepal_rastriya_ekdwar_pranalima_anurodh_date' => 'nullable|date',
            'company_code' => 'nullable|string|max:255',
            'swikrit_no' => 'nullable|string|max:255',
            'swikrit_date' => 'nullable|date',
            'baidata_abadhi' => 'nullable|string|max:255',
        ]);

        NnswDetail::create($request->all());

        if ($request->has('from_workflow')) {
            $panjikaran = Panjikaran::findOrFail($request->panjikaran_id);
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => 5])
                ->with('success', 'NNSW विवरण सफलतापूर्वक थपियो!');
        }

        return redirect()->back()->with('success', 'NNSW विवरण सफलतापूर्वक थपियो!');
    }

    public function edit(NnswDetail $nnswDetail)
    {
        return view('nnsw-details.edit', compact('nnswDetail'));
    }

    public function update(Request $request, NnswDetail $nnswDetail)
    {
        $request->validate([
            'nepal_rastriya_ekdwar_pranalima_anurodh_no' => 'nullable|string|max:255',
            'nepal_rastriya_ekdwar_pranalima_anurodh_date' => 'nullable|date',
            'company_code' => 'nullable|string|max:255',
            'swikrit_no' => 'nullable|string|max:255',
            'swikrit_date' => 'nullable|date',
            'baidata_abadhi' => 'nullable|string|max:255',
        ]);

        $nnswDetail->update($request->all());

        if ($request->has('from_workflow')) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $nnswDetail->panjikaran_id, 'step' => 5])
                ->with('success', 'NNSW विवरण सफलतापूर्वक अपडेट भयो!');
        }

        return redirect()->back()->with('success', 'NNSW विवरण सफलतापूर्वक अपडेट भयो!');
    }

    public function destroy(NnswDetail $nnswDetail)
    {
        $panjikaranId = $nnswDetail->panjikaran_id;
        $nnswDetail->delete();

        if (request()->has('from_workflow')) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $panjikaranId, 'step' => 5])
                ->with('success', 'NNSW विवरण सफलतापूर्वक मेटाइयो!');
        }

        return redirect()->back()->with('success', 'NNSW विवरण सफलतापूर्वक मेटाइयो!');
    }
}
