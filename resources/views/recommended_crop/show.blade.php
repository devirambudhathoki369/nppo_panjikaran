@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">सिफारिस गरिएको बाली विवरण</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikarans.index') }}">पञ्जीकरणको सूची</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('recommended-crops.index', ['panjikaran_id' => $recommendedCrop->panjikaran_id]) }}">सिफारिस
                                गरिएको बालीको सूची</a></li>
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
                    <div class="row mb-3">
                        <div class="col-12">
                            <a href="{{ route('recommended-crops.index', ['panjikaran_id' => $recommendedCrop->panjikaran_id]) }}"
                                class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> फर्कनुहोस्
                            </a>
                            <a href="{{ route('recommended-crops.edit', $recommendedCrop->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit"></i> सम्पादन गर्नुहोस्
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">आवेदनकर्ता:</th>
                                    <td>{{ $recommendedCrop->checklist->ImporterName ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>इजाजतपत्र नं.:</th>
                                    <td>{{ $recommendedCrop->checklist->LicenseNo ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>कीटनाशकको सामान्य नाम:</th>
                                    <td>{{ $recommendedCrop->panjikaran->CommonNameOfPesticide ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>रासायनिक नाम:</th>
                                    <td>{{ $recommendedCrop->panjikaran->ChemicalName ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">बालीको नाम:</th>
                                    <td>{{ $recommendedCrop->crop->crop_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>सिर्जना मिति:</th>
                                    <td>{{ $recommendedCrop->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>अपडेट मिति:</th>
                                    <td>{{ $recommendedCrop->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
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
