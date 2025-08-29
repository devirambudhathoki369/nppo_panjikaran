@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">पेश गर्ने व्यक्ति, संस्था वा निकायको विवरण सम्पादन गर्नुहोस्</h4>

                    <form action="{{ route('dataentry.checklists.update', $checklist->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ImporterName" class="form-label">पेश गर्ने व्यक्ति, संस्था वा निकायको नाम</label>
                                <input type="text" class="form-control @error('ImporterName') is-invalid @enderror"
                                    id="ImporterName" name="ImporterName"
                                    value="{{ old('ImporterName', $checklist->ImporterName) }}" required>
                                @error('ImporterName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="LicenseNo" class="form-label">इजाजतपत्र नं.</label>
                                <input type="text" class="form-control @error('LicenseNo') is-invalid @enderror"
                                    id="LicenseNo" name="LicenseNo" value="{{ old('LicenseNo', $checklist->LicenseNo) }}"
                                    required>
                                @error('LicenseNo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="ApplicationType" class="form-label">आवेदनको प्रकार</label>
                                <select class="form-control @error('ApplicationType') is-invalid @enderror"
                                    id="ApplicationType" name="ApplicationType" required>
                                    <option value="">छान्नुहोस्</option>
                                    @for ($i = 0; $i <= 1; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('ApplicationType', $checklist->ApplicationType) == $i ? 'selected' : '' }}>
                                            {{ checklistType($i) }}</option>
                                    @endfor
                                </select>
                                @error('ApplicationType')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="formulation_id" class="form-label">फर्मुलेशन</label>
                                <select class="form-control @error('formulation_id') is-invalid @enderror"
                                    id="formulation_id" name="formulation_id" required>
                                    <option value="">छान्नुहोस्</option>
                                    @foreach ($formulations as $formulation)
                                        <option value="{{ $formulation->id }}"
                                            {{ old('formulation_id', $checklist->formulation_id) == $formulation->id ? 'selected' : '' }}>
                                            {{ $formulation->formulation_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('formulation_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="bishadi_type_id" class="form-label">बिषादिको प्रकार</label>
                                <select class="form-control @error('bishadi_type_id') is-invalid @enderror"
                                    id="bishadi_type_id" name="bishadi_type_id" required>
                                    <option value="">छान्नुहोस्</option>
                                    @foreach ($bishadiTypes as $bishadiType)
                                        <option value="{{ $bishadiType->id }}"
                                            {{ old('bishadi_type_id', $checklist->bishadi_type_id) == $bishadiType->id ? 'selected' : '' }}>
                                            {{ $bishadiType->prakar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bishadi_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="TradeNameOfPesticide" class="form-label">जीवनाशक विषादीको ब्यापारिक नाम</label>
                                <input type="text"
                                    class="form-control @error('TradeNameOfPesticide') is-invalid @enderror"
                                    id="TradeNameOfPesticide" name="TradeNameOfPesticide"
                                    value="{{ old('TradeNameOfPesticide', $checklist->TradeNameOfPesticide) }}" required>
                                @error('TradeNameOfPesticide')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> अपडेट गर्नुहोस्
                                </button>
                                <a href="{{ route('dataentry.checklists.index') }}" class="btn btn-secondary">
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
