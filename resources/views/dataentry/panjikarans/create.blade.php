@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">नयाँ पंजीकरण थप्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dataentry.checklists.index') }}">चेकलिस्ट</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('panjikarans.index', $checklist->id) }}">पंजीकरणको
                                विवरण</a></li>
                        <li class="breadcrumb-item active">नयाँ थप्नुहोस्</li>
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
                            <strong>उत्पादकको नाम:</strong> {{ $checklist->NameofProducer }}
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
                    <form action="{{ route('panjikarans.store', $checklist->id) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="CommonNameOfPesticide" type="text"
                                        class="form-control @error('CommonNameOfPesticide') is-invalid @enderror"
                                        name="CommonNameOfPesticide"
                                        value="{{ old('CommonNameOfPesticide', $checklist->TradeNameOfPesticide) }}"
                                        autocomplete="off" placeholder="कीटनाशकको सामान्य नाम">
                                    <label class="form-label" for="CommonNameOfPesticide">कीटनाशकको सामान्य नाम</label>
                                    @error('CommonNameOfPesticide')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="ChemicalName" type="text"
                                        class="form-control @error('ChemicalName') is-invalid @enderror" name="ChemicalName"
                                        value="{{ old('ChemicalName') }}" autocomplete="off" placeholder="रासायनिक नाम">
                                    <label class="form-label" for="ChemicalName">रासायनिक नाम</label>
                                    @error('ChemicalName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input id="IuapcNo" type="number"
                                        class="form-control @error('IuapcNo') is-invalid @enderror" name="IuapcNo"
                                        value="{{ old('IuapcNo') }}" autocomplete="off" placeholder="IUPAC नं">
                                    <label class="form-label" for="IuapcNo">IUPAC नं</label>
                                    @error('IuapcNo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input id="Cas_No" type="text"
                                        class="form-control @error('Cas_No') is-invalid @enderror" name="Cas_No"
                                        value="{{ old('Cas_No') }}" autocomplete="off" placeholder="CAS नं">
                                    <label class="form-label" for="Cas_No">CAS नं</label>
                                    @error('Cas_No')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input id="Atomic_Formula" type="text"
                                        class="form-control @error('Atomic_Formula') is-invalid @enderror"
                                        name="Atomic_Formula" value="{{ old('Atomic_Formula') }}" autocomplete="off"
                                        placeholder="आणविक सूत्र">
                                    <label class="form-label" for="Atomic_Formula">आणविक सूत्र</label>
                                    @error('Atomic_Formula')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select id="SourceID" class="form-select @error('SourceID') is-invalid @enderror"
                                        name="SourceID">
                                        <option value="">स्रोत छान्नुहोस्</option>
                                        @foreach ($sources as $source)
                                            <option value="{{ $source->id }}"
                                                {{ old('SourceID') == $source->id ? 'selected' : '' }}>
                                                {{ $source->sourcename }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="SourceID">स्रोत</label>
                                    @error('SourceID')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select id="CategoryID" class="form-select @error('CategoryID') is-invalid @enderror"
                                        name="CategoryID">
                                        <option value="">श्रेणी छान्नुहोस्</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ (old('CategoryID') ?? $checklist->bishadi_type_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->prakar }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="CategoryID">श्रेणी</label>
                                    @error('CategoryID')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa fa-save"></i> सेभ गर्नुहोस्
                                </button>
                                <a href="{{ route('panjikarans.index', $checklist->id) }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> फिर्ता
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
