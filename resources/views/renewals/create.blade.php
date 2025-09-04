@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">नयाँ नवीकरण थप्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('renewals.index') }}">नवीकरणको सूची</a></li>
                        <li class="breadcrumb-item active">नयाँ नवीकरण</li>
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
                    @if ($panjikaran && $checklist)
                        <div class="alert alert-info">
                            <h5>पञ्जीकरण विवरण:</h5>
                            <p><strong>आवेदनकर्ता:</strong> {{ $checklist->ImporterName ?? 'N/A' }}</p>
                            <p><strong>इजाजतपत्र नं.:</strong> {{ $checklist->LicenseNo ?? 'N/A' }}</p>
                            <p><strong>रासायनिक नाम:</strong> {{ $panjikaran->ChemicalName ?? 'N/A' }}</p>
                            <p><strong>स्थिति:</strong> {!! $checklist->getStatusWithIcon() !!}</p>
                        </div>
                    @endif

                    <form action="{{ route('renewals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($panjikaran)
                            <input type="hidden" name="panjikaran_id" value="{{ $panjikaran->id }}">
                        @else
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
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
                                        <label for="panjikaran_id">पञ्जीकरण</label>
                                        @error('panjikaran_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('renew_date') is-invalid @enderror"
                                        name="renew_date" value="{{ old('renew_date', date('Y-m-d')) }}" required>
                                    <label for="renew_date">नवीकरण मिति</label>
                                    @error('renew_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('renew_expiry_date') is-invalid @enderror"
                                        name="renew_expiry_date" value="{{ old('renew_expiry_date') }}" required>
                                    <label for="renew_expiry_date">म्याद सकिने मिति</label>
                                    @error('renew_expiry_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('tax_bhauchar_no') is-invalid @enderror"
                                        name="tax_bhauchar_no" value="{{ old('tax_bhauchar_no') }}"
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
                                        name="ruju_garne" value="{{ old('ruju_garne') }}"
                                        placeholder="रूजु गर्ने व्यक्तिको नाम">
                                    <label for="ruju_garne">रूजु गर्ने व्यक्तिको नाम</label>
                                    @error('ruju_garne')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="signature_upload" class="form-label">हस्ताक्षर अपलोड गर्नुहोस्</label>
                                <input type="file" class="form-control @error('signature_upload') is-invalid @enderror"
                                    name="signature_upload" accept="image/*">
                                <div class="form-text">केवल छवि फाइलहरू अनुमतित छन् (अधिकतम 2MB)</div>
                                @error('signature_upload')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa fa-save"></i> सेभ गर्नुहोस्
                                </button>
                                <a href="{{ route('renewals.index', ['panjikaran_id' => request('panjikaran_id')]) }}"
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
