@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">सिफारिस गरिएको बालीको सूची</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikarans.index') }}">पञ्जीकरणको सूची</a></li>
                        <li class="breadcrumb-item active">सिफारिस गरिएको बालीको सूची</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if ($panjikaran)
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">पञ्जीकरण विवरण</h5>
                        <p><strong>आवेदनकर्ता:</strong> {{ $panjikaran->checklist->ImporterName ?? 'N/A' }}</p>
                        <p><strong>कीटनाशकको सामान्य नाम:</strong> {{ $panjikaran->CommonNameOfPesticide }}</p>
                        <p><strong>रासायनिक नाम:</strong> {{ $panjikaran->ChemicalName }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Add New RecommendedCrop Form -->
    @if ($panjikaranId)
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">नयाँ बाली सिफारिस थप्नुहोस्</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('recommended-crops.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="panjikaran_id" value="{{ $panjikaranId }}">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="crop_id" class="form-label">बाली <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="crop_id" name="crop_id" required>
                                            <option value="">बाली छान्नुहोस्</option>
                                            @foreach ($crops as $crop)
                                                <option value="{{ $crop->id }}"
                                                    {{ old('crop_id') == $crop->id ? 'selected' : '' }}>
                                                    {{ $crop->crop_name }}
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
            </div>
        </div>
    @endif

    <!-- Data Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if (!$panjikaranId)
                        <div class="row mb-3">
                            <div class="col-12 text-end">
                                <a href="{{ route('panjikarans.index') }}" class="btn btn-primary">
                                    <i class="fa fa-arrow-left"></i> पञ्जीकरणको सूचीमा फर्कनुहोस्
                                </a>
                            </div>
                        </div>
                    @endif

                    <table class="table align-middle datatable dt-responsive table-check nowrap"
                        style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="5%">S.N.</th>
                                <th width="15%">आवेदनकर्ता</th>
                                <th width="20%">कीटनाशकको सामान्य नाम</th>
                                <th width="20%">बालीको नाम</th>
                                <th width="15%">मिति</th>
                                <th width="25%">कार्य</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recommendedCrops as $sn => $recommendedCrop)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $recommendedCrop->checklist->ImporterName ?? 'N/A' }}</td>
                                    <td>{{ $recommendedCrop->panjikaran->CommonNameOfPesticide ?? 'N/A' }}</td>
                                    <td>{{ $recommendedCrop->crop->crop_name ?? 'N/A' }}</td>
                                    <td>{{ $recommendedCrop->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('recommended-crops.show', $recommendedCrop->id) }}"
                                            class="btn btn-info btn-xs" title="हेर्नुहोस्">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('recommended-crops.edit', $recommendedCrop->id) }}"
                                            class="btn btn-success btn-xs" title="सम्पादन गर्नुहोस्">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('recommended-crops.destroy', $recommendedCrop->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger"
                                                onclick="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')"
                                                title="मेट्नुहोस्">
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
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
