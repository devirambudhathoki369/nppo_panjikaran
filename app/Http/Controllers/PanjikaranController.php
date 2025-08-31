<?php

namespace App\Http\Controllers;

use App\Models\Panjikaran;
use App\Models\Checklist;
use App\Models\Source;
use App\Models\Objective;
use App\Models\Usage;
use App\Models\Unit;
use App\Models\PackageDestroy;
use App\Models\Bargikaran;
use App\Models\RecommendedCrop;
use App\Models\RecommendedPest;
use App\Models\Crop;
use App\Models\Pest;
use Illuminate\Http\Request;

class PanjikaranController extends Controller
{
    /**
     * Display a listing of checklists.
     */
    public function checklistIndex()
    {
        // For debugging - let's get all checklists first
        $checklists = Checklist::with(['creator', 'verifier', 'approver', 'formulation', 'bishadiType', 'country'])
            ->where('status', '2')->latest()
            ->get();

        // If you want to apply user visibility, uncomment the line below:
        // $checklists = $checklists->where(function($query) { return $query->visibleToUser(); });

        return view('panjikaran.checklists_index', compact('checklists'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $panjikarans = Panjikaran::with(['checklist', 'source', 'objective', 'usage', 'unit', 'packageDestroy'])
            ->latest()
            ->get();

        return view('panjikaran.panjikaran_index', compact('panjikarans'));
    }

    /**
     * Display the workflow for a specific panjikaran.
     */
    public function workflow(Request $request, Panjikaran $panjikaran)
    {
        $currentStep = $request->get('step', 1);

        // Ensure step is between 1 and 3 (steps 1-3 only, after step 3 redirect to show)
        $currentStep = max(1, min(3, intval($currentStep)));

        // Load panjikaran with necessary relationships
        $panjikaran->load(['checklist', 'source', 'objective', 'usage', 'unit', 'packageDestroy']);

        // Get data for each step
        $bargikarans = Bargikaran::with(['checklist', 'panjikaran'])
            ->where('panjikaran_id', $panjikaran->id)
            ->latest()
            ->get();

        $recommendedCrops = RecommendedCrop::with(['checklist', 'panjikaran', 'crop'])
            ->where('panjikaran_id', $panjikaran->id)
            ->latest()
            ->get();

        $recommendedPests = RecommendedPest::with(['checklist', 'panjikaran', 'pest'])
            ->where('panjikaran_id', $panjikaran->id)
            ->latest()
            ->get();

        // Get dropdown data
        $crops = Crop::all();
        $pests = Pest::all();

        return view('panjikaran.workflow', compact(
            'panjikaran',
            'currentStep',
            'bargikarans',
            'recommendedCrops',
            'recommendedPests',
            'crops',
            'pests'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $checklistId = $request->get('checklist_id');
        $checklist = null;

        if ($checklistId) {
            $checklist = Checklist::findOrFail($checklistId);
        }

        $sources = Source::all();
        $objectives = Objective::all();
        $usages = Usage::all();
        $units = Unit::all();
        $packageDestroys = PackageDestroy::all();

        return view('panjikaran.create', compact(
            'checklist',
            'checklistId',
            'sources',
            'objectives',
            'usages',
            'units',
            'packageDestroys'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ChecklistID' => 'required|exists:checklists,id',
            'ChemicalName' => 'required|string|max:200',
            'IUPAC_Name' => 'nullable|string',
            'Cas_No' => 'nullable|string|max:20',
            'Atomic_Formula' => 'nullable|string|max:100',
            'SourceID' => 'required|exists:sources,id',
            'ObjectiveID' => 'required|exists:objectives,id',
            'UsageID' => 'required|exists:usages,id',
            'DapperQuantity' => 'nullable|string|max:255',
            'DQUnitID' => 'required|exists:units,id',
            'Waiting_duration' => 'nullable|string|max:255',
            'FirstAid' => 'nullable|string|max:255',
            'PackageDestroyID' => 'required|exists:package_destroys,id',
            'Foreign_producer_company_name' => 'nullable|string|max:255',
            'Foreign_producer_company_address' => 'nullable|string|max:255',
            'Nepali_producer_company_name' => 'nullable|string|max:255',
            'Nepali_producer_company_address' => 'nullable|string|max:255',
            'Nepali_producer_company_email' => 'nullable|email|max:100',
            'Nepali_producer_company_contact' => 'nullable|string|max:100',
            'Samejasamcompany_s_detail_name' => 'nullable|string|max:255',
            'Samejasamcompany_s_detail_address' => 'nullable|string|max:255',
            'Samejasamcompany_s_detail_email' => 'nullable|email|max:100',
            'Samejasamcompany_s_detail_contact' => 'nullable|string|max:100',
            'Packing_company_details_name' => 'nullable|string|max:255',
            'Packing_company_details_address' => 'nullable|string|max:255',
            'Packing_company_details_email' => 'nullable|email|max:100',
            'Packing_company_details_contact' => 'nullable|string|max:100',
            'Paitharkarta_company_details_name' => 'nullable|string|max:255',
            'Paitharkarta_company_details_address' => 'nullable|string|max:255',
            'Paitharkarta_company_details_email' => 'nullable|email|max:100',
            'Paitharkarta_company_details_contact' => 'nullable|string|max:100',
        ]);

        $panjikaran = Panjikaran::create($request->all());

        // Redirect to workflow after creation
        return redirect()->route('panjikaran.workflow', $panjikaran->id)->with('success', 'पञ्जीकरण सफलतापूर्वक थपियो!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Panjikaran $panjikaran)
    {
        $panjikaran->load(['checklist', 'source', 'objective', 'usage', 'unit', 'packageDestroy']);
        return view('panjikaran.show', compact('panjikaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Panjikaran $panjikaran)
    {
        $checklistId = $request->get('checklist_id');
        $checklist = null;

        if ($checklistId) {
            $checklist = Checklist::findOrFail($checklistId);
        }

        $sources = Source::all();
        $objectives = Objective::all();
        $usages = Usage::all();
        $units = Unit::all();
        $packageDestroys = PackageDestroy::all();

        return view('panjikaran.edit', compact(
            'panjikaran',
            'sources',
            'objectives',
            'usages',
            'units',
            'checklist',
            'packageDestroys'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Panjikaran $panjikaran)
    {
        $request->validate([
            'ChemicalName' => 'required|string|max:200',
            'IUPAC_Name' => 'nullable|string',
            'Cas_No' => 'nullable|string|max:20',
            'Atomic_Formula' => 'nullable|string|max:100',
            'SourceID' => 'required|exists:sources,id',
            'ObjectiveID' => 'required|exists:objectives,id',
            'UsageID' => 'required|exists:usages,id',
            'DapperQuantity' => 'nullable|string|max:255',
            'DQUnitID' => 'required|exists:units,id',
            'Waiting_duration' => 'nullable|string|max:255',
            'FirstAid' => 'nullable|string|max:255',
            'PackageDestroyID' => 'required|exists:package_destroys,id',
            'Foreign_producer_company_name' => 'nullable|string|max:255',
            'Foreign_producer_company_address' => 'nullable|string|max:255',
            'Nepali_producer_company_name' => 'nullable|string|max:255',
            'Nepali_producer_company_address' => 'nullable|string|max:255',
            'Nepali_producer_company_email' => 'nullable|email|max:100',
            'Nepali_producer_company_contact' => 'nullable|string|max:100',
            'Samejasamcompany_s_detail_name' => 'nullable|string|max:255',
            'Samejasamcompany_s_detail_address' => 'nullable|string|max:255',
            'Samejasamcompany_s_detail_email' => 'nullable|email|max:100',
            'Samejasamcompany_s_detail_contact' => 'nullable|string|max:100',
            'Packing_company_details_name' => 'nullable|string|max:255',
            'Packing_company_details_address' => 'nullable|string|max:255',
            'Packing_company_details_email' => 'nullable|email|max:100',
            'Packing_company_details_contact' => 'nullable|string|max:100',
            'Paitharkarta_company_details_name' => 'nullable|string|max:255',
            'Paitharkarta_company_details_address' => 'nullable|string|max:255',
            'Paitharkarta_company_details_email' => 'nullable|email|max:100',
            'Paitharkarta_company_details_contact' => 'nullable|string|max:100',
        ]);

        $panjikaran->update($request->all());

        return redirect()->route('panjikarans.index')->with('success', 'पञ्जीकरण सफलतापूर्वक अपडेट भयो!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Panjikaran $panjikaran)
    {
        $panjikaran->delete();
        return redirect()->route('panjikarans.index')->with('success', 'पञ्जीकरण सफलतापूर्वक मेटाइयो!');
    }

    public function print(Panjikaran $panjikaran)
    {
        $panjikaran->load([
            'checklist.check_list_formulations.common_name',
            'checklist.check_list_formulations.formulation',
            'checklist.check_list_formulations.unit',
            'checklist.bishadiType',
            'source',
            'objective',
            'usage',
            'unit',
            'packageDestroy',
            'bargikarans',
            'recommendedCrops.crop',
            'recommendedPests.pest'
        ]);

        return view('panjikaran.print', compact('panjikaran'));
    }

    /**
     * Show parameterized reports page for Panjikaran
     */
    public function reports(Request $request)
    {
        $reportType = $request->get('report_by');
        $filterValue = $request->get('filter_value');

        $panjikarans = collect();
        $reportData = [];

        // Get filter options based on report type
        if ($reportType) {
            switch ($reportType) {
                case 'source':
                    $reportData = \App\Models\Source::all();
                    break;
                case 'objective':
                    $reportData = \App\Models\Objective::all();
                    break;
                case 'usage':
                    $reportData = \App\Models\Usage::all();
                    break;
                case 'unit':
                    $reportData = \App\Models\Unit::all();
                    break;
                case 'packagedestroy':
                    $reportData = \App\Models\PackageDestroy::all();
                    break;
                case 'country':
                    $reportData = \App\Models\Country::all();
                    break;
            }
        }

        // Get filtered panjikarans if filter value is selected
        if ($reportType && $filterValue) {
            $query = \App\Models\Panjikaran::with(['checklist', 'source', 'objective', 'usage', 'unit', 'packageDestroy']);

            switch ($reportType) {
                case 'source':
                    $query->where('SourceID', $filterValue);
                    break;
                case 'objective':
                    $query->where('ObjectiveID', $filterValue);
                    break;
                case 'usage':
                    $query->where('UsageID', $filterValue);
                    break;
                case 'unit':
                    $query->where('DQUnitID', $filterValue);
                    break;
                case 'packagedestroy':
                    $query->where('PackageDestroyID', $filterValue);
                    break;
                case 'country':
                    $query->whereHas('checklist', function ($q) use ($filterValue) {
                        $q->where('CountryID', $filterValue);
                    });
                    break;
            }

            $panjikarans = $query->orderBy('created_at', 'desc')->get();
        }

        return view('panjikaran.reports', compact(
            'reportType',
            'filterValue',
            'reportData',
            'panjikarans'
        ));
    }
}
