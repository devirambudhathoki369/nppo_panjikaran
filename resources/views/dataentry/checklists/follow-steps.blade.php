@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">पेश गर्ने व्यक्ति, संस्था वा निकायको विवरण</h4>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="20%">पेश गर्ने व्यक्ति, संस्था वा निकायको नाम:</th>
                                        <td width="50%">{{ $checklist->ImporterName }}</td>
                                        <th width="10%">इजाजतपत्र नं.:</th>
                                        <td width="20%">{{ $checklist->LicenseNo }}</td>
                                    </tr>
                                    <tr>
                                        <th>आवेदनको प्रकार:</th>
                                        <td>{{ checklistType($checklist->ApplicationType) }}</td>
                                        <th>स्थिति:</th>
                                        <td>{!! checklistStatus($checklist->Status) !!}</td>
                                    </tr>

                                    @if ($checklist->CreatedBy)
                                        <tr>
                                            <th>दर्ता गर्ने:</th>
                                            <td colspan="3">
                                                {{ $checklist->creator->name }} <br>
                                                मितिः {{ $checklist->CreatedDateNepali }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($checklist->VerifiedBY)
                                        <tr>
                                            <th>प्रमाणित गर्ने:</th>
                                            <td colspan="3">
                                                {{ $checklist->verifier->name }} <br>
                                                मितिः {{ $checklist->VerifiedDateNepali }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($checklist->ApprovedBy)
                                        <tr>
                                            <th>स्वीकृत गर्ने:</th>
                                            <td colspan="3">
                                                {{ $checklist->approver->name }} <br>
                                                मितिः {{ $checklist->ApprovedDateNepali }}
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <th> जीवनाशक विषादीको ब्यापारिक नाम</th>
                                        <td> {{ $checklist->TradeNameOfPesticide }}</td>
                                        <th>फर्मुलेशन:</th>
                                        <td>{{ $checklist->formulation->formulation_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>बिषादिको प्रकार:</th>
                                        <td colspan="3">{{ $checklist->bishadiType->prakar ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    @php
                        $currentStep = request()->query('step', '2');
                        $stepNames = [
                            2 => 'चेकलिष्ट कन्टेनर विवरण',
                            3 => 'उत्पादनकर्ताको विवरण',
                            4 => 'जीवनाशक विषादीको चेकलिष्ट विवरण',
                        ];
                    @endphp

                    <div class="row">
                        <div class="col-12">
                            <div class="step-buttons mb-3 d-flex flex-wrap gap-2">
                                @foreach (range(2, 4) as $step)
                                    <a href="{{ route('dataentry.checklists.follow-steps', [$checklist->id, 'step' => $step]) }}"
                                        class="btn btn-sm {{ $currentStep == $step ? 'btn-primary active' : 'btn-outline-primary' }}">
                                        {{ $stepNames[$step] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            @include('dataentry.checklists.form-step.' . $bladeView, [
                                'checklist' => $checklist,
                                'units' => $units,
                                'containers' => $containers,
                                'countries' => $countries,
                                'formulations' => $formulations,
                                'commonNames' => $commonNames,
                            ])
                        </div>
                    </div>

                    {{-- @if($currentStep == 4)
                        <div class="row mt-3 justify-between">
                            <div class="col-md-6">
                                <a href="{{ route('dataentry.checklists.follow-steps', [$checklist->id, 'step=3']) }}"
                                    class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> फिर्ता जानुहोस्
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('dataentry.checklists.show', $checklist) }}" class="float-end btn btn-primary">
                                    अगाडी बढ्ने <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>

    <style>
        .step-buttons .btn {
            white-space: nowrap;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        .step-buttons .btn.active {
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 123, 255, .5);
        }

        @media (max-width: 768px) {
            .step-buttons {
                flex-direction: column;
            }

            .step-buttons .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>
@endsection
