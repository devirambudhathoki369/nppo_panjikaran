<?php

namespace App\Http\Controllers;

use App\Models\Renewal;
use App\Models\Panjikaran;
use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RenewalController extends Controller
{
    public function index(Request $request)
    {
        $query = Renewal::with(['checklist', 'panjikaran']);
        $panjikaran = null;

        // Filter by panjikaran if provided
        if ($request->has('panjikaran_id') && $request->panjikaran_id) {
            $panjikaran = Panjikaran::with(['checklist.check_list_formulations.common_name.source', 'checklist.check_list_formulations.formulation', 'checklist.check_list_formulations.unit'])
                ->findOrFail($request->panjikaran_id);
            $query->where('panjikaran_id', $request->panjikaran_id);
        }

        $renewals = $query->latest()->get();

        return view('renewals.index', compact('renewals', 'panjikaran'));
    }

    public function create(Request $request)
    {
        $panjikaran = null;
        $checklist = null;

        if ($request->has('panjikaran_id')) {
            $panjikaran = Panjikaran::with('checklist')->findOrFail($request->panjikaran_id);
            $checklist = $panjikaran->checklist;
        }

        return view('renewals.create', compact('panjikaran', 'checklist'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'panjikaran_id' => 'required|exists:panjikarans,id',
            'renew_date' => 'required|date',
            'renew_expiry_date' => 'required|date|after:renew_date',
            'tax_bhauchar_no' => 'nullable|string|max:255',
            'ruju_garne' => 'nullable|string|max:255',
            'signature_upload' => 'nullable|file|image|max:2048', // 2MB max
        ]);

        // Get the panjikaran with checklist relationship to extract checklist_id
        $panjikaran = Panjikaran::with('checklist')->findOrFail($request->panjikaran_id);

        // Check if panjikaran has a ChecklistID (note the capital letters)
        if (!$panjikaran->ChecklistID) {
            return redirect()->back()->with('error', 'यो पञ्जीकरणसँग कुनै चेकलिस्ट जडान भएको छैन।')->withInput();
        }

        $data = $request->except('signature_upload');
        $data['checklist_id'] = $panjikaran->ChecklistID; // Use ChecklistID (capital letters)

        // Handle file upload
        if ($request->hasFile('signature_upload')) {
            $file = $request->file('signature_upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('signatures', $filename, 'public');
            $data['signature_upload'] = $path;
        }

        Renewal::create($data);

        return redirect()->route('renewals.index', ['panjikaran_id' => $request->panjikaran_id])
            ->with('success', 'नवीकरण सफलतापूर्वक थपियो!');
    }

    public function show(Renewal $renewal)
    {
        $renewal->load(['checklist', 'panjikaran']);
        return view('renewals.show', compact('renewal'));
    }

    public function edit(Renewal $renewal)
    {
        $renewal->load(['checklist', 'panjikaran']);
        return view('renewals.edit', compact('renewal'));
    }

    public function update(Request $request, Renewal $renewal)
    {
        $request->validate([
            'renew_date' => 'required|date',
            'renew_expiry_date' => 'required|date|after:renew_date',
            'tax_bhauchar_no' => 'nullable|string|max:255',
            'ruju_garne' => 'nullable|string|max:255',
            'signature_upload' => 'nullable|file|image|max:2048',
        ]);

        $data = $request->except('signature_upload');

        // Handle file upload
        if ($request->hasFile('signature_upload')) {
            // Delete old file if exists
            if ($renewal->signature_upload && Storage::disk('public')->exists($renewal->signature_upload)) {
                Storage::disk('public')->delete($renewal->signature_upload);
            }

            $file = $request->file('signature_upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('signatures', $filename, 'public');
            $data['signature_upload'] = $path;
        }

        $renewal->update($data);

        return redirect()->route('renewals.index', ['panjikaran_id' => $renewal->panjikaran_id])
            ->with('success', 'नवीकरण सफलतापूर्वक अपडेट भयो!');
    }

    public function destroy(Renewal $renewal)
    {
        $panjikaranId = $renewal->panjikaran_id;

        // Delete signature file if exists
        if ($renewal->signature_upload && Storage::disk('public')->exists($renewal->signature_upload)) {
            Storage::disk('public')->delete($renewal->signature_upload);
        }

        $renewal->delete();

        return redirect()->route('renewals.index', ['panjikaran_id' => $panjikaranId])
            ->with('success', 'नवीकरण सफलतापूर्वक मेटाइयो!');
    }
}
