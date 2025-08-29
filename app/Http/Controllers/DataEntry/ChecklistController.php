<?php

namespace App\Http\Controllers\DataEntry;

use App\Models\Unit;
use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BishadiType;
use App\Models\CommonName;
use App\Models\Container;
use App\Models\Country;
use App\Models\Formulation;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource with role-based filtering
     */
    public function index(Request $request)
    {
        $checklist = Checklist::query();
        $userType = auth()->user()->usertype;

        if ($userType == 'approver') {
            // Approvers only see verified documents (Status = 1) and approved ones (Status = 2)
            $checklist->whereIn('Status', [1, 2]);
        } elseif ($userType == 'verifier') {
            // Verifiers see documents sent to them for verification
            $sentToVerify = Notification::where('to_user_id', auth()->id())
                ->where('action_type', 'send_to_verify')
                ->pluck('checklist_id');

            $checklist->where(function ($q) use ($sentToVerify) {
                $q->whereIn('id', $sentToVerify)
                    ->orWhere('Status', 1)
                    ->orWhere('Status', 2);
            });
        } elseif ($userType == 'user') {
            // Users see only their own documents
            $checklist->where('CreatedBy', auth()->id());
        }
        // Admin sees all documents

        if ($request->has('list_type')) {
            $listType = sanitize($request->list_type);
            if (!in_array($listType, ['registered', 'verified', 'approved'])) {
                return back()->withError('Invalid list type.');
            }

            if ($listType == 'registered') {
                $checklist->whereNotNull('CreatedDate');
            } elseif ($listType == 'verified') {
                $checklist->where('Status', 1);
            } elseif ($listType == 'approved') {
                $checklist->where('Status', 2);
            }
        }

        $checklists = $checklist->with(['notifications', 'creator', 'verifier', 'approver'])
            ->orderBy('id', 'desc')
            ->get();

        return view('dataentry.checklists.index', compact('checklists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formulations = Formulation::orderBy('formulation_name')->get();
        $bishadiTypes = BishadiType::orderBy('prakar')->get();

        return view('dataentry.checklists.create', compact('formulations', 'bishadiTypes'));
    }

    // Add this new method for AJAX license lookup
    // Updated method for AJAX license lookup
    public function getLicenseInfo(Request $request)
    {
        try {
            $licenseNo = $request->get('license_no');

            if (empty($licenseNo)) {
                return response()->json([
                    'success' => false,
                    'message' => 'License number is required'
                ]);
            }

            // Query the external database directly using DB facade
            $license = DB::connection('bisadiapp_mysql')
                ->table('tbllicense')
                ->where('LicenseNo', $licenseNo)
                ->first();

            if ($license) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'agrovet_name' => $license->AgrovetNameEng
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'इजाजतपत्र नम्बर मेल खाएन। कृपया नाम आफैं प्रविष्ट गर्नुहोस्।'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'इजाजतपत्र जानकारी प्राप्त गर्न समस्या भयो। कृपया नाम आफैं प्रविष्ट गर्नुहोस्।'
            ]);
        }
    }

    public function showLicenseProfile($licenseNo)
    {
        try {
            // Get license details from external database
            $license = DB::connection('bisadiapp_mysql')
                ->table('tbllicense')
                ->where('LicenseNo', $licenseNo)
                ->first();

            if (!$license) {
                return redirect()->back()->with('error', 'इजाजतपत्र फेला परेन।');
            }

            // Get district name if you have a districts table
            $district = null;
            try {
                $district = DB::connection('bisadiapp_mysql')
                    ->table('tbldistrict')
                    ->where('id', $license->DistrictID)
                    ->first();
            } catch (\Exception $e) {
                // District table might not exist or have different structure
            }

            return view('license.profile', compact('license', 'district'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'इजाजतपत्र जानकारी लोड गर्न समस्या भयो: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'ImporterName' => 'required|string|max:200',
            'LicenseNo' => 'required|string|max:20',
            'ApplicationType' => 'required|in:0,1',
            'TradeNameOfPesticide' => 'required|string|max:200',
            'formulation_id' => 'required|exists:formulations,id',
            'bishadi_type_id' => 'required|exists:bishadi_types,id',
        ]);

        // Create the checklist record - no validation against external database
        $checklist = Checklist::create([
            'ImporterName' => $request->ImporterName,
            'TradeNameOfPesticide' => $request->TradeNameOfPesticide,
            'LicenseNo' => $request->LicenseNo,
            'ApplicationType' => $request->ApplicationType,
            'formulation_id' => $request->formulation_id,
            'bishadi_type_id' => $request->bishadi_type_id,
            'CreatedBy' => Auth::id(),
            'CreatedDate' => now()->format('Y-m-d'),
        ]);

        return redirect()->route('dataentry.checklists.follow-steps', [$checklist->id, 'step=2'])
            ->with('success', 'डाटा सफलतापूर्वक थपियो');
    }

    public function follow_steps(Request $request, Checklist $checklist)
    {
        $currentStep = $request->step;
        $commonNames = [];
        $containers = [];
        $formulations = [];
        $countries = [];
        $units = Unit::where('status', 1)->orderBy('unit_name')->get();

        switch ($currentStep) {
            default:
                $bladeView = 'step-2';
                $containers = Container::where('status', 1)->orderBy('container_name')->get();
                break;
            case 3:
                $bladeView = 'step-3';
                $countries = Country::where('status', 1)->orderBy('country_name')->get();
                break;
            case 4:
                $bladeView = 'step-4';
                $formulations = Formulation::where('status', 1)->orderBy('formulation_name')->get();
                $commonNames = CommonName::where('status', 1)->orderBy('common_name')->get();
                break;
                // case 5:
                //     $bladeView = 'step-5';
                //     break;
        }

        return view('dataentry.checklists.follow-steps', compact('checklist', 'currentStep', 'bladeView', 'units', 'containers', 'countries', 'commonNames', 'formulations'));
    }

    public function store_checklist_containers(Request $request, Checklist $checklist)
    {
        $validated = $request->validate([
            'container_id' => ['required', 'numeric', 'min:1', 'exists:containers,id'],
            'unit_id' => ['required', 'numeric', 'min:1', 'exists:units,id'],
            'capacity' => ['required', 'string', 'min:0'],
        ]);

        $checklist->check_list_containers()->create($validated);

        return back()->with('success', 'डाटा सफलतापूर्वक थपियो');
    }

    public function destroy_checklist_containers(Checklist $checklist, $checklistContainer)
    {
        $checklistContainer = $checklist->check_list_containers()->where('id', $checklistContainer)->first();
        if (!$checklistContainer) {
            return back()->withError('विवरण मेटाउन सकिएन!');
        }
        $checklistContainer->delete();
        return back()->withSuccess('विवरण सफलतापुर्वक मेटाईएको!');
    }

    public function store_checklist_producer(Request $request, Checklist $checklist)
    {
        $validated = $request->validate([
            'NameofProducer' => ['required', 'string', 'min:0', 'max:255'],
            'Address' => ['required', 'string', 'min:0', 'max:255'],
            'CountryID' => ['required', 'numeric', 'min:1', 'exists:countries,id'],
            'ProducerCountryPanjikaranNo' => ['nullable', 'string', 'min:0', 'max:255'],
        ]);

        $checklist->update($validated);

        return back()->with('success', 'डाटा सफलतापूर्वक थपियो');
    }

    public function destroy_checklist_producer(Checklist $checklist)
    {
        if (!$checklist) {
            return back()->withError('विवरण मेटाउन सकिएन!');
        }
        $checklist->update([
            'NameofProducer' => null,
            'Address' => null,
            'CountryID' => null,
            'ProducerCountryPanjikaranNo' => null,
        ]);
        return back()->withSuccess('विवरण सफलतापुर्वक मेटाईएको!');
    }

    public function store_checklist_formulations(Request $request, Checklist $checklist)
    {
        $validated = $request->validate([
            'common_name_id' => ['required', 'numeric', 'min:1', 'exists:common_names,id'],
            'unit_id' => ['required', 'numeric', 'min:1', 'exists:units,id'],
            'ActiveIngredientValue' => ['required', 'string', 'min:0'],
        ]);

        $validated['formulation_id'] = $checklist->formulation_id;

        $checklist->check_list_formulations()->create($validated);

        return back()->with('success', 'डाटा सफलतापूर्वक थपियो');
    }

    public function destroy_checklist_formulations(Checklist $checklist, $checklistFormulation)
    {
        $checklistFormulation = $checklist->check_list_formulations()->where('id', $checklistFormulation)->first();
        if (!$checklistFormulation) {
            return back()->withError('विवरण मेटाउन सकिएन!');
        }
        $checklistFormulation->delete();
        return back()->withSuccess('विवरण सफलतापुर्वक मेटाईएको!');
    }

    public function store_checklist_date(Request $request, Checklist $checklist)
    {
        $validated = $request->validate([
            'DateOfReceiptInNNSWNep' => ['required', 'string', 'min:10', 'max:10'],
            'ContainerReceiptDate' => ['required', 'string', 'min:10', 'max:10'],
        ]);

        $checklist->update($validated);

        return back()->with('success', 'डाटा सफलतापूर्वक थपियो');
    }

    public function destroy_checklist_date(Checklist $checklist)
    {
        if (!$checklist) {
            return back()->withError('विवरण मेटाउन सकिएन!');
        }
        $checklist->update([
            'DateOfReceiptInNNSWNep' => null,
            'ContainerReceiptDate' => null,
        ]);
        return back()->withSuccess('विवरण सफलतापुर्वक मेटाईएको!');
    }

    public function show(Checklist $checklist)
    {
        return view('dataentry.checklists.show', compact('checklist'));
    }

    public function edit(Checklist $checklist)
    {
        // Check if user can edit
        if (!$this->canEdit($checklist)) {
            return back()->with('error', 'तपाईं यो चेकलिष्ट सम्पादन गर्न सक्नुहुन्न।');
        }

        $formulations = Formulation::orderBy('formulation_name')->get();
        $bishadiTypes = BishadiType::orderBy('prakar')->get();

        return view('dataentry.checklists.edit', compact('checklist', 'formulations', 'bishadiTypes'));
    }

    public function update(Request $request, Checklist $checklist)
    {
        // Check if user can edit
        if (!$this->canEdit($checklist)) {
            return back()->with('error', 'तपाईं यो चेकलिष्ट सम्पादन गर्न सक्नुहुन्न।');
        }

        $request->validate([
            'ImporterName' => 'required|string|max:200',
            'LicenseNo' => 'required|string|max:20',
            'ApplicationType' => 'required|in:0,1',
            'TradeNameOfPesticide' => 'required|string|max:200',
            'formulation_id' => 'required|exists:formulations,id',
            'bishadi_type_id' => 'required|exists:bishadi_types,id',
        ]);

        $checklist->update($request->only([
            'ImporterName',
            'LicenseNo',
            'ApplicationType',
            'TradeNameOfPesticide',
            'formulation_id',
            'bishadi_type_id'
        ]));

        return redirect()->route('dataentry.checklists.index')
            ->with('success', 'डाटा सफलतापूर्वक अपडेट गरियो');
    }

    public function destroy(Checklist $checklist)
    {
        // Check if user can delete
        if (!$this->canEdit($checklist)) {
            return back()->with('error', 'तपाईं यो चेकलिष्ट मेटाउन सक्नुहुन्न।');
        }

        $checklist->delete();
        return redirect()->route('dataentry.checklists.index')
            ->with('success', 'डाटा सफलतापूर्वक मेटाइयो');
    }

    /**
     * Send checklist to verify
     */
    public function sendToVerify(Request $request, Checklist $checklist)
    {
        if (!in_array(auth()->user()->usertype, ['user', 'admin'])) {
            return back()->with('error', 'अमान्य कार्य!');
        }

        if ($checklist->Status != 0) {
            return back()->with('error', 'केवल प्रारम्भिक अवस्थामा रहेका रेकर्डहरू मात्र सिफारीसको लागि पठाउन सकिन्छ।');
        }

        // Check if already sent to verify
        $alreadySent = Notification::where('checklist_id', $checklist->id)
            ->where('action_type', 'send_to_verify')
            ->exists();

        if ($alreadySent) {
            return back()->with('error', 'यो चेकलिष्ट पहिले नै सिफारीसको लागि पठाइसकिएको छ।');
        }

        // Find a verifier user
        $verifier = \App\Models\User::where('usertype', 'verifier')->first();

        if (!$verifier) {
            return back()->with('error', 'कुनै सिफारीसकर्ता फेला परेन!');
        }

        // Create notification
        Notification::create([
            'checklist_id' => $checklist->id,
            'from_user_id' => auth()->id(),
            'to_user_id' => $verifier->id,
            'comment' => 'सिफारीसको लागि पठाइएको',
            'action_type' => 'send_to_verify',
            'status' => 'unread'
        ]);

        return redirect()->route('dataentry.checklists.index')
            ->with('success', 'चेकलिष्ट सफलतापूर्वक सिफारीसको लागि पठाइयो');
    }

    /**
     * Verify the checklist
     */
    public function verify(Checklist $checklist)
    {
        if (auth()->user()->usertype !== 'verifier') {
            abort(403, 'Unauthorized action.');
        }

        // Check if this was sent to verifier
        $sentToVerify = Notification::where('checklist_id', $checklist->id)
            ->where('to_user_id', auth()->id())
            ->where('action_type', 'send_to_verify')
            ->exists();

        if (!$sentToVerify && $checklist->Status != 1) {
            return back()->with('error', 'तपाईं यो चेकलिष्ट सिफारीस गर्न सक्नुहुन्न।');
        }

        $checklist->update([
            'Status' => '1',
            'VerifiedBY' => Auth::id(),
            'VerifiedDate' => now()->format('Y-m-d'),
        ]);

        // Find an approver
        $approver = \App\Models\User::where('usertype', 'approver')->first();

        if ($approver) {
            // Create notification for approver
            Notification::create([
                'checklist_id' => $checklist->id,
                'from_user_id' => auth()->id(),
                'to_user_id' => $approver->id,
                'comment' => 'स्वीकृतिको लागि पठाइएको',
                'action_type' => 'send_to_approve',
                'status' => 'unread'
            ]);
        }

        return redirect()->route('dataentry.checklists.index')
            ->with('success', 'डाटा सफलतापूर्वक प्रमाणित गरियो');
    }

    /**
     * Approve the checklist
     */
    public function approve(Checklist $checklist)
    {
        if (auth()->user()->usertype !== 'approver') {
            abort(403, 'Unauthorized action.');
        }

        if ($checklist->Status != 1) {
            return back()->with('error', 'Only verified records can be approved.');
        }

        try {
            $nextPanjikaranNo = $this->getNextPanjikaranNumber($checklist->id);

            $checklist->update([
                'Status' => '2',
                'ApprovedBy' => Auth::id(),
                'ApprovedDate' => now()->format('Y-m-d'),
                'PanjikaranDecisionNo' => $nextPanjikaranNo,
                'PanjikaranDecisionDate' => now()->format('Y-m-d'),
            ]);

            return redirect()->route('dataentry.checklists.index')
                ->with('success', "डाटा सफलतापूर्वक स्वीकृत गरियो। पंजिकरण नं: {$nextPanjikaranNo}");
        } catch (\Exception $e) {
            return back()->with('error', 'पंजिकरण नं जनरेट गर्न सकिएन: ' . $e->getMessage());
        }
    }

    /**
     * Send checklist back with comment (for both verifier and approver)
     */
    public function sendBack(Request $request, Checklist $checklist)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $userType = auth()->user()->usertype;

        // Determine the target user and new status
        if ($userType == 'verifier') {
            // Send back to the creator
            $targetUserId = $checklist->CreatedBy;

            // Reset status to allow editing
            $checklist->update([
                'Status' => '0',
                'VerifiedBY' => null,
                'VerifiedDate' => null,
            ]);

            // Clear the send_to_verify notification
            Notification::where('checklist_id', $checklist->id)
                ->where('action_type', 'send_to_verify')
                ->delete();
        } elseif ($userType == 'approver' && $checklist->Status == 1) {
            // Send back to the creator (not verifier)
            $targetUserId = $checklist->CreatedBy;

            // Reset to initial state
            $checklist->update([
                'Status' => '0',
                'VerifiedBY' => null,
                'VerifiedDate' => null,
            ]);

            // Clear all verification notifications
            Notification::where('checklist_id', $checklist->id)
                ->whereIn('action_type', ['send_to_verify', 'send_to_approve'])
                ->delete();
        } else {
            return back()->with('error', 'अमान्य कार्य!');
        }

        // Create notification
        Notification::create([
            'checklist_id' => $checklist->id,
            'from_user_id' => auth()->id(),
            'to_user_id' => $targetUserId,
            'comment' => $request->comment,
            'action_type' => 'send_back',
            'status' => 'unread'
        ]);

        return redirect()->route('dataentry.checklists.index')
            ->with('success', 'चेकलिष्ट सफलतापूर्वक फिर्ता पठाइयो।');
    }

    /**
     * Send back from verifier
     */
    public function sendBackVerifier(Request $request, Checklist $checklist)
    {
        return $this->sendBack($request, $checklist);
    }

    /**
     * Send back from approver
     */
    public function sendBackApprover(Request $request, Checklist $checklist)
    {
        return $this->sendBack($request, $checklist);
    }

    /**
     * Get the next Panjikaran number in format: 0001-DB-SR-2025
     */
    private function getNextPanjikaranNumber($checklistId)
    {
        // Get the checklist with relationships
        $checklist = Checklist::with(['bishadiType', 'formulation'])->find($checklistId);

        if (!$checklist) {
            throw new \Exception('Checklist not found');
        }

        // Get the year from created_at
        $year = date('Y', strtotime($checklist->created_at));

        // Get bishadi type code (assuming there's a 'type_code' field in bishadi_types table)
        $bishadiCode = $checklist->bishadiType->type_code;

        // Get formulation code (assuming there's a 'code' field in formulations table)
        $formulationCode = $checklist->formulation->formulation_name ?? $checklist->formulation->formulation_name;

        // If formulation_name is long, take first 2 characters and make uppercase
        if (strlen($formulationCode) > 2) {
            $formulationCode = strtoupper(substr($formulationCode, 0, 2));
        }

        // Find the latest panjikaran number for this specific pattern (same year, type, formulation)
        $pattern = "%-{$bishadiCode}-{$formulationCode}-{$year}";

        $latest = Checklist::whereNotNull('PanjikaranDecisionNo')
            ->where('PanjikaranDecisionNo', 'LIKE', $pattern)
            ->orderBy('PanjikaranDecisionNo', 'desc')
            ->first();

        // Extract the serial number from the latest record
        $nextSerial = 1;
        if ($latest) {
            $parts = explode('-', $latest->PanjikaranDecisionNo);
            if (count($parts) >= 4) {
                $lastSerial = (int)$parts[0];
                $nextSerial = $lastSerial + 1;
            }
        }

        // Format serial number with leading zeros (4 digits)
        $serialFormatted = str_pad($nextSerial, 4, '0', STR_PAD_LEFT);

        // Generate the final panjikaran number
        return "{$serialFormatted}-{$bishadiCode}-{$formulationCode}-{$year}";
    }

    /**
     * Updated print method with all relationships
     */
    public function print($checklistId)
    {
        $checklist = Checklist::with([
            'details',
            'details.checklistItem',
            'creator',           // Load creator relationship
            'verifier',          // Load verifier relationship
            'approver',          // Load approver relationship
            'containers',
            'containers.container',
            'containers.unit',
            'check_list_formulations',
            'check_list_formulations.common_name',
            'country',
            'bishadiType',
            'formulation'
        ])->findOrFail($checklistId);

        return view('dataentry.checklists.print', compact('checklist'));
    }

    /**
     * Show notifications for current user
     */
    public function notifications()
    {
        $notifications = Notification::with(['checklist', 'fromUser'])
            ->where('to_user_id', auth()->id())
            ->has('checklist') // Only include notifications with a checklist
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $checklists = collect();

        return view('dataentry.checklists.notifications', compact('notifications', 'checklists'));
    }

    /**
     * Mark notification as read
     */
    public function markNotificationAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('to_user_id', auth()->id())
            ->first();

        if ($notification) {
            $notification->update(['status' => 'read']);
        }

        return redirect()->back()->with('success', 'सूचना पढिएको रूपमा चिन्ह लगाइयो');
    }

    /**
     * Check if user can edit the checklist
     */
    private function canEdit(Checklist $checklist)
    {
        $userType = auth()->user()->usertype;

        // Admin can always edit if not approved
        if ($userType == 'admin') {
            return $checklist->Status != 2; // Can't edit approved records
        }

        // Only creator can edit and only when status is 0
        if ($userType == 'user' && $checklist->CreatedBy == auth()->id() && $checklist->Status == 0) {
            // Check if not sent to verify
            $sentToVerify = Notification::where('checklist_id', $checklist->id)
                ->where('action_type', 'send_to_verify')
                ->exists();

            return !$sentToVerify;
        }

        return false;
    }

    /**
     * Show parameterized reports page
     */
    public function reports(Request $request)
    {
        $reportType = $request->get('report_by');
        $filterValue = $request->get('filter_value');

        $checklists = collect();
        $reportData = [];

        // Get filter options based on report type
        if ($reportType) {
            switch ($reportType) {
                case 'country':
                    $reportData = \App\Models\Country::all();
                    break;
                case 'formulation':
                    $reportData = \App\Models\Formulation::all();
                    break;
                case 'bishaditype':
                    $reportData = \App\Models\BishadiType::all();
                    break;
                case 'commonname':
                    $reportData = \App\Models\CommonName::all();
                    break;
                case 'unit':
                    $reportData = \App\Models\Unit::all();
                    break;
            }
        }

        // Get filtered checklists if filter value is selected
        if ($reportType && $filterValue) {
            $query = \App\Models\Checklist::with(['country', 'creator', 'verifier', 'approver']);

            switch ($reportType) {
                case 'country':
                    $query->where('CountryID', $filterValue);
                    break;
                case 'formulation':
                    $query->whereHas('check_list_formulations', function($q) use ($filterValue) {
                        $q->where('formulation_id', $filterValue);
                    });
                    break;
                case 'bishaditype':
                    $query->where('bishadi_type_id', $filterValue);
                    break;
                case 'commonname':
                    $query->whereHas('check_list_formulations', function($q) use ($filterValue) {
                        $q->where('common_name_id', $filterValue);
                    });
                    break;
                case 'unit':
                    $query->whereHas('check_list_formulations', function($q) use ($filterValue) {
                        $q->where('unit_id', $filterValue);
                    });
                    break;
            }

            $checklists = $query->orderBy('created_at', 'desc')->get();
        }

        return view('dataentry.checklists.reports', compact(
            'reportType',
            'filterValue',
            'reportData',
            'checklists'
        ));
    }
}
