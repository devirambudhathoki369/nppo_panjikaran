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
                                    <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => 5]) }}"
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

                            <!-- Common Names from Checklist -->
                            @if($panjikaran->checklist && $panjikaran->checklist->check_list_formulations->count() > 0)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary border-bottom pb-2">सामान्य नामहरू र रासायनिक विवरण</h6>
                                    </div>
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>सामान्य नाम</th>
                                                        <th>रासायनिक नाम</th>
                                                        <th>IUPAC नाम</th>
                                                        <th>CAS नम्बर</th>
                                                        <th>आणविक सूत्र</th>
                                                        <th>स्रोत</th>
                                                        <th>फॉर्मुलेशन</th>
                                                        <th>मात्रा</th>
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
                                                            <td>{{ $formulation->common_name->source->sourcename ?? 'N/A' }}</td>
                                                            <td>{{ $formulation->formulation->formulation_name ?? 'N/A' }}</td>
                                                            <td>{{ $formulation->ActiveIngredientValue ?? 'N/A' }} {{ $formulation->unit->unit_name ?? '' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Categories -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2">वर्गीकरण</h6>
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
                                    <strong>जीवनाशक विषादीको प्रभावक मात्रा:</strong>
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
                                        <h6 class="text-primary border-bottom pb-2 mb-0">बिश्व स्वास्थ्य संगठनको वर्गीकरण व्यवस्थापन</h6>
                                        <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => 1]) }}"
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
                                        <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => 2]) }}"
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
                                        <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => 3]) }}"
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

                            <!-- HCS Details Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-info border-bottom pb-2 mb-0">H.C.S विवरण व्यवस्थापन</h6>
                                        <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => 4]) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="fa fa-external-link"></i> विस्तृत हेर्नुहोस्
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    @if ($panjikaran->hcsDetails && $panjikaran->hcsDetails->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>H.C.S कोड</th>
                                                        <th>शेल्फ लाइफ</th>
                                                        <th>कर भुक्तानी विवरण</th>
                                                        <th>मिति</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($panjikaran->hcsDetails->take(5) as $sn => $hcsDetail)
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td>{{ $hcsDetail->hcs_code }}</td>
                                                            <td>{{ $hcsDetail->self_life_of_the_product ?? 'N/A' }}</td>
                                                            <td>{{ Str::limit($hcsDetail->tax_payment_bhauchar_details, 50) ?? 'N/A' }}</td>
                                                            <td>{{ $hcsDetail->date ? $hcsDetail->date->format('Y-m-d') : 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @if ($panjikaran->hcsDetails->count() > 5)
                                                <p class="text-muted small">
                                                    <i class="fa fa-info-circle"></i>
                                                    कुल {{ $panjikaran->hcsDetails->count() }} H.C.S विवरण मध्ये
                                                    {{ min(5, $panjikaran->hcsDetails->count()) }} देखाइएको छ
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> कुनै H.C.S विवरण डाटा उपलब्ध छैन
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- NNSW Details Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="text-secondary border-bottom pb-2 mb-0">NNSW विवरण व्यवस्थापन</h6>
                                        <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => 5]) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="fa fa-external-link"></i> विस्तृत हेर्नुहोस्
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    @if ($panjikaran->nnswDetails && $panjikaran->nnswDetails->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>अनुरोध नं.</th>
                                                        <th>अनुरोध मिति</th>
                                                        <th>कम्पनी कोड</th>
                                                        <th>स्वीकृति नं.</th>
                                                        <th>स्वीकृति मिति</th>
                                                        <th>वैधता अवधि</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($panjikaran->nnswDetails->take(5) as $sn => $nnswDetail)
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td>{{ $nnswDetail->nepal_rastriya_ekdwar_pranalima_anurodh_no ?? 'N/A' }}</td>
                                                            <td>{{ $nnswDetail->nepal_rastriya_ekdwar_pranalima_anurodh_date ? $nnswDetail->nepal_rastriya_ekdwar_pranalima_anurodh_date->format('Y-m-d') : 'N/A' }}</td>
                                                            <td>{{ $nnswDetail->company_code ?? 'N/A' }}</td>
                                                            <td>{{ $nnswDetail->swikrit_no ?? 'N/A' }}</td>
                                                            <td>{{ $nnswDetail->swikrit_date ? $nnswDetail->swikrit_date->format('Y-m-d') : 'N/A' }}</td>
                                                            <td>{{ $nnswDetail->baidata_abadhi ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @if ($panjikaran->nnswDetails->count() > 5)
                                                <p class="text-muted small">
                                                    <i class="fa fa-info-circle"></i>
                                                    कुल {{ $panjikaran->nnswDetails->count() }} NNSW विवरण मध्ये
                                                    {{ min(5, $panjikaran->nnswDetails->count()) }} देखाइएको छ
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> कुनै NNSW विवरण डाटा उपलब्ध छैन
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
