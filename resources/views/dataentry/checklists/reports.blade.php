@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">पारामिटर रिपोर्ट</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dataentry.checklists.index') }}">चेकलिस्ट</a></li>
                        <li class="breadcrumb-item active">रिपोर्ट</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Report Filter Form -->
                    <form method="GET" action="{{ route('dataentry.checklists.reports') }}" id="reportForm">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" id="report_by" name="report_by" onchange="loadFilterOptions()" required>
                                        <option value="">रिपोर्ट प्रकार छान्नुहोस्</option>
                                        <option value="country" {{ $reportType == 'country' ? 'selected' : '' }}>देश</option>
                                        <option value="formulation" {{ $reportType == 'formulation' ? 'selected' : '' }}>फॉर्मुलेशन</option>
                                        <option value="bishaditype" {{ $reportType == 'bishaditype' ? 'selected' : '' }}>बिषादी प्रकार</option>
                                        <option value="commonname" {{ $reportType == 'commonname' ? 'selected' : '' }}>सामान्य नाम</option>
                                        <option value="unit" {{ $reportType == 'unit' ? 'selected' : '' }}>एकाइ</option>
                                    </select>
                                    <label for="report_by">रिपोर्ट प्रकार</label>
                                </div>
                            </div>

                            @if($reportType && $reportData->count() > 0)
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="filter_value" name="filter_value" onchange="submitForm()" required>
                                            <option value="">छान्नुहोस्</option>
                                            @foreach($reportData as $item)
                                                @php
                                                    $displayName = '';
                                                    $itemId = $item->id;

                                                    switch($reportType) {
                                                        case 'country':
                                                            $displayName = $item->country_name ?? 'N/A';
                                                            break;
                                                        case 'formulation':
                                                            $displayName = $item->formulation_name ?? 'N/A';
                                                            break;
                                                        case 'bishaditype':
                                                            $displayName = $item->prakar ?? 'N/A';
                                                            break;
                                                        case 'commonname':
                                                            $displayName = $item->common_name ?? 'N/A';
                                                            break;
                                                        case 'unit':
                                                            $displayName = $item->unit_name ?? 'N/A';
                                                            break;
                                                    }
                                                @endphp
                                                <option value="{{ $itemId }}" {{ $filterValue == $itemId ? 'selected' : '' }}>
                                                    {{ $displayName }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="filter_value">
                                            @switch($reportType)
                                                @case('country') देश छान्नुहोस् @break
                                                @case('formulation') फॉर्मुलेशन छान्नुहोस् @break
                                                @case('bishaditype') बिषादी प्रकार छान्नुहोस् @break
                                                @case('commonname') सामान्य नाम छान्नुहोस् @break
                                                @case('unit') एकाइ छान्नुहोस् @break
                                                @default छान्नुहोस्
                                            @endswitch
                                        </label>
                                    </div>
                                </div>

                                @if($filterValue && $checklists->count() > 0)
                                    <div class="col-md-4">
                                        <div class="alert alert-info text-center">
                                            <i class="fa fa-info-circle"></i>
                                            परिणामहरू तल देखाइएको छ। व्यक्तिगत प्रिन्टको लागि तालिकामा प्रिन्ट बटन प्रयोग गर्नुहोस्।
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </form>

                    <!-- Results Table -->
                    @if($reportType && $filterValue && $checklists->count() > 0)
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    रिपोर्ट परिणाम:
                                    @switch($reportType)
                                        @case('country') देश @break
                                        @case('formulation') फॉर्मुलेशन @break
                                        @case('prakar') बिषादी प्रकार @break
                                        @case('commonname') सामान्य नाम @break
                                        @case('unit') एकाइ @break
                                    @endswitch
                                    अनुसार
                                </h5>
                                <span class="badge bg-info">कुल {{ $checklists->count() }} रेकर्ड</span>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle table-bordered table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th width="5%">क्र.सं.</th>
                                            <th width="20%">पेश गर्ने व्यक्ति, संस्था वा निकायको नाम</th>
                                            <th width="10%">इजाजतपत्र नं.</th>
                                            <th width="10%">आवेदनको प्रकार</th>
                                            <th width="15%">स्थिति</th>
                                            <th width="20%">जीवनाशक विषादीको ब्यापारिक नाम</th>
                                            <th width="20%">कार्यहरू</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($checklists as $sn => $checklist)
                                            <tr>
                                                <td>{{ ++$sn }}</td>
                                                <td>{{ $checklist->ImporterName }}</td>
                                                <td>{{ $checklist->LicenseNo }}</td>
                                                <td>{{ checklistType($checklist->ApplicationType) }}</td>
                                                <td>
                                                    @if ($checklist->Status == 0)
                                                        <span class="badge bg-secondary">प्रारम्भिक दर्ता</span>
                                                    @elseif($checklist->Status == 1)
                                                        <span class="badge bg-primary">सिफारीस भएको</span>
                                                    @elseif($checklist->Status == 2)
                                                        <span class="badge bg-success">स्वीकृत भएको</span>
                                                    @endif
                                                </td>
                                                <td>{{ $checklist->TradeNameOfPesticide }}</td>
                                                <td>
                                                    <!-- View Button -->
                                                    <a href="{{ route('dataentry.checklists.show', $checklist->id) }}"
                                                        class="btn btn-info btn-sm" title="हेर्नुहोस्">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <!-- Print Button -->
                                                    <a href="{{ route('dataentry.checklists.print', $checklist->id) }}"
                                                       target="_blank" class="btn btn-secondary btn-sm" title="प्रिन्ट गर्नुहोस्">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @elseif($reportType && $filterValue && $checklists->count() == 0)
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <h5>कुनै डाटा फेला परेन</h5>
                            <p>छानिएको मापदण्डमा कुनै चेकलिस्ट रेकर्ड उपलब्ध छैन।</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function loadFilterOptions() {
        const reportType = document.getElementById('report_by').value;
        if (reportType) {
            // Clear filter value and submit to load options
            document.getElementById('reportForm').submit();
        }
    }

    function submitForm() {
        document.getElementById('reportForm').submit();
    }
</script>
@endsection
