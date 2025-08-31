@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">पञ्जीकरणको सूची</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">पञ्जीकरणको सूची</li>
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
                            <a href="{{ route('panjikarans.create', ['checklist_id' => request('checklist_id')]) }}"
                                class="btn btn-primary">
                                <i class="fa fa-plus"></i> नयाँ पञ्जीकरण थप्नुहोस्
                            </a>

                        </div>
                    </div>

                    <table class="table align-middle datatable dt-responsive table-check nowrap"
                            style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="3%">S.N.</th>
                                <th width="10%">आवेदनकर्ता</th>
                                <th width="8%">इजाजतपत्र नं.</th>
                                <th width="12%">रासायनिक नाम</th>
                                <th width="8%">स्रोत</th>
                                <th width="8%">उद्देश्य</th>
                                <th width="39%">कार्य</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($panjikarans as $sn => $panjikaran)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $panjikaran->checklist->ImporterName ?? 'N/A' }}</td>
                                    <td>{{ $panjikaran->checklist->LicenseNo ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('panjikaran.workflow', $panjikaran->id) }}"
                                            class="text-primary text-decoration-none fw-bold">
                                            {{ $panjikaran->ChemicalName }}
                                        </a>
                                    </td>
                                    <td>{{ $panjikaran->source->sourcename ?? 'N/A' }}</td>
                                    <td>{{ $panjikaran->objective->objective ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('panjikarans.show', $panjikaran->id) }}"
                                            class="btn btn-info btn-xs" title="हेर्नुहोस्">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('panjikaran.print', $panjikaran->id) }}" target="_blank"
                                            class="btn btn-dark btn-xs" title="प्रिन्ट गर्नुहोस्">
                                            <i class="fa fa-print"></i>
                                        </a>
                                        <a href="{{ route('panjikarans.edit', $panjikaran->id) }}"
                                            class="btn btn-success btn-xs" title="सम्पादन गर्नुहोस्">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        {{-- <a href="{{ route('bargikarans.index', ['panjikaran_id' => $panjikaran->id]) }}"
                                            class="btn btn-warning btn-xs" title="वर्गीकरण">
                                            <i class="fa fa-list"></i>
                                        </a>
                                        <a href="{{ route('recommended-crops.index', ['panjikaran_id' => $panjikaran->id]) }}"
                                            class="btn btn-info btn-xs" title="सिफारिस गरिएको बाली">
                                            <i class="fa fa-leaf"></i>
                                        </a>
                                        <a href="{{ route('recommended-pests.index', ['panjikaran_id' => $panjikaran->id]) }}"
                                            class="btn btn-secondary btn-xs" title="सिफारिस गरिएको कीरा">
                                            <i class="fa fa-bug"></i>
                                        </a> --}}
                                        <form action="{{ route('panjikarans.destroy', $panjikaran->id) }}" method="POST"
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
                                    <td colspan="7" class="text-center">कुनै डाटा उपलब्ध छैन</td>
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
