@extends('layouts.base')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header {
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
        }

        .pre-table-text {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .action-buttons {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 20px;
            }
        }
    </style>

    <!-- Text above table matching the uploaded image -->
    <div class="pre-table-text text-center">
        <p><strong>नेपाल सरकार<br>
                कृषि तथा पशुपक्षी विकास मन्त्रालय<br>
                प्लान्ट क्वारेन्टाइन तथा विषादी व्यवस्थापन केन्द्र<br>
                हरिहरभवन, ललितपुर</strong></p>

        <p>जीवनाशक विषादी व्यवस्थापन ऐन, २०७६ को दफा ३ (१) र जीवनाशक विषादी व्यवस्थापन नियमावली, २०७९ को नियम ३ को उपनियम
            (१) र सोहि नियमको उपनियम (४) बमोजिम केन्द्रमा नेपाल राष्ट्रिय एकीकृत प्रणालीबाट र सकले सूचकपत्र, कन्टेनर र
            नेपाली भाषामा लेखिएको विवरणको अभिलेखिकरणको ढाँचा</p>

        <p><strong>पञ्जीकरण निर्णाय मिति:</strong> {{ $checklist->currentStatusDateNep() }}<br>
            <strong>पञ्जीकरण निर्णाय नं:</strong> {{ $checklist->PanjikaranDecisionNo ?? 'N/A' }}
        </p>
    </div>

    <!-- Action Buttons Section (No Print) -->
    <div class="action-buttons no-print">
        <h5>कार्यहरू:</h5>
        <div class="btn-group" role="group">
            @php
                // Get user type and determine permissions
                $userType = auth()->user()->usertype ?? 'user';

                // Check if checklist is sent to verify
                $isSentToVerify = \App\Models\Notification::where('checklist_id', $checklist->id)
                    ->where('action_type', 'send_to_verify')
                    ->exists();

                // Check if user can edit (not sent to verify and status is 0)
                $canEdit = !$isSentToVerify && $checklist->Status == 0;
            @endphp

            <!-- User Type: user/admin -->
            @if (in_array($userType, ['admin', 'user']))
                @if ($canEdit)
                    <!-- Send to Verify Button -->
                    <form action="{{ route('dataentry.checklists.send-to-verify', $checklist->id) }}" method="POST"
                        style="display: inline-block;"
                        onsubmit="return confirm('तपाईं यो चेकलिष्ट सिफारीसको लागि पठाउन चाहानुहुन्छ?')">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm" title="सिफारीसको लागि पठाउनुहोस्">
                            <i class="fa fa-paper-plane"></i> सिफारीसको लागि पठाउनुहोस्
                        </button>
                    </form>
                @endif
            @endif

            <!-- User Type: verifier -->
            @if ($userType == 'verifier')
                @php
                    $sentToMe = \App\Models\Notification::where('checklist_id', $checklist->id)
                        ->where('to_user_id', auth()->id())
                        ->where('action_type', 'send_to_verify')
                        ->exists();
                @endphp

                @if ($sentToMe && $checklist->Status == 0)
                    <!-- Verify Button -->
                    <form action="{{ route('dataentry.checklists.verify', $checklist->id) }}" method="POST"
                        style="display: inline-block;"
                        onsubmit="return confirm('तपाईं यो विवरण सिफारीस गर्न चाहानुहुन्छ?')">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm" title="सिफारीस गर्नुहोस्">
                            <i class="fa fa-check"></i> सिफारीस गर्नुहोस्
                        </button>
                    </form>

                    <!-- Send Back Button -->
                    <button type="button" class="btn btn-danger btn-sm"
                        onclick="showSendBackModal({{ $checklist->id }}, 'verifier')" title="फिर्ता पठाउनुहोस्">
                        <i class="fa fa-arrow-left"></i> फिर्ता पठाउनुहोस्
                    </button>
                @endif
            @endif

            <!-- User Type: approver -->
            @if ($userType == 'approver' && $checklist->Status == 1)
                <!-- Approve Button -->
                <form action="{{ route('dataentry.checklists.approve', $checklist->id) }}" method="POST"
                    style="display: inline-block;" onsubmit="return confirm('तपाईं यो विवरण स्वीकृत गर्न चाहानुहुन्छ?')">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm" title="स्वीकृत गर्नुहोस्">
                        <i class="fa fa-thumbs-up"></i> स्वीकृत गर्नुहोस्
                    </button>
                </form>

                <!-- Send Back Button -->
                <button type="button" class="btn btn-danger btn-sm"
                    onclick="showSendBackModal({{ $checklist->id }}, 'approver')" title="फिर्ता पठाउनुहोस्">
                    <i class="fa fa-arrow-left"></i> फिर्ता पठाउनुहोस्
                </button>
            @endif
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="5%" rowspan="2">क्र.सं.</th>
                <th width="35%" rowspan="2">विवरण</th>
                <th width="25%" rowspan="2">चेकलिष्ट बुँदा</th>
                <th colspan="4" style="text-align: center">रितपूर्वकको सबै विवरण</th>
            </tr>
            <tr>
                <th width="10%">छ</th>
                <th width="10%">छैन</th>
                <th width="15%">कैफियत</th>
                <th width="15%">माध्यम</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>पेश गर्ने व्याक्ति, संस्था वा निकायको नाम</td>
                <td>{{ $checklist->ImporterName ?? '' }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td> इजाजतपत्र नं. </td>
                <td>{{ $checklist->LicenseNo ?? '' }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            @php
                $type0Items = $checklist->details->filter(function ($detail) {
                    return $detail->checklistItem->Type == '0';
                });
                $type1Items = $checklist->details->filter(function ($detail) {
                    return $detail->checklistItem->Type == '1';
                });
                $type2Items = $checklist->details->filter(function ($detail) {
                    return $detail->checklistItem->Type == '2';
                });

                // Function to get medium text based on SourceOfDocument value
                function getMediumText($sourceValue)
                {
                    switch ($sourceValue) {
                        case 0:
                            return 'N/A';
                        case 1:
                            return 'हार्डकपी';
                        case 2:
                            return 'एनएनएसडब्लु';
                        case 3:
                            return 'कार्यालयको अभिलेख';
                        default:
                            return 'N/A';
                    }
                }
            @endphp

            <!-- Type 0 Items -->
            @if ($type0Items->count() > 0)
                <tr>
                    <td rowspan="{{ $type0Items->count() }}">3</td>
                    <td rowspan="{{ $type0Items->count() }}">केन्द्रमा इजाजतपत्र दिदाको सुरुवातको अभिलेख र नेपाल राष्ट्रिय
                        एकीकृत प्रणालीबाट प्राप्त विवरण (जीवनाशक विषादी पैठारीकर्ताको हकमा)</td>
                    <td>{{ $type0Items->first()->checklistItem->CheckListItem ?? '' }}</td>
                    <td class="text-center">
                        @if ($type0Items->first()->DocumentStatus == 0)
                            छ
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($type0Items->first()->DocumentStatus == 1)
                            छैन
                        @endif
                    </td>
                    <td>{{ $type0Items->first()->Remarks ?? '' }}</td>
                    <td>{{ getMediumText($type0Items->first()->SourceOfDocument) }}</td>
                </tr>
                @foreach ($type0Items->skip(1) as $detail)
                    <tr>
                        <td>{{ $detail->checklistItem->CheckListItem ?? '' }}</td>
                        <td class="text-center">
                            @if ($detail->DocumentStatus == 0)
                                छ
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($detail->DocumentStatus == 1)
                                छैन
                            @endif
                        </td>
                        <td>{{ $detail->Remarks ?? '' }}</td>
                        <td>{{ getMediumText($detail->SourceOfDocument) }}</td>
                    </tr>
                @endforeach
            @endif

            <!-- Type 1 Items -->
            @if ($type1Items->count() > 0)
                <tr>
                    <td rowspan="{{ $type1Items->count() }}">4</td>
                    <td rowspan="{{ $type1Items->count() }}">केन्द्रमा इजाजतपत्र दिदाको सुरुवातको अभिलेख र नेपाल राष्ट्रिय
                        एकीकृत प्रणालीबाट प्राप्त विवरण (उत्पादक / संश्लेषण / प्याकेजिङ्ग)</td>
                    <td>{{ $type1Items->first()->checklistItem->CheckListItem ?? '' }}</td>
                    <td class="text-center">
                        @if ($type1Items->first()->DocumentStatus == 0)
                            छ
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($type1Items->first()->DocumentStatus == 1)
                            छैन
                        @endif
                    </td>
                    <td>{{ $type1Items->first()->Remarks ?? '' }}</td>
                    <td>{{ getMediumText($type1Items->first()->SourceOfDocument) }}</td>
                </tr>
                @foreach ($type1Items->skip(1) as $detail)
                    <tr>
                        <td>{{ $detail->checklistItem->CheckListItem ?? '' }}</td>
                        <td class="text-center">
                            @if ($detail->DocumentStatus == 0)
                                छ
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($detail->DocumentStatus == 1)
                                छैन
                            @endif
                        </td>
                        <td>{{ $detail->Remarks ?? '' }}</td>
                        <td>{{ getMediumText($detail->SourceOfDocument) }}</td>
                    </tr>
                @endforeach
            @endif

            <!-- Type 2 Items -->
            @if ($type2Items->count() > 0)
                <tr>
                    <td rowspan="{{ $type2Items->count() }}">5</td>
                    <td rowspan="{{ $type2Items->count() }}">केन्द्रमा इजाजतपत्र दिदाको सुरुवातको अभिलेख र नेपाल राष्ट्रिय
                        एकीकृत प्रणालीबाट प्राप्त विवरण (दुवै)</td>
                    <td>{{ $type2Items->first()->checklistItem->CheckListItem ?? '' }}</td>
                    <td class="text-center">
                        @if ($type2Items->first()->DocumentStatus == 0)
                            छ
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($type2Items->first()->DocumentStatus == 1)
                            छैन
                        @endif
                    </td>
                    <td>{{ $type2Items->first()->Remarks ?? '' }}</td>
                    <td>{{ getMediumText($type2Items->first()->SourceOfDocument) }}</td>
                </tr>
                @foreach ($type2Items->skip(1) as $detail)
                    <tr>
                        <td>{{ $detail->checklistItem->CheckListItem ?? '' }}</td>
                        <td class="text-center">
                            @if ($detail->DocumentStatus == 0)
                                छ
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($detail->DocumentStatus == 1)
                                छैन
                            @endif
                        </td>
                        <td>{{ $detail->Remarks ?? '' }}</td>
                        <td>{{ getMediumText($detail->SourceOfDocument) }}</td>
                    </tr>
                @endforeach
            @endif

            <tr>
                <td>6</td>
                <td>सवै व्यावसायीको हकमा विभिन्न प्रकारको कन्टेनरका किसिम र क्षमता (परिमाण)</td>
                <td>
                    @if ($checklist->containers && $checklist->containers->count() > 0)
                        @foreach ($checklist->containers as $index => $containerData)
                            {{ $index + 1 }}.
                            {{ $containerData->container->container_name ?? 'N/A' }}({{ $containerData->capacity ?? '0' }}
                            {{ $containerData->unit->unit_name ?? 'N/A' }})
                            @if (!$loop->last)
                                <br>
                            @endif
                        @endforeach
                    @else
                        कुनै कन्टेनर जानकारी उपलब्ध छैन
                    @endif
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>7</td>
                <td>जीवनाशक विषादीको व्यापारिक नाम:</td>
                <td>
                    {{ $checklist->TradeNameOfPesticide ?? '' }}
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>8</td>
                <td>जीवनाशक विषादीको साधारण नाम: (सक्रिय अंश र संश्लेषण सहित)</td>
                <td>
                    @foreach ($checklist->check_list_formulations as $formulationItem)
                        {{ $formulationItem->common_name->common_name }}@if (!$loop->last)
                            ,
                        @endif
                    @endforeach

                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>8</td>
                <td>जीवनाशक देशको पञ्जीकरण नं. </td>
                <td>
                    {{ $checklist->ProducerCountryPanjikaranNo ?? '' }}
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>9</td>
                <td>उत्पादकको नाम र ठेगाना </td>
                <td>
                    {{ $checklist->NameofProducer ?? '' }} ( {{ $checklist->Address }})
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Legal text paragraph (from uploaded image) -->
    <div style="margin: 20px 0; line-height: 1.6;">
        <p>जीवनाशक विषादी व्यवस्थापन ऐन, २०७६ को दफा ३ (१) र जीवनाशक विषादी व्यवस्थापन नियमावली, २०७९
            को नियम ३ को उपनियम (१) र सोहि नियमको उपनियम (४) बमोजिम केन्द्रमा नेपाल राष्ट्रिय एकीकृत प्रणालीबाट र
            साकले सूचकपत्र, कन्टेनर र नेपाली भाषामा लेखिएको विवरणको अभिलेखिकरणका लागि</p>
    </div>

    <!-- Signature Table (matching the uploaded image) -->
    <div style="margin-top: 30px;">
        <table class="table">
            <thead>
                <tr>
                    <th style="text-align: center;">विवरण सिफारीस गर्ने अधिकारी:</th>
                    <th style="text-align: center;">सिफारिस गर्ने अधिकारी:</th>
                    <th style="text-align: center;">पञ्जीकरण गर्ने अधिकारीको:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 20px;">
                        <strong>नाम:</strong> {{ $checklist->creator->name ?? '' }}<br><br>
                        <strong>पद:</strong> {{ $checklist->creator->designation ?? '' }}
                    </td>
                    <td style="padding: 20px;">
                        <strong>नाम:</strong> {{ $checklist->verifier->name ?? '' }}<br><br>
                        <strong>पद:</strong> {{ $checklist->verifier->designation ?? '' }}
                    </td>
                    <td style="padding: 20px;">
                        <strong>नाम:</strong> {{ $checklist->approver->name ?? '' }}<br><br>
                        <strong>पद:</strong> {{ $checklist->approver->designation ?? '' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="no-print text-center" style="margin-top: 20px;">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fa fa-print"></i> प्रिन्ट गर्नुहोस्
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            <i class="fa fa-times"></i> बन्द गर्नुहोस्
        </button>
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

    <!-- JavaScript for Send Back Modal -->
    <script>
        function showSendBackModal(checklistId, userType) {
            const modal = new bootstrap.Modal(document.getElementById('sendBackModal'));
            const form = document.getElementById('sendBackForm');

            // Set the form action URL based on user type
            if (userType === 'verifier') {
                form.action = `{{ url('dataentry/checklists') }}/${checklistId}/send-back-verifier`;
            } else if (userType === 'approver') {
                form.action = `{{ url('dataentry/checklists') }}/${checklistId}/send-back-approver`;
            }

            // Show the modal
            modal.show();
        }
    </script>
@endsection
