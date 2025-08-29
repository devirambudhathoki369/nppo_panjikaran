@extends('layouts.base')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">नयाँ चेकलिष्ट डिटेल थप्नुहोस्</h4>

                <form action="{{ route('dataentry.checklists.details.store', $checklist->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ChecklistItemID" class="form-label">चेकलिष्ट बुँदा</label>
                            <select class="form-control @error('ChecklistItemID') is-invalid @enderror"
                                id="ChecklistItemID" name="ChecklistItemID" required>
                                <option value="">-- छान्नुहोस् --</option>
                                @foreach ($items as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('ChecklistItemID') == $item->id ? 'selected' : '' }}>
                                    {{ $item->CheckListItem }} ({{ $item->type_text }})
                                </option>
                                @endforeach
                            </select>
                            @error('ChecklistItemID')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="DocumentStatus" class="form-label">कागजातको स्थिति</label>
                            <select class="form-control @error('DocumentStatus') is-invalid @enderror"
                                id="DocumentStatus" name="DocumentStatus" required>
                                <option value="0" {{ old('DocumentStatus') == '0' ? 'selected' : '' }}>Yes</option>
                                <option value="1" {{ old('DocumentStatus') == '1' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('DocumentStatus')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="Remarks" class="form-label">कैफियत</label>
                            <textarea class="form-control @error('Remarks') is-invalid @enderror" id="Remarks" name="Remarks" rows="3">{{ old('Remarks') }}</textarea>
                            @error('Remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> सेभ गर्नुहोस्
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