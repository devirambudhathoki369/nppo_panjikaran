@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">चेकलिष्ट डिटेल विवरण</h4>

                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table">
                                <tr>
                                    <th width="30%">पेश गर्ने व्यक्ति, संस्था वा निकायको नाम</th>
                                    <th width="15%">इजाजतपत्र नं.</th>
                                    <th width="15%">आवेदनको प्रकार</th>
                                    <th width="15%">स्थिति</th>
                                    <th width="15%">सम्बन्धित प्रयोगकर्ता</th>
                                </tr>
                                <tr>
                                    <td>{{ $detail->checklist->ImporterName }}</td>
                                    <td>{{ $detail->checklist->LicenseNo }}</td>
                                    <td>{{ checklistType($detail->checklist->ApplicationType) }}</td>
                                    <td>{!! checklistStatus($detail->checklist->Status) !!}</td>
                                    <td>{{ $detail->checklist->currentStatusUser() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">चेकलिष्ट नं.:</label>
                            <p class="form-control-static">{{ $detail->checklist->PanjikaranDecisionNo ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-9 mb-3">
                            <label class="form-label">चेकलिष्ट बुँदा:</label>
                            <p class="form-control-static">
                                {{ $detail->checklistItem->CheckListItem }}
                                ({{ $detail->checklistItem->type_text }})
                            </p>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">कागजातको स्थिति:</label>
                            <p class="form-control-static">
                                <span class="badge bg-{{ $detail->DocumentStatus == 0 ? 'success' : 'danger' }}">
                                    {{ DocumentStatus($detail->DocumentStatus) }}
                                </span>
                            </p>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">कैफियत:</label>
                            <p class="form-control-static">{{ $detail->Remarks }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">अन्तिम अपडेट मिति:</label>
                            <p class="form-control-static">{{ $detail->updated_at->format('Y-m-d') }}</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <a href="{{ route('dataentry.checklists.details.index', $detail->ChecklistID) }}"
                                class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> फिर्ता जानुहोस्
                            </a>
                            @if ($detail->checklist->Status == 0 || auth()->user()->usertype == 'admin')
                                <a href="{{ route('dataentry.checklists.details.edit', [$detail->ChecklistID, $detail->id]) }}"
                                    class="btn btn-primary">
                                    <i class="fa fa-edit"></i> सम्पादन गर्नुहोस्
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
