@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">चेकलिस्टको सूची</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">चेकलिस्टको सूची</li>
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
                    <table class="table align-middle datatable dt-responsive table-check nowrap"
                        style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="5%">क्र.सं.</th>
                                <th width="20%">पेश गर्ने व्यक्ति, संस्था वा निकायको नाम</th>
                                <th width="10%">इजाजतपत्र नं.</th>
                                <th width="10%">आवेदनको प्रकार</th>
                                <th width="15%">स्थिति</th>
                                {{-- <th width="15%">जीवनाशक विषादीको ब्यापारिक नाम</th> --}}
                                <th width="15%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($checklists as $sn => $checklist)
                                @php
                                    $isSentToVerify = \App\Models\Notification::where('checklist_id', $checklist->id)
                                        ->where('action_type', 'send_to_verify')
                                        ->exists();
                                @endphp
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $checklist->ImporterName ?? 'N/A' }}</td>
                                    <td>{{ $checklist->LicenseNo ?? 'N/A' }}</td>
                                    <td>{{ $checklist->ApplicationType == 1 ? 'नयाँ आवेदन' : 'नविकरण' }}</td>
                                    <td>
                                        @if ($checklist->Status == 0)
                                            @if ($isSentToVerify)
                                                <span class="badge bg-warning">सिफारीसको प्रतीक्षामा</span>
                                            @else
                                                <span class="badge bg-secondary">प्रारम्भिक दर्ता</span>
                                            @endif
                                        @elseif($checklist->Status == 1)
                                            <span class="badge bg-primary">सिफारीस भएको</span>
                                        @elseif($checklist->Status == 2)
                                            <span class="badge bg-success">स्वीकृत भएको</span>
                                        @endif
                                    </td>
                                    {{-- <td>{{ $checklist->TradeNameOfPesticide ?? 'N/A' }}</td> --}}
                                    <td>
                                        <a href="{{ route('panjikarans.index', ['checklist_id' => $checklist->id]) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> पञ्जीकरण थप्नुहोस्
                                        </a>
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
