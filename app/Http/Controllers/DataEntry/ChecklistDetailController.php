<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\ChecklistDetail;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;

class ChecklistDetailController extends Controller
{
    public function index($checklistId)
    {
        $checklist = Checklist::findOrFail($checklistId);

        // Get already selected checklist item IDs for this checklist
        $selectedItemIds = ChecklistDetail::where('ChecklistID', $checklistId)
            ->pluck('ChecklistItemID')
            ->toArray();

        $items = ChecklistItem::query()
            ->whereDoesntHave('checklist_details', function ($query) use ($checklistId) {
                $query->where('ChecklistID', $checklistId);
            })
            ->when(
                $checklist->ApplicationType == '0',
                function ($query) {
                    $query->whereIn('Type', ['0', '2']);
                },
                function ($query) {
                    $query->whereIn('Type', ['1', '2']);
                }
            )
            ->get();

        $details = ChecklistDetail::where('ChecklistID', $checklistId)->get();
        return view('dataentry.checklist_details.index', compact('details', 'checklist', 'items'));
    }

    public function create($checklistId)
    {
        $checklist = Checklist::findOrFail($checklistId);

        // Get already selected checklist item IDs for this checklist
        $selectedItemIds = ChecklistDetail::where('ChecklistID', $checklistId)
            ->pluck('ChecklistItemID')
            ->toArray();

        // Filter items based on checklist's ApplicationType and exclude already selected items
        $items = ChecklistItem::where(function ($query) use ($checklist) {
            if ($checklist->ApplicationType == 0) {
                // If ApplicationType is 0 (Importer), show Type 0 and 2
                $query->whereIn('Type', [0, 2]);
            } else {
                // If ApplicationType is 1 (Producer/Formulator/Packaging), show Type 1 and 2
                $query->whereIn('Type', [1, 2]);
            }
        })->whereNotIn('id', $selectedItemIds)->get();

        return view('dataentry.checklist_details.create', compact('checklist', 'items'));
    }

    public function store(Request $request, $checklistId)
    {
        $validated = $request->validate([
            'ChecklistItemID' => 'required|exists:checklist_items,id',
            'DocumentStatus' => 'required|in:0,1',
            'SourceOfDocument' => 'required|in:0,1,2,3',
            'Remarks' => 'nullable|string|max:200',
        ]);

        // Additional validation to ensure the selected item is not already added
        $existingDetail = ChecklistDetail::where('ChecklistID', $checklistId)
            ->where('ChecklistItemID', $request->ChecklistItemID)
            ->first();

        if ($existingDetail) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['ChecklistItemID' => 'यो चेकलिष्ट बुँदा पहिले नै थपिएको छ।']);
        }

        $validated['ChecklistID'] = $checklistId;

        ChecklistDetail::create($validated);

        return redirect()->route('dataentry.checklists.details.index', $checklistId)
            ->with('success', 'डिटेल सफलतापूर्वक थपियो');
    }

    public function show($checklistId, $id)
    {
        $detail = ChecklistDetail::where('ChecklistID', $checklistId)->findOrFail($id);
        return view('dataentry.checklist_details.show', compact('detail'));
    }

    public function edit($checklistId, $id)
    {
        $detail = ChecklistDetail::where('ChecklistID', $checklistId)->findOrFail($id);
        $checklist = Checklist::findOrFail($checklistId);

        // Get already selected checklist item IDs for this checklist (excluding current one)
        $selectedItemIds = ChecklistDetail::where('ChecklistID', $checklistId)
            ->where('id', '!=', $id) // Exclude current detail record
            ->pluck('ChecklistItemID')
            ->toArray();

        $items = ChecklistItem::query()
            ->whereNotIn('id', $selectedItemIds)
            ->when(
                $checklist->ApplicationType == '0',
                function ($query) {
                    $query->whereIn('Type', ['0', '2']);
                },
                function ($query) {
                    $query->whereIn('Type', ['1', '2']);
                }
            )
            ->get();

        return view('dataentry.checklist_details.edit', compact('detail', 'items', 'checklist'));
    }

    public function update(Request $request, $checklistId, $id)
    {
        $validated = $request->validate([
            'ChecklistItemID' => 'required|exists:checklist_items,id',
            'DocumentStatus' => 'required|in:0,1',
            'SourceOfDocument' => 'required|in:0,1,2,3',
            'Remarks' => 'nullable|string|max:200',
        ]);

        // Additional validation to ensure the selected item is not already added (excluding current record)
        $existingDetail = ChecklistDetail::where('ChecklistID', $checklistId)
            ->where('ChecklistItemID', $request->ChecklistItemID)
            ->where('id', '!=', $id)
            ->first();

        if ($existingDetail) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['ChecklistItemID' => 'यो चेकलिष्ट बुँदा पहिले नै थपिएको छ।']);
        }

        $detail = ChecklistDetail::where('ChecklistID', $checklistId)->findOrFail($id);
        $detail->update($validated);

        return redirect()->route('dataentry.checklists.details.index', $checklistId)
            ->with('success', 'डिटेल सफलतापूर्वक अपडेट गरियो');
    }

    public function destroy($checklistId, $id)
    {
        $detail = ChecklistDetail::where('ChecklistID', $checklistId)->findOrFail($id);
        $detail->delete();

        return redirect()->route('dataentry.checklists.details.index', $checklistId)
            ->with('success', 'डिटेल सफलतापूर्वक मेटाइयो');
    }
}
