@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">पञ्जीकरण विवरण</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikarans.index') }}">पञ्जीकरणको सूची</a></li>
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
                                <h5 class="card-title">पञ्जीकरण ID: {{ $panjikaran->id }}</h5>
                                <div>
                                    <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => 3]) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-arrow-left"></i> कार्यप्रवाहमा फर्कनुहोस्
                                    </a>
                                    <a href="{{ route('panjikaran.workflow', $panjikaran->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa fa-cogs"></i> कार्यप्रवाह
                                    </a>
                                    <a href="{{ route('panjikarans.edit', $panjikaran->id) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> सम्पादन गर्नुहोस्
                                    </a>
                                    <a href="{{ route('panjikarans.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-arrow-left"></i> सूचीमा फिर्ता
                                    </a>
                                </div>
                            </div>

                            <!-- Basic Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">आधारभूत जानकारी</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>कीटनाशकको सामान्य नाम:</strong>
                                    <p>{{ $panjikaran->CommonNameOfPesticide }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>रासायनिक नाम:</strong>
                                    <p>{{ $panjikaran->ChemicalName }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>IUPAC नाम:</strong>
                                    <p>{{ $panjikaran->IUPAC_Name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Cas No:</strong>
                                    <p>{{ $panjikaran->Cas_No ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>आणविक सूत्र:</strong>
                                    <p>{{ $panjikaran->Atomic_Formula ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Categories -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">वर्गीकरण</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>स्रोत:</strong>
                                    <p>{{ $panjikaran->source->sourcename ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>उद्देश्य:</strong>
                                    <p>{{ $panjikaran->objective->objective ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>उपयोग:</strong>
                                    <p>{{ $panjikaran->usage->usage_name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Usage Details -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">प्रयोग विवरण</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>डप्पर मात्रा:</strong>
                                    <p>{{ $panjikaran->DapperQuantity ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>इकाई:</strong>
                                    <p>{{ $panjikaran->unit->unit_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>प्रतीक्षा अवधि:</strong>
                                    <p>{{ $panjikaran->Waiting_duration ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>प्राथमिक उपचार:</strong>
                                    <p>{{ $panjikaran->FirstAid ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>प्याकेज नष्ट विधि:</strong>
                                    <p>{{ $panjikaran->packageDestroy->packagedestroy_name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Bargikaran Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-primary border-bottom pb-2 mb-0">वर्गीकरण व्यवस्थापन</h6>
                                        <a href="{{ route('bargikarans.index', ['panjikaran_id' => $panjikaran->id]) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-external-link"></i> विस्तृत हेर्नुहोस्
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    @if ($panjikaran->bargikarans && $panjikaran->bargikarans->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>कोड</th>
                                                        <th>बनावट</th>
                                                        <th>मिति</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($panjikaran->bargikarans->take(5) as $sn => $bargikaran)
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td>{{ $bargikaran->code }}</td>
                                                            <td>{{ $bargikaran->make }}</td>
                                                            <td>{{ $bargikaran->created_at->format('Y-m-d') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @if ($panjikaran->bargikarans->count() > 5)
                                                <p class="text-muted small">
                                                    <i class="fa fa-info-circle"></i>
                                                    कुल {{ $panjikaran->bargikarans->count() }} वर्गीकरण मध्ये
                                                    {{ min(5, $panjikaran->bargikarans->count()) }} देखाइएको छ
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> कुनै वर्गीकरण डाटा उपलब्ध छैन
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Recommended Crops Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-success border-bottom pb-2 mb-0">सिफारिस गरिएको बाली व्यवस्थापन</h6>
                                        <a href="{{ route('recommended-crops.index', ['panjikaran_id' => $panjikaran->id]) }}"
                                            class="btn btn-sm btn-outline-success">
                                            <i class="fa fa-external-link"></i> विस्तृत हेर्नुहोस्
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    @if ($panjikaran->recommendedCrops && $panjikaran->recommendedCrops->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>बालीको नाम</th>
                                                        <th>मिति</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($panjikaran->recommendedCrops->take(5) as $sn => $recommendedCrop)
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td>{{ $recommendedCrop->crop->crop_name ?? 'N/A' }}</td>
                                                            <td>{{ $recommendedCrop->created_at->format('Y-m-d') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @if ($panjikaran->recommendedCrops->count() > 5)
                                                <p class="text-muted small">
                                                    <i class="fa fa-info-circle"></i>
                                                    कुल {{ $panjikaran->recommendedCrops->count() }} सिफारिस बाली मध्ये
                                                    {{ min(5, $panjikaran->recommendedCrops->count()) }} देखाइएको छ
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> कुनै सिफारिस गरिएको बाली डाटा उपलब्ध छैन
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Recommended Pests Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-warning border-bottom pb-2 mb-0">सिफारिस गरिएको कीरा व्यवस्थापन</h6>
                                        <a href="{{ route('recommended-pests.index', ['panjikaran_id' => $panjikaran->id]) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="fa fa-external-link"></i> विस्तृत हेर्नुहोस्
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    @if ($panjikaran->recommendedPests && $panjikaran->recommendedPests->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>कीराको नाम</th>
                                                        <th>मिति</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($panjikaran->recommendedPests->take(5) as $sn => $recommendedPest)
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td>{{ $recommendedPest->pest->pest ?? 'N/A' }}</td>
                                                            <td>{{ $recommendedPest->created_at->format('Y-m-d') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @if ($panjikaran->recommendedPests->count() > 5)
                                                <p class="text-muted small">
                                                    <i class="fa fa-info-circle"></i>
                                                    कुल {{ $panjikaran->recommendedPests->count() }} सिफारिस कीरा मध्ये
                                                    {{ min(5, $panjikaran->recommendedPests->count()) }} देखाइएको छ
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> कुनै सिफारिस गरिएको कीरा डाटा उपलब्ध छैन
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Foreign Producer Company -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">विदेशी उत्पादक कम्पनीको विवरण</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>कम्पनीको नाम:</strong>
                                    <p>{{ $panjikaran->Foreign_producer_company_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>ठेगाना:</strong>
                                    <p>{{ $panjikaran->Foreign_producer_company_address ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Nepali Producer Company -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">नेपाली उत्पादक कम्पनीको विवरण</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>कम्पनीको नाम:</strong>
                                    <p>{{ $panjikaran->Nepali_producer_company_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>ठेगाना:</strong>
                                    <p>{{ $panjikaran->Nepali_producer_company_address ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>इमेल:</strong>
                                    <p>{{ $panjikaran->Nepali_producer_company_email ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>सम्पर्क:</strong>
                                    <p>{{ $panjikaran->Nepali_producer_company_contact ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Samejasam Company -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">समेजसम कम्पनीको विवरण</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>कम्पनीको नाम:</strong>
                                    <p>{{ $panjikaran->Samejasamcompany_s_detail_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>ठेगाना:</strong>
                                    <p>{{ $panjikaran->Samejasamcompany_s_detail_address ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>इमेल:</strong>
                                    <p>{{ $panjikaran->Samejasamcompany_s_detail_email ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>सम्पर्क:</strong>
                                    <p>{{ $panjikaran->Samejasamcompany_s_detail_contact ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Packing Company -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">प्याकिङ कम्पनीको विवरण</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>कम्पनीको नाम:</strong>
                                    <p>{{ $panjikaran->Packing_company_details_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>ठेगाना:</strong>
                                    <p>{{ $panjikaran->Packing_company_details_address ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>इमेल:</strong>
                                    <p>{{ $panjikaran->Packing_company_details_email ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>सम्पर्क:</strong>
                                    <p>{{ $panjikaran->Packing_company_details_contact ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Paitharkarta Company -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">पैठारकर्ता कम्पनीको विवरण</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>कम्पनीको नाम:</strong>
                                    <p>{{ $panjikaran->Paitharkarta_company_details_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>ठेगाना:</strong>
                                    <p>{{ $panjikaran->Paitharkarta_company_details_address ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>इमेल:</strong>
                                    <p>{{ $panjikaran->Paitharkarta_company_details_email ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>सम्पर्क:</strong>
                                    <p>{{ $panjikaran->Paitharkarta_company_details_contact ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Checklist Information -->
                            @if ($panjikaran->checklist)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary border-bottom pb-2">सम्बन्धित चेकलिस्ट</h6>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>आवेदन संख्या:</strong>
                                        <p>{{ $panjikaran->checklist->ApplicationNo ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong>स्थिति:</strong>
                                        <p>{!! $panjikaran->checklist->getStatusWithIcon() !!}</p>
                                    </div>
                                </div>
                            @endif
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
