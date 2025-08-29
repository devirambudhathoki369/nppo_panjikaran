@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $checklist->ImporterName ?? 'चेकलिष्ट' }} विवरण</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">सूची</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <a href="{{ route('dataentry.checklists.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> फिर्ता जानुहोस्
                            </a>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table">
                                <tr>
                                    <th width="30%">पेश गर्ने व्यक्ति, संस्था वा निकायको नाम</th>
                                    <th width="15%">इजाजतपत्र नं.</th>
                                    <th width="15%">आवेदनको प्रकार</th>
                                    <th width="15%">स्थिति</th>
                                    <th width="15%">सम्बन्धित प्रयोगकर्ता</th>
                                </tr>
                                <tr>
                                    <td>{{ $checklist->ImporterName }}</td>
                                    <td>{{ $checklist->LicenseNo }}</td>
                                    <td>{{ checklistType($checklist->ApplicationType) }}</td>
                                    <td>{!! checklistStatus($checklist->Status) !!}</td>
                                    <td>{{ $checklist->currentStatusUser() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if ($checklist->Status == 0 || auth()->user()->usertype == 'admin')
                        <!-- Add New Item Form -->
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">
                                    <i class="fa fa-plus text-primary"></i> {{ $checklist->ImporterName ?? 'चेकलिष्ट' }} मा
                                    नयाँ
                                    बुँदा थप्नुहोस्
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dataentry.checklists.details.store', $checklist->id) }}"
                                    method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="ChecklistItemID" class="form-label">चेकलिष्ट बुँदा</label>
                                            <select class="form-control @error('ChecklistItemID') is-invalid @enderror"
                                                id="ChecklistItemID" name="ChecklistItemID" required>
                                                <option value="">-- छान्नुहोस् --</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('ChecklistItemID') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->CheckListItem }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('ChecklistItemID')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="DocumentStatus" class="form-label">कागजातको स्थिति</label>
                                            <select class="form-control @error('DocumentStatus') is-invalid @enderror"
                                                id="DocumentStatus" name="DocumentStatus" required>
                                                @for ($i = 0; $i <= 1; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ old('DocumentStatus') == $i ? 'selected' : '' }}>
                                                        {{ DocumentStatus($i) }}</option>
                                                @endfor
                                            </select>
                                            @error('DocumentStatus')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="SourceOfDocument" class="form-label">कागजातको श्रोत</label>
                                            <select class="form-control @error('SourceOfDocument') is-invalid @enderror"
                                                id="SourceOfDocument" name="SourceOfDocument" required>
                                                @for ($i = 0; $i <= 3; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ old('SourceOfDocument') == $i ? 'selected' : '' }}>
                                                        {{ SourceOfDocument($i) }}</option>
                                                @endfor
                                            </select>
                                            @error('SourceOfDocument')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="Remarks" class="form-label">कैफियत</label>
                                            <textarea class="form-control @error('Remarks') is-invalid @enderror" id="Remarks" name="Remarks" rows="1">{{ old('Remarks') }}</textarea>
                                            @error('Remarks')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label class="form-label">&nbsp;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-save"></i> सेभ गर्नुहोस्
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Data Table -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fa fa-list"></i> चेकलिष्ट बुँदाहरूको सूची
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table align-middle table-check nowrap" style="width: 100%;">
                                <thead>
                                    <tr class="bg-transparent">
                                        <th width="5%">क्र.सं.</th>
                                        <th width="40%">चेकलिष्ट बुँदा</th>
                                        <th width="12%">कागजातको स्थिति</th>
                                        <th width="12%">कागजातको श्रोत</th>
                                        <th width="20%">कैफियत</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($details as $sn => $detail)
                                        <tr>
                                            <td>{{ ++$sn }}</td>
                                            <td>{{ $detail->checklistItem->CheckListItem }}</td>
                                            <td>{{ DocumentStatus($detail->DocumentStatus) }}</td>
                                            <td>{{ SourceOfDocument($detail->SourceOfDocument) }}</td>
                                            <td>{{ $detail->Remarks }}</td>
                                            <td>
                                                @if ($checklist->Status == 0 || auth()->user()->usertype == 'admin')
                                                    <a href="{{ route('dataentry.checklists.details.edit', [$checklist->id, $detail->id]) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('dataentry.checklists.details.destroy', [$checklist->id, $detail->id]) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- NNSW Receipt Date Section (Moved from Step 5) -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h4 class="card-title">NNSW रिसिप्ट मिति विवरण</h4>

                            @if ($checklist->Status == 0 && (!$checklist->DateOfReceiptInNNSWNep || !$checklist->ContainerReceiptDate))
                                <form action="{{ route('dataentry.checklists.update-receipt-date', [$checklist->id, 'step=5']) }}"
                                    method="POST">
                                    @csrf
                                    <div class="row justify-content-center">

                                        <div class="col-md-4 mb-3">
                                            <label for="DateOfReceiptInNNSWNep" class="form-label">नेपाल राष्ट्रिय एकद्वार प्रणालीमा प्राप्त मिति</label>
                                            <input type="date"
                                                class="form-control @error('DateOfReceiptInNNSWNep') is-invalid @enderror"
                                                id="DateOfReceiptInNNSWNep" name="DateOfReceiptInNNSWNep"
                                                value="{{ old('DateOfReceiptInNNSWNep') }}" required>
                                            @error('DateOfReceiptInNNSWNep')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="ContainerReceiptDate" class="form-label">सूचक पत्र, कन्टेनर र नेपाली भाषामा लेखिएको विवरण प्राप्त मिति</label>
                                            <input type="date"
                                                class="form-control @error('ContainerReceiptDate') is-invalid @enderror"
                                                id="ContainerReceiptDate" name="ContainerReceiptDate"
                                                value="{{ old('ContainerReceiptDate') }}" required>
                                            @error('ContainerReceiptDate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <label for="">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fa fa-save"></i> सेभ गर्नुहोस्
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif

                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th width="30%">नेपाल राष्ट्रिय एकद्वार प्रणालीमा प्राप्त मिति</th>
                                                <th width="30%">सूचक पत्र, कन्टेनर र नेपाली भाषामा लेखिएको विवरण प्राप्त मिति</th>
                                                <th width="5%"></th>
                                            </tr>
                                            <tr>
                                                @if ($checklist->DateOfReceiptInNNSWNep)
                                                    <td>{{ $checklist->DateOfReceiptInNNSWNep }}</td>
                                                    <td>{{ $checklist->ContainerReceiptDate }}</td>
                                                    <td align="center">
                                                        @if ($checklist->Status == 0)
                                                            <form
                                                                action="{{ route('dataentry.checklists.remove-receipt-date', [$checklist, 'step=5']) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-xs btn-danger"
                                                                    onclick="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')"
                                                                    title="मेट्नुहोस्">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                @else
                                                    <td colspan="3"></td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
