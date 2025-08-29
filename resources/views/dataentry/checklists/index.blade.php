@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">पेश गर्ने व्यक्ति, संस्था वा निकायको विवरण</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">सूची</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if (in_array(auth()->user()->usertype, ['admin', 'user']))
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <a href="{{ route('dataentry.checklists.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> नयाँ थप्नुहोस्
                                </a>
                            </div>
                        </div>
                    @endif

                    <table class="table align-middle datatable dt-responsive table-check nowrap">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="5%">क्र.सं.</th>
                                <th width="20%">पेश गर्ने व्यक्ति, संस्था वा निकायको नाम</th>
                                <th width="10%">इजाजतपत्र नं.</th>
                                <th width="10%">आवेदनको प्रकार</th>
                                <th width="15%">स्थिति</th>
                                <th width="15%">जीवनाशक विषादीको ब्यापारिक नाम</th>
                                <th width="25%">कार्यहरू</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($checklists as $sn => $checklist)
                                @php
                                    $userType = auth()->user()->usertype;
                                    $isSentToVerify = \App\Models\Notification::where('checklist_id', $checklist->id)
                                        ->where('action_type', 'send_to_verify')
                                        ->exists();

                                    $latestComment = \App\Models\Notification::where('checklist_id', $checklist->id)
                                        ->where('to_user_id', auth()->id())
                                        ->where('action_type', 'send_back')
                                        ->latest()
                                        ->first();

                                    $canEdit = false;
                                    if ($userType == 'admin') {
                                        $canEdit = $checklist->Status == 0 && !$isSentToVerify;
                                    } elseif ($userType == 'user') {
                                        $canEdit =
                                            $checklist->CreatedBy == auth()->id() &&
                                            $checklist->Status == 0 &&
                                            !$isSentToVerify;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>
                                        <a
                                            href="{{ route('dataentry.checklists.follow-steps', [$checklist->id, 'step=2']) }}">
                                            {{ $checklist->ImporterName }}
                                        </a>
                                    </td>
                                    <td>{{ $checklist->LicenseNo }}</td>
                                    <td>{{ checklistType($checklist->ApplicationType) }}</td>
                                    <td>
                                        @if ($checklist->Status == 0)
                                            @if ($isSentToVerify)
                                                <span class="badge bg-warning">सिफारीसको प्रतीक्षामा</span>
                                            @else
                                                <span class="badge bg-secondary">प्रारम्भिक दर्ता</span>
                                            @endif
                                        @elseif($checklist->Status == 1)
                                            <span class="badge bg-primary">सिफारीस भएको</span>
                                        @elseif($checklist->Status == 2)
                                            <span class="badge bg-success">स्वीकृत भएको</span>
                                        @endif

                                        @if ($latestComment)
                                            <br><small class="text-danger"><i class="fas fa-comment"></i>
                                                {{ $latestComment->comment }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $checklist->TradeNameOfPesticide }}</td>
                                    <td>
                                        <!-- <a class="dropdown-item" href="{{ route('panjikarans.index', $checklist->id) }}">
                                <i class="fas fa-list"></i> पंजीकरण हेर्नुहोस्
                            </a> -->
                                        <!-- View Button - Always visible -->
                                        <a href="{{ route('dataentry.checklists.show', $checklist->id) }}"
                                            class="btn btn-info btn-sm" title="हेर्नुहोस्">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- Print Button - Always visible -->
                                        <a href="{{ route('dataentry.checklists.print', $checklist->id) }}"
                                            class="btn btn-secondary btn-sm" title="प्रिन्ट गर्नुहोस्">
                                            <i class="fa fa-print"></i>
                                        </a>

                                        <!-- User Type: user/admin -->
                                        @if (in_array($userType, ['admin', 'user']))
                                            @if ($canEdit)
                                                <!-- Edit Button -->
                                                <a href="{{ route('dataentry.checklists.edit', $checklist->id) }}"
                                                    class="btn btn-success btn-sm" title="सम्पादन गर्नुहोस्">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('dataentry.checklists.destroy', $checklist->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')"
                                                        title="मेट्नुहोस्">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>

                                                <!-- Send to Verify Button -->
                                                <form
                                                    action="{{ route('dataentry.checklists.send-to-verify', $checklist->id) }}"
                                                    method="POST" style="display: inline-block;"
                                                    onsubmit="return confirm('तपाईं यो चेकलिष्ट सिफारीसको लागि पठाउन चाहानुहुन्छ?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm"
                                                        title="सिफारीसको लागि पठाउनुहोस्">
                                                        <i class="fa fa-paper-plane"></i> सिफारीसको लागि
                                                    </button>
                                                </form>
                                            @else
                                                <!-- When sent to verify or after, show disabled buttons -->
                                                @if ($isSentToVerify && $checklist->Status == 0)
                                                    <button class="btn btn-secondary btn-sm" disabled
                                                        title="सम्पादन गर्न सकिँदैन">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-secondary btn-sm" disabled title="मेट्न सकिँदैन">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endif
                                            @endif

                                            <!-- Details Button -->
                                            <a href="{{ route('dataentry.checklists.details.index', $checklist->id) }}"
                                                class="btn btn-info btn-sm" title="विवरण">
                                                <i class="fa fa-list"></i>
                                            </a>
                                        @endif

                                        <!-- User Type: verifier -->
                                        @if ($userType == 'verifier')
                                            @php
                                                $sentToMe = \App\Models\Notification::where(
                                                    'checklist_id',
                                                    $checklist->id,
                                                )
                                                    ->where('to_user_id', auth()->id())
                                                    ->where('action_type', 'send_to_verify')
                                                    ->exists();
                                            @endphp

                                            @if ($sentToMe && $checklist->Status == 0)
                                                <!-- Verify Button -->
                                                <form action="{{ route('dataentry.checklists.verify', $checklist->id) }}"
                                                    method="POST" style="display: inline-block;"
                                                    onsubmit="return confirm('तपाईं यो विवरण सिफारीस गर्न चाहानुहुन्छ?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm"
                                                        title="सिफारीस गर्नुहोस्">
                                                        <i class="fa fa-check"></i> सिफारीस
                                                    </button>
                                                </form>

                                                <!-- Send Back Button -->
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="showSendBackModal({{ $checklist->id }}, 'verifier')"
                                                    title="फिर्ता पठाउनुहोस्">
                                                    <i class="fa fa-arrow-left"></i> फिर्ता
                                                </button>
                                            @endif
                                        @endif

                                        <!-- User Type: approver -->
                                        @if ($userType == 'approver' && $checklist->Status == 1)
                                            <!-- Approve Button -->
                                            <form action="{{ route('dataentry.checklists.approve', $checklist->id) }}"
                                                method="POST" style="display: inline-block;"
                                                onsubmit="return confirm('तपाईं यो विवरण स्वीकृत गर्न चाहानुहुन्छ?')">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm"
                                                    title="स्वीकृत गर्नुहोस्">
                                                    <i class="fa fa-thumbs-up"></i> स्वीकृत
                                                </button>
                                            </form>

                                            <!-- Send Back Button -->
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="showSendBackModal({{ $checklist->id }}, 'approver')"
                                                title="फिर्ता पठाउनुहोस्">
                                                <i class="fa fa-arrow-left"></i> फिर्ता
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Send Back Modal -->
    <div class="modal fade" id="sendBackModal" tabindex="-1" aria-labelledby="sendBackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendBackModalLabel">फिर्ता पठाउने कारण</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sendBackForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="comment" class="form-label">टिप्पणी लेख्नुहोस्:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="4" required
                                placeholder="फिर्ता पठाउने कारण यहाँ लेख्नुहोस्..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">रद्द गर्नुहोस्</button>
                        <button type="submit" class="btn btn-danger">फिर्ता पठाउनुहोस्</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function showSendBackModal(checklistId, userType) {
            const modal = document.getElementById('sendBackModal');
            const form = document.getElementById('sendBackForm');
            form.action = `/dataentry/checklists/${checklistId}/send-back`;

            // Use Bootstrap modal
            if (typeof bootstrap !== 'undefined') {
                // Bootstrap 5
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            } else if (typeof $ !== 'undefined') {
                // Bootstrap 4 with jQuery
                $(modal).modal('show');
            }
        }
    </script>
@endsection
