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

    <!-- Alert Messages -->
    {{-- @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}

    <!-- Panjikaran Details -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">पञ्जीकरण विवरण</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>आवेदनकर्ता:</strong> {{ $panjikaran->checklist->ImporterName ?? 'N/A' }}</p>
                            <p><strong>इजाजतपत्र नं.:</strong> {{ $panjikaran->checklist->LicenseNo ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>रासायनिक नाम:</strong> {{ $panjikaran->ChemicalName }}</p>
                            <p><strong>स्रोत:</strong> {{ $panjikaran->source->sourcename ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>उद्देश्य:</strong> {{ $panjikaran->objective->objective ?? 'N/A' }}</p>
                            <p><strong>उपयोग:</strong> {{ $panjikaran->usage->usage_name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Common Names from Checklist -->
                    @if($panjikaran->checklist && $panjikaran->checklist->check_list_formulations->count() > 0)
                        <div class="mt-3">
                            <h6><strong>सामान्य नामहरू:</strong></h6>
                            <div class="row">
                                @foreach($panjikaran->checklist->check_list_formulations as $formulation)
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
                                    <div class="progress-bar" role="progressbar" style="width: {{ $currentStep * 33.33 }}%"
                                        aria-valuenow="{{ $currentStep * 33.33 }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="progress-nav-steps">
                                    <div class="step {{ $currentStep >= 1 ? 'active' : '' }}">
                                        <span class="step-number">1</span>
                                        <span class="step-title">वर्गीकरण</span>
                                        @if($bargikarans->count() > 0)
                                            <small class="text-success mt-1">
                                                <i class="fas fa-check-circle"></i> {{ $bargikarans->count() }} रेकर्ड
                                            </small>
                                        @endif
                                    </div>
                                    <div class="step {{ $currentStep >= 2 ? 'active' : '' }}">
                                        <span class="step-number">2</span>
                                        <span class="step-title">सिफारिस बाली</span>
                                        @if($recommendedCrops->count() > 0)
                                            <small class="text-success mt-1">
                                                <i class="fas fa-check-circle"></i> {{ $recommendedCrops->count() }} रेकर्ड
                                            </small>
                                        @endif
                                    </div>
                                    <div class="step {{ $currentStep >= 3 ? 'active' : '' }}">
                                        <span class="step-number">3</span>
                                        <span class="step-title">सिफारिस कीरा</span>
                                        @if($recommendedPests->count() > 0)
                                            <small class="text-success mt-1">
                                                <i class="fas fa-check-circle"></i> {{ $recommendedPests->count() }} रेकर्ड
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        @if ($currentStep == 1)
                            <!-- Bargikaran Tab -->
                            <div class="tab-pane fade show active">
                                <h5 class="mb-3">
                                    <i class="fas fa-layer-group text-primary"></i> वर्गीकरण व्यवस्थापन
                                </h5>

                                <!-- Add New Bargikaran Form -->
                                <div class="card mb-4 border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-plus-circle"></i> नयाँ वर्गीकरण थप्नुहोस्
                                        </h6>
                                    </div>
                                    <div class="card-body">
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
                                                    <div class="form-floating mb-3">
                                                        <input type="number" class="form-control" id="code"
                                                            name="code" value="{{ old('code') }}" required placeholder="कोड">
                                                        <label for="code">कोड <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="make"
                                                            name="make" value="{{ old('make') }}" required placeholder="बनावट">
                                                        <label for="make">बनावट <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-primary w-100" style="height: 58px;">
                                                            <i class="fa fa-plus"></i> थप्नुहोस्
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Bargikaran List -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-list"></i> वर्गीकरण सूची
                                            <span class="badge bg-info ms-2">{{ $bargikarans->count() }} रेकर्ड</span>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th style="width: 10%;">S.N.</th>
                                                        <th style="width: 20%;">कोड</th>
                                                        <th style="width: 40%;">बनावट</th>
                                                        <th style="width: 20%;">मिति</th>
                                                        <th style="width: 10%;">कार्य</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($bargikarans as $sn => $bargikaran)
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td><strong>{{ $bargikaran->code }}</strong></td>
                                                            <td>{{ $bargikaran->make }}</td>
                                                            <td>{{ $bargikaran->created_at->format('Y-m-d') }}</td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('bargikarans.edit', $bargikaran->id) }}"
                                                                        class="btn btn-success btn-sm" title="सम्पादन गर्नुहोस्">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                    <form action="{{ route('bargikarans.destroy', $bargikaran) }}"
                                                                          method="POST" style="display: inline;"
                                                                          onsubmit="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <input type="hidden" name="from_workflow" value="1">
                                                                        <button type="submit" class="btn btn-danger btn-sm" title="मेटाउनुहोस्">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center py-4">
                                                                <div class="text-muted">
                                                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                                                    <p>कुनै वर्गीकरण डाटा उपलब्ध छैन</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($currentStep == 2)
                            <!-- Recommended Crops Tab -->
                            <div class="tab-pane fade show active">
                                <h5 class="mb-3">
                                    <i class="fas fa-seedling text-success"></i> सिफारिस गरिएको बाली व्यवस्थापन
                                </h5>

                                <!-- Add New Recommended Crop Form -->
                                <div class="card mb-4 border-success">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-plus-circle"></i> नयाँ बाली सिफारिस थप्नुहोस्
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('recommended-crops.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="from_workflow" value="1">
                                            <input type="hidden" name="panjikaran_id" value="{{ $panjikaran->id }}">

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" id="crop_id" name="crop_id" required>
                                                            <option value="">बाली छान्नुहोस्</option>
                                                            @foreach ($crops as $crop)
                                                                <option value="{{ $crop->id }}" {{ old('crop_id') == $crop->id ? 'selected' : '' }}>
                                                                    {{ $crop->crop_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label for="crop_id">बाली <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-success w-100" style="height: 58px;">
                                                            <i class="fa fa-plus"></i> थप्नुहोस्
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Recommended Crops List -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-list"></i> सिफारिस गरिएको बाली सूची
                                            <span class="badge bg-info ms-2">{{ $recommendedCrops->count() }} रेकर्ड</span>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th style="width: 10%;">S.N.</th>
                                                        <th style="width: 50%;">बालीको नाम</th>
                                                        <th style="width: 25%;">मिति</th>
                                                        <th style="width: 15%;">कार्य</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($recommendedCrops as $sn => $recommendedCrop)
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td>
                                                                <strong>{{ $recommendedCrop->crop->crop_name ?? 'N/A' }}</strong>
                                                            </td>
                                                            <td>{{ $recommendedCrop->created_at->format('Y-m-d') }}</td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('recommended-crops.edit', $recommendedCrop->id) }}"
                                                                        class="btn btn-success btn-sm" title="सम्पादन गर्नुहोस्">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                    <form action="{{ route('recommended-crops.destroy', $recommendedCrop->id) }}"
                                                                          method="POST" style="display: inline;"
                                                                          onsubmit="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <input type="hidden" name="from_workflow" value="1">
                                                                        <button type="submit" class="btn btn-danger btn-sm" title="मेटाउनुहोस्">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center py-4">
                                                                <div class="text-muted">
                                                                    <i class="fas fa-seedling fa-2x mb-2"></i>
                                                                    <p>कुनै बाली सिफारिस डाटा उपलब्ध छैन</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Recommended Pests Tab (Step 3) -->
                            <div class="tab-pane fade show active">
                                <h5 class="mb-3">
                                    <i class="fas fa-bug text-warning"></i> सिफारिस गरिएको कीरा व्यवस्थापन
                                </h5>

                                <!-- Add New Recommended Pest Form -->
                                <div class="card mb-4 border-warning">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-plus-circle"></i> नयाँ कीरा सिफारिस थप्नुहोस्
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('recommended-pests.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="from_workflow" value="1">
                                            <input type="hidden" name="panjikaran_id" value="{{ $panjikaran->id }}">

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" id="pest_id" name="pest_id" required>
                                                            <option value="">कीरा छान्नुहोस्</option>
                                                            @foreach ($pests as $pest)
                                                                <option value="{{ $pest->id }}" {{ old('pest_id') == $pest->id ? 'selected' : '' }}>
                                                                    {{ $pest->pest }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label for="pest_id">कीरा <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-warning w-100" style="height: 58px;">
                                                            <i class="fa fa-plus"></i> थप्नुहोस्
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Recommended Pests List -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-list"></i> सिफारिस गरिएको कीरा सूची
                                            <span class="badge bg-info ms-2">{{ $recommendedPests->count() }} रेकर्ड</span>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead class="table-warning">
                                                    <tr>
                                                        <th style="width: 10%;">S.N.</th>
                                                        <th style="width: 50%;">कीराको नाम</th>
                                                        <th style="width: 25%;">मिति</th>
                                                        <th style="width: 15%;">कार्य</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($recommendedPests as $sn => $recommendedPest)
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td>
                                                                <strong>{{ $recommendedPest->pest->pest ?? 'N/A' }}</strong>
                                                            </td>
                                                            <td>{{ $recommendedPest->created_at->format('Y-m-d') }}</td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('recommended-pests.edit', $recommendedPest->id) }}"
                                                                        class="btn btn-success btn-sm" title="सम्पादन गर्नुहोस्">
                                                                        <i class="bx bx-edit"></i>
                                                                    </a>
                                                                    <form action="{{ route('recommended-pests.destroy', $recommendedPest->id) }}"
                                                                          method="POST" style="display: inline;"
                                                                          onsubmit="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <input type="hidden" name="from_workflow" value="1">
                                                                        <button type="submit" class="btn btn-danger btn-sm" title="मेटाउनुहोस्">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center py-4">
                                                                <div class="text-muted">
                                                                    <i class="fas fa-bug fa-2x mb-2"></i>
                                                                    <p>कुनै कीरा सिफारिस डाटा उपलब्ध छैन</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    @if ($currentStep > 1)
                                        <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => $currentStep - 1]) }}"
                                            class="btn btn-outline-secondary btn-lg">
                                            <i class="fa fa-arrow-left"></i> अघिल्लो चरण
                                        </a>
                                    @else
                                        <a href="{{ route('panjikarans.index') }}" class="btn btn-outline-secondary btn-lg">
                                            <i class="fa fa-list"></i> पञ्जीकरण सूची
                                        </a>
                                    @endif
                                </div>
                                <div>
                                    @if ($currentStep < 3)
                                        <a href="{{ route('panjikaran.workflow', ['panjikaran' => $panjikaran->id, 'step' => $currentStep + 1]) }}"
                                            class="btn btn-primary btn-lg">
                                            अर्को चरण <i class="fa fa-arrow-right"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('panjikarans.show', $panjikaran->id) }}"
                                            class="btn btn-success btn-lg">
                                            <i class="fa fa-check-circle"></i> पूरा भयो
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Workflow Summary Card -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-chart-pie"></i> कार्यप्रवाह सारांश
                                    </h6>
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <div class="p-2">
                                                <h4 class="text-primary">{{ $bargikarans->count() }}</h4>
                                                <small class="text-muted">वर्गीकरण रेकर्ड</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-2">
                                                <h4 class="text-success">{{ $recommendedCrops->count() }}</h4>
                                                <small class="text-muted">सिफारिस बाली</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-2">
                                                <h4 class="text-warning">{{ $recommendedPests->count() }}</h4>
                                                <small class="text-muted">सिफारिस कीरा</small>
                                            </div>
                                        </div>
                                    </div>
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
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
        }

        .progress-bar {
            transition: width 0.6s ease;
        }

        .progress-nav-steps {
            display: flex;
            justify-content: space-between;
            margin-top: -3px;
        }

        .step.active .step-number {
            background-color: #007bff;
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.25);
        }

        .step-title {
            font-size: 13px;
            font-weight: 600;
            color: #6c757d;
            text-align: center;
            margin-bottom: 4px;
        }

        .step.active .step-title {
            color: #007bff;
        }

        .step small {
            font-size: 11px;
            display: block;
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: box-shadow 0.15s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.075);
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .alert {
            border: none;
            border-radius: 8px;
        }

        .badge {
            font-size: 0.7em;
        }

        @media (max-width: 768px) {
            .progress-nav-steps {
                flex-direction: column;
                gap: 20px;
            }

            .step {
                flex-direction: row;
                justify-content: center;
                gap: 10px;
            }

            .step-number {
                margin-bottom: 0;
            }
        }

        .form-floating > label {
            font-weight: 500;
        }

        .table thead th {
            border-top: none;
            font-weight: 600;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card-header h6 {
            font-weight: 600;
        }

        .workflow-summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
    </style>
@endsection
