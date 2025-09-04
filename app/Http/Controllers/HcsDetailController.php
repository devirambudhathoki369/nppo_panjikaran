<?php

namespace App\Http\Controllers;

use App\Models\HcsDetail;
use App\Models\Panjikaran;
use Illuminate\Http\Request;

class HcsDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'checklist_id' => 'required|exists:checklists,id',
            'panjikaran_id' => 'required|exists:panjikarans,id',
            'hcs_code' => 'required|string|max:255',
            'self_life_of_the_product' => 'nullable|string|max:255',
            'tax_payment_bhauchar_details' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        HcsDetail::create($request->all());

        if ($request->has('from_workflow')) {
            $panjikaran = Panjikaran::findOrFail($request->panjikaran_id);
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => 4])
                ->with('success', 'H.C.S विवरण सफलतापूर्वक थपियो!');
        }

        return redirect()->back()->with('success', 'H.C.S विवरण सफलतापूर्वक थपियो!');
    }

    public function edit(HcsDetail $hcsDetail)
    {
        return view('hcs-details.edit', compact('hcsDetail'));
    }

    public function update(Request $request, HcsDetail $hcsDetail)
    {
        $request->validate([
            'hcs_code' => 'required|string|max:255',
            'self_life_of_the_product' => 'nullable|string|max:255',
            'tax_payment_bhauchar_details' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        $hcsDetail->update($request->all());

        if ($request->has('from_workflow')) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $hcsDetail->panjikaran_id, 'step' => 4])
                ->with('success', 'H.C.S विवरण सफलतापूर्वक अपडेट भयो!');
        }

        return redirect()->back()->with('success', 'H.C.S विवरण सफलतापूर्वक अपडेट भयो!');
    }

    public function destroy(HcsDetail $hcsDetail)
    {
        $panjikaranId = $hcsDetail->panjikaran_id;
        $hcsDetail->delete();

        if (request()->has('from_workflow')) {
            return redirect()->route('panjikaran.workflow', ['panjikaran' => $panjikaranId, 'step' => 4])
                ->with('success', 'H.C.S विवरण सफलतापूर्वक मेटाइयो!');
        }

        return redirect()->back()->with('success', 'H.C.S विवरण सफलतापूर्वक मेटाइयो!');
    }
}
