@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">
                    पञ्जीकरणको सूची
                    @if($checklist)
                        - {{ $checklist->ImporterName ?? 'N/A' }}
                    @endif
                </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        @if($checklist)
                            <li class="breadcrumb-item">
                                <a href="{{ route('checklists.index') }}">चेकलिस्ट</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active">पञ्जीकरणको सूची</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if($checklist)
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5>चेकलिस्ट विवरण:</h5>
                            <p class="mb-1"><strong>आवेदनकर्ता:</strong> {{ $checklist->ImporterName ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>इजाजतपत्र नं.:</strong> {{ $checklist->LicenseNo ?? 'N/A' }}</p>
                            <p class="mb-0"><strong>स्थिति:</strong> {!! $checklist->getStatusWithIcon() !!}</p>
                        </div>
                        <div class="text-end">
                            <strong>कुल पञ्जीकरण:</strong> <span class="badge bg-primary fs-6">{{ $panjikarans->count() }}</span>
                        </div>
                    </div>

                    @if($checklist->check_list_formulations->count() > 0)
                        <div class="mt-3">
                            <h6><strong>सामान्य नामहरू र रासायनिक विवरण:</strong></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>सामान्य नाम</th>
                                            <th>रासायनिक नाम</th>
                                            <th>IUPAC नाम</th>
                                            <th>CAS नम्बर</th>
                                            <th>आणविक सूत्र</th>
                                            <th>फॉर्मुलेशन</th>
                                            <th>मात्रा</th>
                                            <th>स्रोत</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($checklist->check_list_formulations as $formulation)
                                            <tr>
                                                <td><strong>{{ $formulation->common_name->common_name ?? 'N/A' }}</strong></td>
                                                <td>{{ $formulation->common_name->rasayanik_name ?? 'N/A' }}</td>
                                                <td>{{ $formulation->common_name->iupac_name ?? 'N/A' }}</td>
                                                <td>{{ $formulation->common_name->cas_no ?? 'N/A' }}</td>
                                                <td>{{ $formulation->common_name->molecular_formula ?? 'N/A' }}</td>
                                                <td>{{ $formulation->formulation->formulation_name ?? 'N/A' }}</td>
                                                <td>{{ $formulation->ActiveIngredientValue ?? 'N/A' }} {{ $formulation->unit->unit_name ?? '' }}</td>
                                                <td>{{ $formulation->common_name->source->sourcename ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle"></i> यस चेकलिस्टमा कुनै सामान्य नामहरू फेला परेन।
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0">
                                पञ्जीकरणको विवरण
                                @if(!$checklist)
                                    <small class="text-muted">(सबै चेकलिस्ट)</small>
                                @endif
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('panjikarans.create', ['checklist_id' => request('checklist_id')]) }}"
                                class="btn btn-primary">
                                <i class="fa fa-plus"></i> नयाँ पञ्जीकरण थप्नुहोस्
                            </a>
                            @if($checklist)
                                <a href="{{ route('checklists.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> चेकलिस्ट सूचीमा फर्कनुहोस्
                                </a>
                            @else
                                <a href="{{ route('checklists.index') }}" class="btn btn-outline-secondary">
                                    <i class="fa fa-list"></i> चेकलिस्ट हेर्नुहोस्
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle datatable dt-responsive table-check nowrap"
                                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                            <thead>
                                <tr class="bg-transparent">
                                    <th width="4%">S.N.</th>
                                    @if(!$checklist)
                                        <th width="14%">आवेदनकर्ता</th>
                                        <th width="10%">इजाजतपत्र नं.</th>
                                    @endif
                                    <th width="12%">उद्देश्य</th>
                                    <th width="10%">उपयोग</th>
                                    <th width="10%">प्रभावक मात्रा</th>
                                    <th width="10%">सिर्जना मिति</th>
                                    <th width="{{ $checklist ? '34%' : '30%' }}">कार्य</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($panjikarans as $sn => $panjikaran)
                                    <tr>
                                        <td>{{ ++$sn }}</td>
                                        @if(!$checklist)
                                            <td>
                                                <div class="text-truncate" style="max-width: 140px;" title="{{ $panjikaran->checklist->ImporterName ?? 'N/A' }}">
                                                    {{ $panjikaran->checklist->ImporterName ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td>{{ $panjikaran->checklist->LicenseNo ?? 'N/A' }}</td>
                                        @endif
                                        <td>{{ $panjikaran->objective->objective ?? 'N/A' }}</td>
                                        <td>{{ $panjikaran->usage->usage_name ?? 'N/A' }}</td>
                                        <td>
                                            @if($panjikaran->DapperQuantity)
                                                {{ $panjikaran->DapperQuantity }} {{ $panjikaran->unit->unit_name ?? '' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $panjikaran->created_at->format('Y-m-d') }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <a href="{{ route('panjikaran.workflow', $panjikaran->id) }}"
                                                    class="btn btn-primary btn-sm" title="कार्यप्रवाह">
                                                    <i class="fa fa-cogs"></i>
                                                </a>
                                                <a href="{{ route('panjikarans.show', $panjikaran->id) }}"
                                                    class="btn btn-info btn-sm" title="हेर्नुहोस्">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('panjikarans.edit', $panjikaran->id) }}"
                                                    class="btn btn-success btn-sm" title="सम्पादन गर्नुहोस्">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="{{ route('panjikaran.print', $panjikaran->id) }}" target="_blank"
                                                    class="btn btn-dark btn-sm" title="प्रिन्ट गर्नुहोस्">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                                <a href="{{ route('renewals.create', ['panjikaran_id' => $panjikaran->id]) }}"
                                                    class="btn btn-warning btn-sm" title="नवीकरण गर्नुहोस्">
                                                    <i class="fa fa-refresh"></i>
                                                </a>
                                                <a href="{{ route('renewals.index', ['panjikaran_id' => $panjikaran->id]) }}"
                                                    class="btn btn-secondary btn-sm" title="नवीकरणको सूची">
                                                    <i class="fa fa-list"></i>
                                                </a>
                                                <form action="{{ route('panjikarans.destroy', $panjikaran->id) }}" method="POST"
                                                    style="display: inline;"
                                                    onsubmit="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="मेट्नुहोस्">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $checklist ? '6' : '8' }}" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fa fa-info-circle fa-2x mb-3"></i>
                                                <div>
                                                    @if($checklist)
                                                        <h6>यस चेकलिस्टको लागि कुनै पञ्जीकरण उपलब्ध छैन</h6>
                                                        <p class="mb-0">नयाँ पञ्जीकरण थप्न माथिको बटन प्रयोग गर्नुहोस्।</p>
                                                    @else
                                                        <h6>कुनै पञ्जीकरण डाटा उपलब्ध छैन</h6>
                                                        <p class="mb-0">पहिले चेकलिस्ट सिर्जना गरेर पञ्जीकरण थप्नुहोस्।</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($panjikarans->count() > 0)
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    कुल {{ $panjikarans->count() }} पञ्जीकरण देखाइएको छ
                                </small>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    अन्तिम अपडेट: {{ now()->format('Y-m-d H:i') }}
                                </small>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        color: #495057;
    }

    .table td {
        vertical-align: middle;
        font-size: 0.875rem;
    }

    .btn-group .btn {
        border-radius: 0.375rem;
        margin-right: 2px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .table-responsive {
        border-radius: 0.5rem;
    }

    .badge {
        font-size: 0.75rem;
    }

    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endpush
