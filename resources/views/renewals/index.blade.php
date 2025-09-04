@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">
                    नवीकरणको सूची
                    @if($panjikaran)
                        - {{ $panjikaran->checklist->ImporterName ?? 'N/A' }}
                    @endif
                </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        @if($panjikaran)
                            <li class="breadcrumb-item">
                                <a href="{{ route('panjikarans.index', ['checklist_id' => $panjikaran->ChecklistID]) }}">पञ्जीकरणको सूची</a>
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ route('panjikarans.index') }}">पञ्जीकरणको सूची</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active">नवीकरणको सूची</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if($panjikaran && $panjikaran->checklist)
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5>पञ्जीकरण विवरण:</h5>
                            <p class="mb-1"><strong>आवेदनकर्ता:</strong> {{ $panjikaran->checklist->ImporterName ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>इजाजतपत्र नं.:</strong> {{ $panjikaran->checklist->LicenseNo ?? 'N/A' }}</p>
                            <p class="mb-0"><strong>स्थिति:</strong> {!! $panjikaran->checklist->getStatusWithIcon() !!}</p>
                        </div>
                        <div class="text-end">
                            <strong>कुल नवीकरण:</strong> <span class="badge bg-primary fs-6">{{ $renewals->count() }}</span>
                        </div>
                    </div>

                    @if($panjikaran->checklist->check_list_formulations->count() > 0)
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
                                        @foreach($panjikaran->checklist->check_list_formulations as $formulation)
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
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Create New Renewal Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">नयाँ नवीकरण थप्नुहोस्</h5>
                        @if(request('panjikaran_id'))
                            <a href="{{ route('panjikarans.index', ['checklist_id' => $panjikaran->ChecklistID ?? null]) }}"
                                class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> पञ्जीकरणमा फर्कनुहोस्
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('renewals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($panjikaran)
                            <input type="hidden" name="panjikaran_id" value="{{ $panjikaran->id }}">
                        @endif

                        <!-- First Row - 3 Fields -->
                        <div class="row mb-3">
                            @if(!$panjikaran)
                                <div class="col-md-4">
                                    <label for="panjikaran_id" class="form-label">पञ्जीकरण <span class="text-danger">*</span></label>
                                    <select class="form-select @error('panjikaran_id') is-invalid @enderror"
                                        name="panjikaran_id" required>
                                        <option value="">पञ्जीकरण छान्नुहोस्</option>
                                        @foreach(\App\Models\Panjikaran::with('checklist')->get() as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('panjikaran_id') == $p->id ? 'selected' : '' }}>
                                                {{ $p->checklist->ImporterName ?? 'N/A' }} - {{ $p->ChemicalName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('panjikaran_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="renew_date" class="form-label">नवीकरण मिति <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('renew_date') is-invalid @enderror"
                                        name="renew_date" value="{{ old('renew_date', date('Y-m-d')) }}" required>
                                    @error('renew_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="renew_expiry_date" class="form-label">म्याद सकिने मिति <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('renew_expiry_date') is-invalid @enderror"
                                        name="renew_expiry_date" value="{{ old('renew_expiry_date') }}" required>
                                    @error('renew_expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <div class="col-md-4">
                                    <label for="renew_date" class="form-label">नवीकरण मिति <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('renew_date') is-invalid @enderror"
                                        name="renew_date" value="{{ old('renew_date', date('Y-m-d')) }}" required>
                                    @error('renew_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="renew_expiry_date" class="form-label">म्याद सकिने मिति <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('renew_expiry_date') is-invalid @enderror"
                                        name="renew_expiry_date" value="{{ old('renew_expiry_date') }}" required>
                                    @error('renew_expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="tax_bhauchar_no" class="form-label">कर भौचर नम्बर</label>
                                    <input type="text" class="form-control @error('tax_bhauchar_no') is-invalid @enderror"
                                        name="tax_bhauchar_no" value="{{ old('tax_bhauchar_no') }}"
                                        placeholder="कर भौचर नम्बर प्रविष्ट गर्नुहोस्">
                                    @error('tax_bhauchar_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <!-- Second Row - 3 Fields including Save Button -->
                        <div class="row mb-3">
                            @if(!$panjikaran)
                                <div class="col-md-4">
                                    <label for="tax_bhauchar_no" class="form-label">कर भौचर नम्बर</label>
                                    <input type="text" class="form-control @error('tax_bhauchar_no') is-invalid @enderror"
                                        name="tax_bhauchar_no" value="{{ old('tax_bhauchar_no') }}"
                                        placeholder="कर भौचर नम्बर प्रविष्ट गर्नुहोस्">
                                    @error('tax_bhauchar_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="ruju_garne" class="form-label">रूजु गर्ने व्यक्ति</label>
                                    <input type="text" class="form-control @error('ruju_garne') is-invalid @enderror"
                                        name="ruju_garne" value="{{ old('ruju_garne') }}"
                                        placeholder="रूजु गर्ने व्यक्तिको नाम">
                                    @error('ruju_garne')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="signature_upload" class="form-label">हस्ताक्षर अपलोड</label>
                                    <input type="file" class="form-control @error('signature_upload') is-invalid @enderror"
                                        name="signature_upload" accept="image/*">
                                    <div class="form-text small">केवल छवि फाइलहरू (अधिकतम 2MB)</div>
                                    @error('signature_upload')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <div class="col-md-4">
                                    <label for="ruju_garne" class="form-label">रूजु गर्ने व्यक्ति</label>
                                    <input type="text" class="form-control @error('ruju_garne') is-invalid @enderror"
                                        name="ruju_garne" value="{{ old('ruju_garne') }}"
                                        placeholder="रूजु गर्ने व्यक्तिको नाम">
                                    @error('ruju_garne')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="signature_upload" class="form-label">हस्ताक्षर अपलोड</label>
                                    <input type="file" class="form-control @error('signature_upload') is-invalid @enderror"
                                        name="signature_upload" accept="image/*">
                                    <div class="form-text small">केवल छवि फाइलहरू (अधिकतम 2MB)</div>
                                    @error('signature_upload')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4" style="margin-top: 30px">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fa fa-plus"></i> नवीकरण थप्नुहोस्
                                    </button>
                                </div>
                            @endif
                        </div>

                        @if(!$panjikaran)
                            <!-- Third Row - Save Button for non-filtered view -->
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-plus"></i> नवीकरण थप्नुहोस्
                                    </button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Renewals List -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            नवीकरणको विवरण
                            @if(!$panjikaran)
                                <small class="text-muted">(सबै पञ्जीकरण)</small>
                            @endif
                        </h5>
                        @if(!request('panjikaran_id'))
                            <a href="{{ route('panjikarans.index') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-list"></i> पञ्जीकरण हेर्नुहोस्
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle datatable dt-responsive table-check nowrap"
                                style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                            <thead>
                                <tr class="bg-transparent">
                                    <th width="4%">S.N.</th>
                                    @if(!$panjikaran)
                                        <th width="14%">आवेदनकर्ता</th>
                                        <th width="10%">रासायनिक नाम</th>
                                    @endif
                                    <th width="10%">नवीकरण मिति</th>
                                    <th width="10%">म्याद सकिने मिति</th>
                                    <th width="10%">कर भौचर नं.</th>
                                    <th width="10%">रूजु गर्ने</th>
                                    <th width="8%">स्थिति</th>
                                    <th width="{{ $panjikaran ? '24%' : '20%' }}">कार्य</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($renewals as $sn => $renewal)
                                    <tr>
                                        <td>{{ ++$sn }}</td>
                                        @if(!$panjikaran)
                                            <td>
                                                <div class="text-truncate" style="max-width: 140px;" title="{{ $renewal->checklist->ImporterName ?? 'N/A' }}">
                                                    {{ $renewal->checklist->ImporterName ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('panjikaran.workflow', $renewal->panjikaran_id) }}"
                                                    class="text-primary text-decoration-none fw-bold">
                                                    {{ $renewal->panjikaran->ChemicalName ?? 'N/A' }}
                                                </a>
                                            </td>
                                        @endif
                                        <td>
                                            <small class="text-muted">
                                                {{ $renewal->renew_date->format('Y-m-d') }}
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $renewal->renew_expiry_date->format('Y-m-d') }}
                                            </small>
                                        </td>
                                        <td>{{ $renewal->tax_bhauchar_no ?? 'N/A' }}</td>
                                        <td>{{ $renewal->ruju_garne ?? 'N/A' }}</td>
                                        <td>{!! $renewal->getStatusWithIconAttribute() !!}</td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <a href="{{ route('renewals.show', $renewal->id) }}"
                                                    class="btn btn-info btn-sm" title="हेर्नुहोस्">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('renewals.edit', $renewal->id) }}"
                                                    class="btn btn-success btn-sm" title="सम्पादन गर्नुहोस्">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                @if($renewal->signature_upload)
                                                    <a href="{{ asset('storage/' . $renewal->signature_upload) }}"
                                                        target="_blank" class="btn btn-warning btn-sm" title="हस्ताक्षर हेर्नुहोस्">
                                                        <i class="fa fa-file-image"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('renewals.destroy', $renewal->id) }}" method="POST"
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
                                        <td colspan="{{ $panjikaran ? '7' : '9' }}" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fa fa-info-circle fa-2x mb-3"></i>
                                                <div>
                                                    @if($panjikaran)
                                                        <h6>यस पञ्जीकरणको लागि कुनै नवीकरण उपलब्ध छैन</h6>
                                                        <p class="mb-0">नयाँ नवीकरण थप्न माथिको फर्म प्रयोग गर्नुहोस्।</p>
                                                    @else
                                                        <h6>कुनै नवीकरण डाटा उपलब्ध छैन</h6>
                                                        <p class="mb-0">पहिले पञ्जीकरण छानेर नवीकरण थप्नुहोस्।</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($renewals->count() > 0)
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    कुल {{ $renewals->count() }} नवीकरण देखाइएको छ
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

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
</style>
@endpush
