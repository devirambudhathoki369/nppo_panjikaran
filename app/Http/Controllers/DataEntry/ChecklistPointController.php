<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;

class ChecklistPointController extends Controller
{
    public function index()
    {
        $checklistItems = ChecklistItem::all();
        return view('dataentry.checklist-points.index', compact('checklistItems'));
    }

    public function create()
    {
        return view('dataentry.checklist-points.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'CheckListItem' => 'required|string|max:200',
            'Type' => 'required|in:0,1,2',
        ]);

        ChecklistItem::create($request->all());

        return redirect()->route('checklist-points.index')
            ->with('success', 'चेकलिष्ट बुँदा सफलतापूर्वक थपियो');
    }

    public function show(ChecklistItem $checklistItem)
    {
        return view('dataentry.checklist-points.show', compact('checklistItem'));
    }

    public function edit($checklist_point)
    {
        $checklistItem = ChecklistItem::findOrFail($checklist_point);
        return view('dataentry.checklist-points.edit', compact('checklistItem'));
    }

    public function update(Request $request, $checklist_point)
    {
        $request->validate([
            'CheckListItem' => 'required|string|max:200',
            'Type' => 'required|in:0,1,2',
        ]);

        $checklistItem = ChecklistItem::findOrFail($checklist_point);
        $checklistItem->update($request->all());

        return redirect()->route('checklist-points.index')
            ->with('success', 'चेकलिष्ट बुँदा सफलतापूर्वक अद्यावधिक गरियो');
    }

    public function destroy($checklist_point)
    {
        $checklistItem = ChecklistItem::findOrFail($checklist_point);
        $checklistItem->delete();

        return redirect()->route('checklist-points.index')
            ->with('success', 'चेकलिष्ट बुँदा सफलतापूर्वक मेटियो');
    }
}
