@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">नवीकरणको सूची</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikarans.index') }}">पञ्जीकरणको सूची</a></li>
                        <li class="breadcrumb-item active">नवीकरणको सूची</li>
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
                        <div class="col-12 text-end">
                            <a href="{{ route('renewals.create', ['panjikaran_id' => request('panjikaran_id')]) }}"
                                class="btn btn-primary">
                                <i class="fa fa-plus"></i> नयाँ नवीकरण थप्नुहोस्
                            </a>
                            @if(request('panjikaran_id'))
                                <a href="{{ route('panjikarans.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> पञ्जीकरणको सूचीमा फर्कनुहोस्
                                </a>
                            @endif
                        </div>
                    </div>

                    <table class="table align-middle datatable dt-responsive table-check nowrap"
                            style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="5%">S.N.</th>
                                <th width="15%">आवेदनकर्ता</th>
                                <th width="12%">रासायनिक नाम</th>
                                <th width="10%">नवीकरण मिति</th>
                                <th width="10%">म्याद सकिने मिति</th>
                                <th width="10%">कर भौचर नं.</th>
                                <th width="10%">रूजु गर्ने</th>
                                <th width="8%">स्थिति</th>
                                <th width="20%">कार्य</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($renewals as $sn => $renewal)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $renewal->checklist->ImporterName ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('panjikaran.workflow', $renewal->panjikaran_id) }}"
                                            class="text-primary text-decoration-none fw-bold">
                                            {{ $renewal->panjikaran->ChemicalName ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td>{{ $renewal->renew_date->format('Y-m-d') }}</td>
                                    <td>{{ $renewal->renew_expiry_date->format('Y-m-d') }}</td>
                                    <td>{{ $renewal->tax_bhauchar_no ?? 'N/A' }}</td>
                                    <td>{{ $renewal->ruju_garne ?? 'N/A' }}</td>
                                    <td>{!! $renewal->getStatusWithIconAttribute() !!}</td>
                                    <td>
                                        <a href="{{ route('renewals.show', $renewal->id) }}"
                                            class="btn btn-info btn-xs" title="हेर्नुहोस्">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('renewals.edit', $renewal->id) }}"
                                            class="btn btn-success btn-xs" title="सम्पादन गर्नुहोस्">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        @if($renewal->signature_upload)
                                            <a href="{{ asset('storage/' . $renewal->signature_upload) }}"
                                                target="_blank" class="btn btn-warning btn-xs" title="हस्ताक्षर हेर्नुहोस्">
                                                <i class="fa fa-file-image"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('renewals.destroy', $renewal->id) }}" method="POST"
                                            style="display: inline-block;">
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
                                    <td colspan="9" class="text-center">कुनै नवीकरण डाटा उपलब्ध छैन</td>
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
