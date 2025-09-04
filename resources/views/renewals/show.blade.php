@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">नवीकरण विवरण</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('renewals.index') }}">नवीकरणको सूची</a></li>
                        <li class="breadcrumb-item active">विवरण</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title">नवीकरण ID: {{ $renewal->id }}</h5>
                                <div>
                                    <a href="{{ route('renewals.edit', $renewal->id) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> सम्पादन गर्नुहोस्
                                    </a>
                                    <a href="{{ route('renewals.index', ['panjikaran_id' => $renewal->panjikaran_id]) }}"
                                        class="btn btn-secondary btn-sm">
                                        <i class="fa fa-arrow-left"></i> सूचीमा फिर्ता
                                    </a>
                                </div>
                            </div>

                            <!-- Related Panjikaran Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">सम्बन्धित पञ्जीकरण जानकारी</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>आवेदनकर्ता:</strong>
                                    <p>{{ $renewal->checklist->ImporterName ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>इजाजतपत्र नं.:</strong>
                                    <p>{{ $renewal->checklist->LicenseNo ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>रासायनिक नाम:</strong>
                                    <p>
                                        <a href="{{ route('panjikaran.workflow', $renewal->panjikaran_id) }}"
                                            class="text-primary text-decoration-none fw-bold">
                                            {{ $renewal->panjikaran->ChemicalName ?? 'N/A' }}
                                        </a>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>पञ्जीकरण स्थिति:</strong>
                                    <p>{!! $renewal->checklist->getStatusWithIcon() !!}</p>
                                </div>
                            </div>

                            <!-- Renewal Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-success border-bottom pb-2">नवीकरण विवरण</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>नवीकरण मिति:</strong>
                                    <p>{{ $renewal->renew_date->format('Y-m-d') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>म्याद सकिने मिति:</strong>
                                    <p>{{ $renewal->renew_expiry_date->format('Y-m-d') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>कर भौचर नं.:</strong>
                                    <p>{{ $renewal->tax_bhauchar_no ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>रूजु गर्ने व्यक्ति:</strong>
                                    <p>{{ $renewal->ruju_garne ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>नवीकरण स्थिति:</strong>
                                    <p>{!! $renewal->getStatusWithIconAttribute() !!}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>सिर्जना मिति:</strong>
                                    <p>{{ $renewal->created_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                            </div>

                            <!-- Signature Section -->
                            @if($renewal->signature_upload)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-info border-bottom pb-2">हस्ताक्षर</h6>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . $renewal->signature_upload) }}"
                                                 alt="Signature" class="img-thumbnail" style="max-width: 300px;">
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/' . $renewal->signature_upload) }}"
                                                   target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="fa fa-external-link"></i> पूरा हस्ताक्षर हेर्नुहोस्
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-info border-bottom pb-2">हस्ताक्षर</h6>
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> कुनै हस्ताक्षर अपलोड गरिएको छैन
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12 text-center">
                                    <a href="{{ route('renewals.edit', $renewal->id) }}" class="btn btn-warning">
                                        <i class="fa fa-edit"></i> सम्पादन गर्नुहोस्
                                    </a>
                                    <a href="{{ route('panjikarans.show', $renewal->panjikaran_id) }}" class="btn btn-info">
                                        <i class="fa fa-eye"></i> पञ्जीकरण विवरण हेर्नुहोस्
                                    </a>
                                    <a href="{{ route('renewals.index', ['panjikaran_id' => $renewal->panjikaran_id]) }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> फिर्ता जानुहोस्
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
