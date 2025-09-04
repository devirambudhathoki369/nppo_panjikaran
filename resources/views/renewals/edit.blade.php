@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">नवीकरण सम्पादन गर्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('renewals.index') }}">नवीकरणको सूची</a></li>
                        <li class="breadcrumb-item active">सम्पादन गर्नुहोस्</li>
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
                    <div class="alert alert-info">
                        <h5>पञ्जीकरण विवरण:</h5>
                        <p><strong>आवेदनकर्ता:</strong> {{ $renewal->checklist->ImporterName ?? 'N/A' }}</p>
                        <p><strong>इजाजतपत्र नं.:</strong> {{ $renewal->checklist->LicenseNo ?? 'N/A' }}</p>
                        <p><strong>रासायनिक नाम:</strong> {{ $renewal->panjikaran->ChemicalName ?? 'N/A' }}</p>
                        <p><strong>स्थिति:</strong> {!! $renewal->checklist->getStatusWithIcon() !!}</p>
                    </div>

                    <form action="{{ route('renewals.update', $renewal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('renew_date') is-invalid @enderror"
                                        name="renew_date" value="{{ old('renew_date', $renewal->renew_date->format('Y-m-d')) }}" required>
                                    <label for="renew_date">नवीकरण मिति</label>
                                    @error('renew_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('renew_expiry_date') is-invalid @enderror"
                                        name="renew_expiry_date" value="{{ old('renew_expiry_date', $renewal->renew_expiry_date->format('Y-m-d')) }}" required>
                                    <label for="renew_expiry_date">म्याद सकिने मिति</label>
                                    @error('renew_expiry_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('tax_bhauchar_no') is-invalid @enderror"
                                        name="tax_bhauchar_no" value="{{ old('tax_bhauchar_no', $renewal->tax_bhauchar_no) }}"
                                        placeholder="कर भौचर नम्बर">
                                    <label for="tax_bhauchar_no">कर भौचर नम्बर</label>
                                    @error('tax_bhauchar_no')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('ruju_garne') is-invalid @enderror"
                                        name="ruju_garne" value="{{ old('ruju_garne', $renewal->ruju_garne) }}"
                                        placeholder="रूजु गर्ने व्यक्तिको नाम">
                                    <label for="ruju_garne">रूजु गर्ने व्यक्तिको नाम</label>
                                    @error('ruju_garne')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="signature_upload" class="form-label">हस्ताक्षर अपलोड गर्नुहोस्</label>
                                @if($renewal->signature_upload)
                                    <div class="mb-2">
                                        <p class="text-muted">हालको हस्ताक्षर:</p>
                                        <img src="{{ asset('storage/' . $renewal->signature_upload) }}"
                                             alt="Current Signature" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('signature_upload') is-invalid @enderror"
                                    name="signature_upload" accept="image/*">
                                <div class="form-text">केवल छवि फाइलहरू अनुमतित छन् (अधिकतम 2MB) - नयाँ हस्ताक्षर अपलोड गर्न मात्र चाहिएको छ</div>
                                @error('signature_upload')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa fa-save"></i> अपडेट गर्नुहोस्
                                </button>
                                <a href="{{ route('renewals.index', ['panjikaran_id' => $renewal->panjikaran_id]) }}"
                                    class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> फिर्ता जानुहोस्
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
