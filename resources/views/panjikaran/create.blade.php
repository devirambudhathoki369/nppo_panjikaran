@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">पञ्जीकरण थप्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('panjikarans.index', ['checklist_id' => request('checklist_id')]) }}">
                                पञ्जीकरणको सूची
                            </a>
                        </li>
                        <li class="breadcrumb-item active">थप्नुहोस्</li>
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
                    @endif

                    <form action="{{ route('panjikarans.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="ChecklistID" value="{{ $checklistId ?? '' }}">

                        <div class="row">
                            <!-- Dropdowns - Removed SourceID since it's in common_names -->
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select @error('ObjectiveID') is-invalid @enderror"
                                        name="ObjectiveID" required>
                                        <option value="">उद्देश्य छान्नुहोस्</option>
                                        @foreach ($objectives as $objective)
                                            <option value="{{ $objective->id }}"
                                                {{ old('ObjectiveID') == $objective->id ? 'selected' : '' }}>
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
                                                {{ old('UsageID') == $usage->id ? 'selected' : '' }}>
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
                                        name="DapperQuantity" value="{{ old('DapperQuantity') }}"
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
                                                {{ old('DQUnitID') == $unit->id ? 'selected' : '' }}>
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
                                        name="Waiting_duration" value="{{ old('Waiting_duration') }}"
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
                                        name="FirstAid" value="{{ old('FirstAid') }}" placeholder="प्राथमिक उपचार">
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
                                                {{ old('PackageDestroyID') == $packageDestroy->id ? 'selected' : '' }}>
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
                                        value="{{ old('Foreign_producer_company_name') }}"
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
                                        value="{{ old('Foreign_producer_company_address') }}"
                                        placeholder="विदेशी उत्पादक कम्पनीको ठेगाना">
                                    <label>विदेशी उत्पादक कम्पनीको ठेगाना</label>
                                    @error('Foreign_producer_company_address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <h5 class="mt-4 mb-3">नेपाली उत्पादक कम्पनीको विवरण</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('Nepali_producer_company_name') is-invalid @enderror"
                                        name="Nepali_producer_company_name"
                                        value="{{ old('Nepali_producer_company_name') }}"
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
                                        value="{{ old('Nepali_producer_company_address') }}"
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
                                        value="{{ old('Nepali_producer_company_email') }}"
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
                                        value="{{ old('Nepali_producer_company_contact') }}"
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
                                        value="{{ old('Samejasamcompany_s_detail_name') }}"
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
                                        value="{{ old('Samejasamcompany_s_detail_address') }}"
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
                                        value="{{ old('Samejasamcompany_s_detail_email') }}"
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
                                        value="{{ old('Samejasamcompany_s_detail_contact') }}"
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
                                        value="{{ old('Packing_company_details_name') }}"
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
                                        value="{{ old('Packing_company_details_address') }}"
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
                                        value="{{ old('Packing_company_details_email') }}"
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
                                        value="{{ old('Packing_company_details_contact') }}"
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
                                        value="{{ old('Paitharkarta_company_details_name') }}"
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
                                        value="{{ old('Paitharkarta_company_details_address') }}"
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
                                        value="{{ old('Paitharkarta_company_details_email') }}"
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
                                        value="{{ old('Paitharkarta_company_details_contact') }}"
                                        placeholder="पैठारकर्ता कम्पनीको सम्पर्क">
                                    <label>पैठारकर्ता कम्पनीको सम्पर्क</label>
                                    @error('Paitharkarta_company_details_contact')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa fa-save"></i> सेभ गर्नुहोस्
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
