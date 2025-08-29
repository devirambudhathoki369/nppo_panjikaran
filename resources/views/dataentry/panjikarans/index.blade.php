@extends('layouts.base')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">पंजीकरणको विवरण</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dataentry.checklists.index') }}">चेकलिस्ट</a></li>
                    <li class="breadcrumb-item active">पंजीकरणको विवरण</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- Checklist Info Card -->
<div class="row mb-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">चेकलिस्ट जानकारी</h5>
                <div class="row">
                    <div class="col-md-3">
                        <strong>आयातकर्ताको नाम:</strong> {{ $checklist->ImporterName }}
                    </div>
                    <div class="col-md-3">
                        <strong>इजाजतपत्र नं:</strong> {{ $checklist->LicenseNo }}
                    </div>
                    <div class="col-md-3">
                        <strong>व्यापारिक नाम:</strong> {{ $checklist->TradeNameOfPesticide }}
                    </div>
                    <div class="col-md-3">
                        <strong>स्थिति:</strong> {!! $checklist->getStatusWithIcon() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-12 text-end">
                        <a href="{{ route('panjikarans.create', $checklist->id) }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> नयाँ पंजीकरण थप्नुहोस्
                        </a>
                    </div>
                </div>

                <table class="table align-middle datatable dt-responsive table-check nowrap"
                    style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                    <thead>
                        <tr class="bg-transparent">
                            <th width="5%">S.N.</th>
                            <th width="20%">कीटनाशकको सामान्य नाम</th>
                            <th width="20%">रासायनिक नाम</th>
                            <th width="10%">IUPAC नं</th>
                            <th width="10%">CAS नं</th>
                            <th width="15%">स्रोत</th>
                            <th width="15%">श्रेणी</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($panjikarans as $sn => $panjikaran)
                        <tr>
                            <td>{{ ++$sn }}</td>
                            <td>{{ $panjikaran->CommonNameOfPesticide ?? 'N/A' }}</td>
                            <td>{{ $panjikaran->ChemicalName ?? 'N/A' }}</td>
                            <td>{{ $panjikaran->IuapcNo ?? 'N/A' }}</td>
                            <td>{{ $panjikaran->Cas_No ?? 'N/A' }}</td>
                            <td>{{ $panjikaran->source->sourcename ?? 'N/A' }}</td>
                            <td>{{ $panjikaran->category->prakar ?? 'N/A' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-cogs"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('panjikarans.edit', [$checklist->id, $panjikaran->id]) }}">
                                                <i class="bx bx-edit"></i> सम्पादन गर्नुहोस्
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('panjikarans.destroy', [$checklist->id, $panjikaran->id]) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')">
                                                    <i class="fa fa-trash"></i> मेट्नुहोस्
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">कुनै पंजीकरण फेला परेन</td>
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