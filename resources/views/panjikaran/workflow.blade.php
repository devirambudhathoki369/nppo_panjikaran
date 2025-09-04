@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">पञ्जीकरण कार्यप्रवाह</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikarans.index') }}">पञ्जीकरणको सूची</a></li>
                        <li class="breadcrumb-item active">कार्यप्रवाह</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Panjikaran Details -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">पञ्जीकरण विवरण</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>आवेदनकर्ता:</strong> {{ $panjikaran->checklist->ImporterName ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>उद्देश्य:</strong> {{ $panjikaran->objective->objective ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>उपयोग:</strong> {{ $panjikaran->usage->usage_name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Common Names from Checklist -->
                    @if($panjikaran->checklist && $panjikaran->checklist->check_list_formulations->count() > 0)
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
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Workflow Steps -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Progress Steps -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="progress-nav">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $currentStep * 20 }}%"
                                        aria-valuenow="{{ $currentStep * 20 }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="progress-nav-steps">
                                    <div class="step {{ $currentStep >= 1 ? 'active' : '' }}">
                                        <span class="step-number">1</span>
                                        <span class="step-title">बिश्व स्वास्थ्य संगठनको वर्गीकरण</span>
                                    </div>
                                    <div class="step {{ $currentStep >= 2 ? 'active' : '' }}">
                                        <span class="step-number">2</span>
                                        <span class="step-title">सिफारिस बाली</span>
                                    </div>
                                    <div class="step {{ $currentStep >= 3 ? 'active' : '' }}">
                                        <span class="step-number">3</span>
                                        <span class="step-title">सिफारिस कीरा</span>
                                    </div>
                                    <div class="step {{ $currentStep >= 4 ? 'active' : '' }}">
                                        <span class="step-number">4</span>
                                        <span class="step-title">H.C.S विवरण</span>
                                    </div>
                                    <div class="step {{ $currentStep >= 5 ? 'active' : '' }}">
                                        <span class="step-number">5</span>
                                        <span class="step-title">NNSW विवरण</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons (Top) -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    @if ($currentStep > 1)
                                        <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => $currentStep - 1]) }}"
                                            class="btn btn-secondary">
                                            <i class="fa fa-arrow-left"></i> अघिल्लो चरण
                                        </a>
                                    @endif
                                </div>
                                <div>
                                    @if ($currentStep < 5)
                                        <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => $currentStep + 1]) }}"
                                            class="btn btn-primary">
                                            अर्को चरण <i class="fa fa-arrow-right"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('panjikarans.show', $panjikaran->id) }}"
                                            class="btn btn-success">
                                            <i class="fa fa-check"></i> पूरा भयो
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        @if ($currentStep == 1)
                            <!-- Bargikaran Tab -->
                            <div class="tab-pane fade show active">
                                <h5 class="mb-3">बिश्व स्वास्थ्य संगठनको वर्गीकरण व्यवस्थापन</h5>

                                <!-- Add New Bargikaran Form -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title">नयाँ वर्गीकरण थप्नुहोस्</h6>

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <form action="{{ route('bargikarans.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="from_workflow" value="1">
                                            <input type="hidden" name="panjikaran_id" value="{{ $panjikaran->id }}">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="code" class="form-label">कोड <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" id="code"
                                                            name="code" value="{{ old('code') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="make" class="form-label">बनावट <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="make"
                                                            name="make" value="{{ old('make') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="fa fa-plus"></i> थप्नुहोस्
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Bargikaran List -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>कोड</th>
                                                <th>बनावट</th>
                                                <th>मिति</th>
                                                <th>कार्य</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($bargikarans as $sn => $bargikaran)
                                                <tr>
                                                    <td>{{ ++$sn }}</td>
                                                    <td>{{ $bargikaran->code }}</td>
                                                    <td>{{ $bargikaran->make }}</td>
                                                    <td>{{ $bargikaran->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <a href="{{ route('bargikarans.edit', $bargikaran->id) }}"
                                                            class="btn btn-success btn-xs">
                                                            <i class="bx bx-edit"></i>
                                                        </a>
                                                        <form action="{{ route('bargikarans.destroy', $bargikaran) }}"
                                                              method="POST" style="display: inline;"
                                                              onsubmit="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="from_workflow" value="1">
                                                            <button type="submit" class="btn btn-danger btn-xs">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">कुनै डाटा उपलब्ध छैन</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @elseif($currentStep == 2)
                            <!-- Recommended Crops Tab -->
                            <div class="tab-pane fade show active">
                                <h5 class="mb-3">सिफारिस गरिएको बाली व्यवस्थापन</h5>

                                <!-- Add New Recommended Crop Form -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title">नयाँ बाली सिफारिस थप्नुहोस्</h6>

                                        <form action="{{ route('recommended-crops.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="from_workflow" value="1">
                                            <input type="hidden" name="panjikaran_id" value="{{ $panjikaran->id }}">

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label for="crop_id" class="form-label">बाली <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select" id="crop_id" name="crop_id"
                                                            required>
                                                            <option value="">बाली छान्नुहोस्</option>
                                                            @foreach ($crops as $crop)
                                                                <option value="{{ $crop->id }}">
                                                                    {{ $crop->crop_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="fa fa-plus"></i> थप्नुहोस्
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Recommended Crops List -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>बालीको नाम</th>
                                                <th>मिति</th>
                                                <th>कार्य</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($recommendedCrops as $sn => $recommendedCrop)
                                                <tr>
                                                    <td>{{ ++$sn }}</td>
                                                    <td>{{ $recommendedCrop->crop->crop_name ?? 'N/A' }}</td>
                                                    <td>{{ $recommendedCrop->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <a href="{{ route('recommended-crops.edit', $recommendedCrop->id) }}"
                                                            class="btn btn-success btn-xs">
                                                            <i class="bx bx-edit"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('recommended-crops.destroy', $recommendedCrop->id) }}"
                                                            method="POST" style="display: inline-block;"
                                                            onsubmit="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="from_workflow" value="1">
                                                            <button type="submit" class="btn btn-xs btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">कुनै डाटा उपलब्ध छैन</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @elseif($currentStep == 3)
                            <!-- Recommended Pests Tab -->
                            <div class="tab-pane fade show active">
                                <h5 class="mb-3">सिफारिस गरिएको कीरा व्यवस्थापन</h5>

                                <!-- Add New Recommended Pest Form -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title">नयाँ कीरा सिफारिस थप्नुहोस्</h6>

                                        <form action="{{ route('recommended-pests.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="from_workflow" value="1">
                                            <input type="hidden" name="panjikaran_id" value="{{ $panjikaran->id }}">

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label for="pest_id" class="form-label">कीरा <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select" id="pest_id" name="pest_id"
                                                            required>
                                                            <option value="">कीरा छान्नुहोस्</option>
                                                            @foreach ($pests as $pest)
                                                                <option value="{{ $pest->id }}">{{ $pest->pest }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="fa fa-plus"></i> थप्नुहोस्
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Recommended Pests List -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>कीराको नाम</th>
                                                <th>मिति</th>
                                                <th>कार्य</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($recommendedPests as $sn => $recommendedPest)
                                                <tr>
                                                    <td>{{ ++$sn }}</td>
                                                    <td>{{ $recommendedPest->pest->pest ?? 'N/A' }}</td>
                                                    <td>{{ $recommendedPest->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <a href="{{ route('recommended-pests.edit', $recommendedPest->id) }}"
                                                            class="btn btn-success btn-xs">
                                                            <i class="bx bx-edit"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('recommended-pests.destroy', $recommendedPest->id) }}"
                                                            method="POST" style="display: inline-block;"
                                                            onsubmit="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="from_workflow" value="1">
                                                            <button type="submit" class="btn btn-xs btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">कुनै डाटा उपलब्ध छैन</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @elseif($currentStep == 4)
                            <!-- HCS Details Tab -->
                            <div class="tab-pane fade show active">
                                <h5 class="mb-3">H.C.S विवरण व्यवस्थापन</h5>

                                <!-- Add New HCS Detail Form -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title">नयाँ H.C.S विवरण थप्नुहोस्</h6>

                                        <form action="{{ route('hcs-details.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="from_workflow" value="1">
                                            <input type="hidden" name="checklist_id" value="{{ $panjikaran->checklist->id }}">
                                            <input type="hidden" name="panjikaran_id" value="{{ $panjikaran->id }}">

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="self_life_of_the_product" class="form-label">उत्पादनको शेल्फ लाइफ</label>
                                                        <input type="text" class="form-control" id="self_life_of_the_product"
                                                            name="self_life_of_the_product" value="{{ old('self_life_of_the_product') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="date" class="form-label">मिति</label>
                                                        <input type="date" class="form-control" id="date"
                                                            name="date" value="{{ old('date') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="hcs_code" class="form-label">H.C.S कोड <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control @error('hcs_code') is-invalid @enderror"
                                                            id="hcs_code" name="hcs_code" value="{{ old('hcs_code') }}" required>
                                                        @error('hcs_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="fa fa-plus"></i> थप्नुहोस्
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="tax_payment_bhauchar_details" class="form-label">कर भुक्तानी भौचर विवरण</label>
                                                        <textarea class="form-control" id="tax_payment_bhauchar_details"
                                                            name="tax_payment_bhauchar_details" rows="3">{{ old('tax_payment_bhauchar_details') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- HCS Details List -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>H.C.S कोड</th>
                                                <th>शेल्फ लाइफ</th>
                                                <th>कर भुक्तानी विवरण</th>
                                                <th>मिति</th>
                                                <th>कार्य</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($hcsDetails as $sn => $hcsDetail)
                                                <tr>
                                                    <td>{{ ++$sn }}</td>
                                                    <td>{{ $hcsDetail->hcs_code }}</td>
                                                    <td>{{ $hcsDetail->self_life_of_the_product ?? 'N/A' }}</td>
                                                    <td>{{ Str::limit($hcsDetail->tax_payment_bhauchar_details, 50) ?? 'N/A' }}</td>
                                                    <td>{{ $hcsDetail->date ? $hcsDetail->date->format('Y-m-d') : 'N/A' }}</td>
                                                    <td>
                                                        <a href="{{ route('hcs-details.edit', $hcsDetail->id) }}"
                                                            class="btn btn-success btn-xs">
                                                            <i class="bx bx-edit"></i>
                                                        </a>
                                                        <form action="{{ route('hcs-details.destroy', $hcsDetail->id) }}"
                                                            method="POST" style="display: inline-block;"
                                                            onsubmit="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="from_workflow" value="1">
                                                            <button type="submit" class="btn btn-xs btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">कुनै डाटा उपलब्ध छैन</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <!-- NNSW Details Tab (Step 5) -->
                            <div class="tab-pane fade show active">
                                <h5 class="mb-3">NNSW विवरण व्यवस्थापन</h5>

                                <!-- Add New NNSW Detail Form -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title">नयाँ NNSW विवरण थप्नुहोस्</h6>

                                        <form action="{{ route('nnsw-details.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="from_workflow" value="1">
                                            <input type="hidden" name="checklist_id" value="{{ $panjikaran->checklist->id }}">
                                            <input type="hidden" name="panjikaran_id" value="{{ $panjikaran->id }}">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="nepal_rastriya_ekdwar_pranalima_anurodh_no" class="form-label">नेपाल राष्ट्रिय एकद्वार प्रणालीमा अनुरोध नं.</label>
                                                        <input type="text" class="form-control" id="nepal_rastriya_ekdwar_pranalima_anurodh_no"
                                                            name="nepal_rastriya_ekdwar_pranalima_anurodh_no" value="{{ old('nepal_rastriya_ekdwar_pranalima_anurodh_no') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="nepal_rastriya_ekdwar_pranalima_anurodh_date" class="form-label">नेपाल राष्ट्रिय एकद्वार प्रणालीमा अनुरोध मिति</label>
                                                        <input type="date" class="form-control" id="nepal_rastriya_ekdwar_pranalima_anurodh_date"
                                                            name="nepal_rastriya_ekdwar_pranalima_anurodh_date" value="{{ old('nepal_rastriya_ekdwar_pranalima_anurodh_date') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="company_code" class="form-label">कम्पनी कोड</label>
                                                        <input type="text" class="form-control" id="company_code"
                                                            name="company_code" value="{{ old('company_code') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="swikrit_no" class="form-label">स्वीकृति नं.</label>
                                                        <input type="text" class="form-control" id="swikrit_no"
                                                            name="swikrit_no" value="{{ old('swikrit_no') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="swikrit_date" class="form-label">स्वीकृति मिति</label>
                                                        <input type="date" class="form-control" id="swikrit_date"
                                                            name="swikrit_date" value="{{ old('swikrit_date') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label for="baidata_abadhi" class="form-label">वैधता अवधि</label>
                                                        <input type="text" class="form-control" id="baidata_abadhi"
                                                            name="baidata_abadhi" value="{{ old('baidata_abadhi') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="fa fa-plus"></i> थप्नुहोस्
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- NNSW Details List -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>अनुरोध नं.</th>
                                                <th>अनुरोध मिति</th>
                                                <th>कम्पनी कोड</th>
                                                <th>स्वीकृति नं.</th>
                                                <th>स्वीकृति मिति</th>
                                                <th>वैधता अवधि</th>
                                                <th>कार्य</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($nnswDetails as $sn => $nnswDetail)
                                                <tr>
                                                    <td>{{ ++$sn }}</td>
                                                    <td>{{ $nnswDetail->nepal_rastriya_ekdwar_pranalima_anurodh_no ?? 'N/A' }}</td>
                                                    <td>{{ $nnswDetail->nepal_rastriya_ekdwar_pranalima_anurodh_date ? $nnswDetail->nepal_rastriya_ekdwar_pranalima_anurodh_date->format('Y-m-d') : 'N/A' }}</td>
                                                    <td>{{ $nnswDetail->company_code ?? 'N/A' }}</td>
                                                    <td>{{ $nnswDetail->swikrit_no ?? 'N/A' }}</td>
                                                    <td>{{ $nnswDetail->swikrit_date ? $nnswDetail->swikrit_date->format('Y-m-d') : 'N/A' }}</td>
                                                    <td>{{ $nnswDetail->baidata_abadhi ?? 'N/A' }}</td>
                                                    <td>
                                                        <a href="{{ route('nnsw-details.edit', $nnswDetail->id) }}"
                                                            class="btn btn-success btn-xs">
                                                            <i class="bx bx-edit"></i>
                                                        </a>
                                                        <form action="{{ route('nnsw-details.destroy', $nnswDetail->id) }}"
                                                            method="POST" style="display: inline-block;"
                                                            onsubmit="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="from_workflow" value="1">
                                                            <button type="submit" class="btn btn-xs btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">कुनै डाटा उपलब्ध छैन</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Navigation Buttons (Bottom) -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    @if ($currentStep > 1)
                                        <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => $currentStep - 1]) }}"
                                            class="btn btn-secondary">
                                            <i class="fa fa-arrow-left"></i> अघिल्लो चरण
                                        </a>
                                    @endif
                                </div>
                                <div>
                                    @if ($currentStep < 5)
                                        <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => $currentStep + 1]) }}"
                                            class="btn btn-primary">
                                            अर्को चरण <i class="fa fa-arrow-right"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('panjikarans.show', $panjikaran->id) }}"
                                            class="btn btn-success">
                                            <i class="fa fa-check"></i> पूरा भयो
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .progress-nav {
            position: relative;
            margin-bottom: 2rem;
        }

        .progress {
            height: 4px;
            background-color: #e9ecef;
        }

        .progress-nav-steps {
            display: flex;
            justify-content: space-between;
            margin-top: -2px;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .step-number {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: #6c757d;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .step.active .step-number {
            background-color: #007bff;
        }

        .step-title {
            font-size: 12px;
            font-weight: 500;
            color: #6c757d;
            text-align: center;
        }

        .step.active .step-title {
            color: #007bff;
        }
    </style>
@endsection
