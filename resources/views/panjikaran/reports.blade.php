@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">पञ्जीकरण पारामिटर रिपोर्ट</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikarans.index') }}">पञ्जीकरण</a></li>
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
                    <form method="GET" action="{{ route('panjikarans.reports') }}" id="reportForm">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" id="report_by" name="report_by" onchange="loadFilterOptions()" required>
                                        <option value="">रिपोर्ट प्रकार छान्नुहोस्</option>
                                        <option value="source" {{ $reportType == 'source' ? 'selected' : '' }}>स्रोत</option>
                                        <option value="objective" {{ $reportType == 'objective' ? 'selected' : '' }}>उद्देश्य</option>
                                        <option value="usage" {{ $reportType == 'usage' ? 'selected' : '' }}>उपयोग</option>
                                        <option value="unit" {{ $reportType == 'unit' ? 'selected' : '' }}>एकाइ</option>
                                        <option value="packagedestroy" {{ $reportType == 'packagedestroy' ? 'selected' : '' }}>प्याकेज नष्ट विधि</option>
                                        <option value="country" {{ $reportType == 'country' ? 'selected' : '' }}>देश</option>
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
                                                        case 'source':
                                                            $displayName = $item->sourcename ?? 'N/A';
                                                            break;
                                                        case 'objective':
                                                            $displayName = $item->objective ?? 'N/A';
                                                            break;
                                                        case 'usage':
                                                            $displayName = $item->usage_name ?? 'N/A';
                                                            break;
                                                        case 'unit':
                                                            $displayName = $item->unit_name ?? 'N/A';
                                                            break;
                                                        case 'packagedestroy':
                                                            $displayName = $item->packagedestroy_name ?? 'N/A';
                                                            break;
                                                        case 'country':
                                                            $displayName = $item->country_name ?? 'N/A';
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
                                                @case('source') स्रोत छान्नुहोस् @break
                                                @case('objective') उद्देश्य छान्नुहोस् @break
                                                @case('usage') उपयोग छान्नुहोस् @break
                                                @case('unit') एकाइ छान्नुहोस् @break
                                                @case('packagedestroy') प्याकेज नष्ट विधि छान्नुहोस् @break
                                                @case('country') देश छान्नुहोस् @break
                                                @default छान्नुहोस्
                                            @endswitch
                                        </label>
                                    </div>
                                </div>

                                @if($filterValue && $panjikarans->count() > 0)
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
                    @if($reportType && $filterValue && $panjikarans->count() > 0)
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    रिपोर्ट परिणाम:
                                    @switch($reportType)
                                        @case('source') स्रोत @break
                                        @case('objective') उद्देश्य @break
                                        @case('usage') उपयोग @break
                                        @case('unit') एकाइ @break
                                        @case('packagedestroy') प्याकेज नष्ट विधि @break
                                        @case('country') देश @break
                                    @endswitch
                                    अनुसार
                                </h5>
                                <span class="badge bg-info">कुल {{ $panjikarans->count() }} रेकर्ड</span>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle table-bordered table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th width="5%">S.N.</th>
                                            <th width="15%">आवेदनकर्ता</th>
                                            <th width="12%">इजाजतपत्र नं.</th>
                                            <th width="18%">रासायनिक नाम</th>
                                            <th width="12%">स्रोत</th>
                                            <th width="12%">उद्देश्य</th>
                                            <th width="26%">कार्य</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($panjikarans as $sn => $panjikaran)
                                            <tr>
                                                <td>{{ ++$sn }}</td>
                                                <td>{{ $panjikaran->checklist->ImporterName ?? 'N/A' }}</td>
                                                <td>{{ $panjikaran->checklist->LicenseNo ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('panjikaran.workflow', $panjikaran->id) }}"
                                                        class="text-primary text-decoration-none fw-bold">
                                                        {{ $panjikaran->ChemicalName }}
                                                    </a>
                                                </td>
                                                <td>{{ $panjikaran->source->sourcename ?? 'N/A' }}</td>
                                                <td>{{ $panjikaran->objective->objective ?? 'N/A' }}</td>
                                                <td>
                                                    <!-- View Button -->
                                                    <a href="{{ route('panjikarans.show', $panjikaran->id) }}"
                                                        class="btn btn-info btn-sm" title="हेर्नुहोस्">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <!-- Print Button -->
                                                    <a href="{{ route('panjikaran.print', $panjikaran->id) }}" target="_blank"
                                                        class="btn btn-dark btn-sm" title="प्रिन्ट गर्नुहोस्">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @elseif($reportType && $filterValue && $panjikarans->count() == 0)
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <h5>कुनै डाटा फेला परेन</h5>
                            <p>छानिएको मापदण्डमा कुनै पञ्जीकरण रेकर्ड उपलब्ध छैन।</p>
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
