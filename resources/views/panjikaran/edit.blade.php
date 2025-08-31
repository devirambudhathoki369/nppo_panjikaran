@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">पञ्जीकरण सम्पादन गर्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikarans.index') }}">पञ्जीकरणको सूची</a></li>
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
                    @if ($checklist)
                        <div class="alert alert-info">
                            <h5>चेकलिस्ट विवरण:</h5>
                            <p><strong>आवेदनकर्ता:</strong> {{ $checklist->ImporterName ?? 'N/A' }}</p>
                            <p><strong>इजाजतपत्र नं.:</strong> {{ $checklist->LicenseNo ?? 'N/A' }}</p>
                            <p><strong>स्थिति:</strong> {!! $checklist->getStatusWithIcon() !!}</p>

                            @if($checklist->check_list_formulations->count() > 0)
                                <div class="mt-3">
                                    <h6><strong>सामान्य नामहरू:</strong></h6>
                                    <div class="row">
                                        @foreach($checklist->check_list_formulations as $formulation)
                                            <div class="col-md-6 mb-2">
                                                <div class="border p-2 rounded bg-light">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $formulation->common_name->common_name ?? 'N/A' }}</strong>
                                                            <br>
                                                            <small class="text-muted">
                                                                फॉर्मुलेशन: {{ $formulation->formulation->formulation_name ?? 'N/A' }}
                                                                | मात्रा: {{ $formulation->ActiveIngredientValue ?? 'N/A' }} {{ $formulation->unit->unit_name ?? '' }}
                                                            </small>
                                                        </div>
                                                        <span class="badge bg-primary">{{ $loop->iteration }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-exclamation-triangle"></i> यस चेकलिस्टमा कुनै सामान्य नामहरू फेला परेन।
                                </div>
                            @endif
                        </div>
                    @endif
                    <form action="{{ route('panjikarans.update', $panjikaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Basic Information -->
                            {{-- <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('CommonNameOfPesticide') is-invalid @enderror"
                                        name="CommonNameOfPesticide"
                                        value="{{ old('CommonNameOfPesticide', $panjikaran->CommonNameOfPesticide) }}"
                                        required placeholder="कीटनाशकको सामान्य नाम">
                                    <label>कीटनाशकको सामान्य नाम</label>
                                    @error('CommonNameOfPesticide')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('ChemicalName') is-invalid @enderror"
                                        name="ChemicalName" value="{{ old('ChemicalName', $panjikaran->ChemicalName) }}"
                                        required placeholder="रासायनिक नाम">
                                    <label>रासायनिक नाम</label>
                                    @error('ChemicalName')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('IUPAC_Name') is-invalid @enderror"
                                        name="IUPAC_Name" value="{{ old('IUPAC_Name', $panjikaran->IUPAC_Name) }}"
                                        placeholder="IUPAC नाम">
                                    <label>IUPAC नाम</label>
                                    @error('IUPAC_Name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('Cas_No') is-invalid @enderror"
                                        name="Cas_No" value="{{ old('Cas_No', $panjikaran->Cas_No) }}"
                                        placeholder="Cas No">
                                    <label>Cas No</label>
                                    @error('Cas_No')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('Atomic_Formula') is-invalid @enderror"
                                        name="Atomic_Formula"
                                        value="{{ old('Atomic_Formula', $panjikaran->Atomic_Formula) }}"
                                        placeholder="आणविक सूत्र">
                                    <label>आणविक सूत्र</label>
                                    @error('Atomic_Formula')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dropdowns -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select @error('SourceID') is-invalid @enderror" name="SourceID"
                                        required>
                                        <option value="">स्रोत छान्नुहोस्</option>
                                        @foreach ($sources as $source)
                                            <option value="{{ $source->id }}"
                                                {{ old('SourceID', $panjikaran->SourceID) == $source->id ? 'selected' : '' }}>
                                                {{ $source->sourcename }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>स्रोत</label>
                                    @error('SourceID')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select @error('ObjectiveID') is-invalid @enderror"
                                        name="ObjectiveID" required>
                                        <option value="">उद्देश्य छान्नुहोस्</option>
                                        @foreach ($objectives as $objective)
                                            <option value="{{ $objective->id }}"
                                                {{ old('ObjectiveID', $panjikaran->ObjectiveID) == $objective->id ? 'selected' : '' }}>
                                                {{ $objective->objective }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>उद्देश्य</label>
                                    @error('ObjectiveID')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select @error('UsageID') is-invalid @enderror" name="UsageID"
                                        required>
                                        <option value="">उपयोग छान्नुहोस्</option>
                                        @foreach ($usages as $usage)
                                            <option value="{{ $usage->id }}"
                                                {{ old('UsageID', $panjikaran->UsageID) == $usage->id ? 'selected' : '' }}>
                                                {{ $usage->usage_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>उपयोग</label>
                                    @error('UsageID')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('DapperQuantity') is-invalid @enderror"
                                        name="DapperQuantity"
                                        value="{{ old('DapperQuantity', $panjikaran->DapperQuantity) }}"
                                        placeholder="जीवनाशक विषादीको प्रभावक मात्रा">
                                    <label>जीवनाशक विषादीको प्रभावक मात्रा</label>
                                    @error('DapperQuantity')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select @error('DQUnitID') is-invalid @enderror" name="DQUnitID"
                                        required>
                                        <option value="">इकाई छान्नुहोस्</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ old('DQUnitID', $panjikaran->DQUnitID) == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->unit_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>इकाई</label>
                                    @error('DQUnitID')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Waiting_duration') is-invalid @enderror"
                                        name="Waiting_duration"
                                        value="{{ old('Waiting_duration', $panjikaran->Waiting_duration) }}"
                                        placeholder="प्रतीक्षा अवधि">
                                    <label>प्रतीक्षा अवधि</label>
                                    @error('Waiting_duration')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('FirstAid') is-invalid @enderror"
                                        name="FirstAid" value="{{ old('FirstAid', $panjikaran->FirstAid) }}"
                                        placeholder="प्राथमिक उपचार">
                                    <label>प्राथमिक उपचार</label>
                                    @error('FirstAid')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select @error('PackageDestroyID') is-invalid @enderror"
                                        name="PackageDestroyID" required>
                                        <option value="">प्याकेज नष्ट विधि छान्नुहोस्</option>
                                        @foreach ($packageDestroys as $packageDestroy)
                                            <option value="{{ $packageDestroy->id }}"
                                                {{ old('PackageDestroyID', $panjikaran->PackageDestroyID) == $packageDestroy->id ? 'selected' : '' }}>
                                                {{ $packageDestroy->packagedestroy_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>प्याकेज नष्ट विधि</label>
                                    @error('PackageDestroyID')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Company Details Sections -->
                            <div class="col-12">
                                <h5 class="mt-4 mb-3">विदेशी उत्पादक कम्पनीको विवरण</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Foreign_producer_company_name') is-invalid @enderror"
                                        name="Foreign_producer_company_name"
                                        value="{{ old('Foreign_producer_company_name', $panjikaran->Foreign_producer_company_name) }}"
                                        placeholder="विदेशी उत्पादक कम्पनीको नाम">
                                    <label>विदेशी उत्पादक कम्पनीको नाम</label>
                                    @error('Foreign_producer_company_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Foreign_producer_company_address') is-invalid @enderror"
                                        name="Foreign_producer_company_address"
                                        value="{{ old('Foreign_producer_company_address', $panjikaran->Foreign_producer_company_address) }}"
                                        placeholder="विदेशी उत्पादक कम्पनीको ठेगाना">
                                    <label>विदेशी उत्पादक कम्पनीको ठेगाना</label>
                                    @error('Foreign_producer_company_address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Continue with remaining company sections... -->
                            <!-- (I'll include all company sections as in the create form but with edit values) -->

                            <div class="col-12">
                                <h5 class="mt-4 mb-3">नेपाली उत्पादक कम्पनीको विवरण</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Nepali_producer_company_name') is-invalid @enderror"
                                        name="Nepali_producer_company_name"
                                        value="{{ old('Nepali_producer_company_name', $panjikaran->Nepali_producer_company_name) }}"
                                        placeholder="नेपाली उत्पादक कम्पनीको नाम">
                                    <label>नेपाली उत्पादक कम्पनीको नाम</label>
                                    @error('Nepali_producer_company_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Nepali_producer_company_address') is-invalid @enderror"
                                        name="Nepali_producer_company_address"
                                        value="{{ old('Nepali_producer_company_address', $panjikaran->Nepali_producer_company_address) }}"
                                        placeholder="नेपाली उत्पादक कम्पनीको ठेगाना">
                                    <label>नेपाली उत्पादक कम्पनीको ठेगाना</label>
                                    @error('Nepali_producer_company_address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="email"
                                        class="form-control @error('Nepali_producer_company_email') is-invalid @enderror"
                                        name="Nepali_producer_company_email"
                                        value="{{ old('Nepali_producer_company_email', $panjikaran->Nepali_producer_company_email) }}"
                                        placeholder="नेपाली उत्पादक कम्पनीको इमेल">
                                    <label>नेपाली उत्पादक कम्पनीको इमेल</label>
                                    @error('Nepali_producer_company_email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Nepali_producer_company_contact') is-invalid @enderror"
                                        name="Nepali_producer_company_contact"
                                        value="{{ old('Nepali_producer_company_contact', $panjikaran->Nepali_producer_company_contact) }}"
                                        placeholder="नेपाली उत्पादक कम्पनीको सम्पर्क">
                                    <label>नेपाली उत्पादक कम्पनीको सम्पर्क</label>
                                    @error('Nepali_producer_company_contact')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <h5 class="mt-4 mb-3">समेजसम कम्पनीको विवरण</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Samejasamcompany_s_detail_name') is-invalid @enderror"
                                        name="Samejasamcompany_s_detail_name"
                                        value="{{ old('Samejasamcompany_s_detail_name', $panjikaran->Samejasamcompany_s_detail_name) }}"
                                        placeholder="समेजसम कम्पनीको नाम">
                                    <label>समेजसम कम्पनीको नाम</label>
                                    @error('Samejasamcompany_s_detail_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Samejasamcompany_s_detail_address') is-invalid @enderror"
                                        name="Samejasamcompany_s_detail_address"
                                        value="{{ old('Samejasamcompany_s_detail_address', $panjikaran->Samejasamcompany_s_detail_address) }}"
                                        placeholder="समेजसम कम्पनीको ठेगाना">
                                    <label>समेजसम कम्पनीको ठेगाना</label>
                                    @error('Samejasamcompany_s_detail_address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="email"
                                        class="form-control @error('Samejasamcompany_s_detail_email') is-invalid @enderror"
                                        name="Samejasamcompany_s_detail_email"
                                        value="{{ old('Samejasamcompany_s_detail_email', $panjikaran->Samejasamcompany_s_detail_email) }}"
                                        placeholder="समेजसम कम्पनीको इमेल">
                                    <label>समेजसम कम्पनीको इमेल</label>
                                    @error('Samejasamcompany_s_detail_email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Samejasamcompany_s_detail_contact') is-invalid @enderror"
                                        name="Samejasamcompany_s_detail_contact"
                                        value="{{ old('Samejasamcompany_s_detail_contact', $panjikaran->Samejasamcompany_s_detail_contact) }}"
                                        placeholder="समेजसम कम्पनीको सम्पर्क">
                                    <label>समेजसम कम्पनीको सम्पर्क</label>
                                    @error('Samejasamcompany_s_detail_contact')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <h5 class="mt-4 mb-3">प्याकिङ कम्पनीको विवरण</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Packing_company_details_name') is-invalid @enderror"
                                        name="Packing_company_details_name"
                                        value="{{ old('Packing_company_details_name', $panjikaran->Packing_company_details_name) }}"
                                        placeholder="प्याकिङ कम्पनीको नाम">
                                    <label>प्याकिङ कम्पनीको नाम</label>
                                    @error('Packing_company_details_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Packing_company_details_address') is-invalid @enderror"
                                        name="Packing_company_details_address"
                                        value="{{ old('Packing_company_details_address', $panjikaran->Packing_company_details_address) }}"
                                        placeholder="प्याकिङ कम्पनीको ठेगाना">
                                    <label>प्याकिङ कम्पनीको ठेगाना</label>
                                    @error('Packing_company_details_address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="email"
                                        class="form-control @error('Packing_company_details_email') is-invalid @enderror"
                                        name="Packing_company_details_email"
                                        value="{{ old('Packing_company_details_email', $panjikaran->Packing_company_details_email) }}"
                                        placeholder="प्याकिङ कम्पनीको इमेल">
                                    <label>प्याकिङ कम्पनीको इमेल</label>
                                    @error('Packing_company_details_email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Packing_company_details_contact') is-invalid @enderror"
                                        name="Packing_company_details_contact"
                                        value="{{ old('Packing_company_details_contact', $panjikaran->Packing_company_details_contact) }}"
                                        placeholder="प्याकिङ कम्पनीको सम्पर्क">
                                    <label>प्याकिङ कम्पनीको सम्पर्क</label>
                                    @error('Packing_company_details_contact')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <h5 class="mt-4 mb-3">पैठारकर्ता कम्पनीको विवरण</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Paitharkarta_company_details_name') is-invalid @enderror"
                                        name="Paitharkarta_company_details_name"
                                        value="{{ old('Paitharkarta_company_details_name', $panjikaran->Paitharkarta_company_details_name) }}"
                                        placeholder="पैठारकर्ता कम्पनीको नाम">
                                    <label>पैठारकर्ता कम्पनीको नाम</label>
                                    @error('Paitharkarta_company_details_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Paitharkarta_company_details_address') is-invalid @enderror"
                                        name="Paitharkarta_company_details_address"
                                        value="{{ old('Paitharkarta_company_details_address', $panjikaran->Paitharkarta_company_details_address) }}"
                                        placeholder="पैठारकर्ता कम्पनीको ठेगाना">
                                    <label>पैठारकर्ता कम्पनीको ठेगाना</label>
                                    @error('Paitharkarta_company_details_address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="email"
                                        class="form-control @error('Paitharkarta_company_details_email') is-invalid @enderror"
                                        name="Paitharkarta_company_details_email"
                                        value="{{ old('Paitharkarta_company_details_email', $panjikaran->Paitharkarta_company_details_email) }}"
                                        placeholder="पैठारकर्ता कम्पनीको इमेल">
                                    <label>पैठारकर्ता कम्पनीको इमेल</label>
                                    @error('Paitharkarta_company_details_email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Paitharkarta_company_details_contact') is-invalid @enderror"
                                        name="Paitharkarta_company_details_contact"
                                        value="{{ old('Paitharkarta_company_details_contact', $panjikaran->Paitharkarta_company_details_contact) }}"
                                        placeholder="पैठारकर्ता कम्पनीको सम्पर्क">
                                    <label>पैठारकर्ता कम्पनीको सम्पर्क</label>
                                    @error('Paitharkarta_company_details_contact')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa fa-save"></i> अपडेट गर्नुहोस्
                                </button>
                                <a href="{{ route('panjikarans.index') }}" class="btn btn-secondary">
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
