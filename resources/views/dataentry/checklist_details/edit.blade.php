@extends('layouts.base')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">चेकलिष्ट डिटेल सम्पादन गर्नुहोस्</h4>

                <form action="{{ route('dataentry.checklists.details.update', [$checklist->id, $detail->id]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ChecklistItemID" class="form-label">चेकलिष्ट बुँदा</label>
                            <select class="form-control select2 @error('ChecklistItemID') is-invalid @enderror"
                                id="ChecklistItemID" name="ChecklistItemID" required>
                                <option value="">-- छान्नुहोस् --</option>
                                @foreach ($items as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('ChecklistItemID', $detail->ChecklistItemID) == $item->id ? 'selected' : '' }}>
                                    {{ $item->CheckListItem }} ({{ $item->type_text }})
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
                                @for($i = 0; $i <= 1; $i++)
                                    <option value="{{ $i }}" {{ old('DocumentStatus', $detail->DocumentStatus) == $i ? 'selected' : '' }}>{{ DocumentStatus($i) }}</option>
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
                                @for($i = 0; $i <= 3; $i++)
                                    <option value="{{ $i }}" {{ old('SourceOfDocument') == $i ? 'selected' : '' }}>{{ SourceOfDocument($i) }}</option>
                                    @endfor
                            </select>
                            @error('SourceOfDocument')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="Remarks" class="form-label">कैफियत</label>
                            <textarea class="form-control @error('Remarks') is-invalid @enderror" id="Remarks" name="Remarks" rows="1">{{ old('Remarks', $detail->Remarks) }}</textarea>
                            @error('Remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> अपडेट गर्नुहोस्
                            </button>
                            <a href="{{ route('dataentry.checklists.details.index', $checklist->id) }}"
                                class="btn btn-secondary">
                                <i class="fa fa-times"></i> रद्द गर्नुहोस्
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection