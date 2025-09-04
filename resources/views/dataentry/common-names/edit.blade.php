@extends('layouts.base')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">कमन नाम सम्पादन गर्नुहोस्</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('common-names.index') }}">कमन नाम</a></li>
                    <li class="breadcrumb-item active">सम्पादन गर्नुहोस्</li>
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
                <form action="{{ route('common-names.update', $commonName->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input id="common_name" type="text"
                                    class="form-control @error('common_name') is-invalid @enderror"
                                    name="common_name" value="{{ $commonName->common_name }}" required
                                    autocomplete="off" placeholder="सामान्य नाम">
                                <label class="form-label" for="common_name">सामान्य नाम</label>

                                @error('common_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input id="rasayanik_name" type="text"
                                    class="form-control @error('rasayanik_name') is-invalid @enderror"
                                    name="rasayanik_name" value="{{ $commonName->rasayanik_name }}"
                                    autocomplete="off" placeholder="रासायनिक नाम">
                                <label class="form-label" for="rasayanik_name">रासायनिक नाम</label>

                                @error('rasayanik_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input id="iupac_name" type="text"
                                    class="form-control @error('iupac_name') is-invalid @enderror"
                                    name="iupac_name" value="{{ $commonName->iupac_name }}"
                                    autocomplete="off" placeholder="IUPAC नाम">
                                <label class="form-label" for="iupac_name">IUPAC नाम</label>

                                @error('iupac_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input id="cas_no" type="text"
                                    class="form-control @error('cas_no') is-invalid @enderror"
                                    name="cas_no" value="{{ $commonName->cas_no }}"
                                    autocomplete="off" placeholder="CAS नम्बर">
                                <label class="form-label" for="cas_no">CAS नम्बर</label>

                                @error('cas_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input id="molecular_formula" type="text"
                                    class="form-control @error('molecular_formula') is-invalid @enderror"
                                    name="molecular_formula" value="{{ $commonName->molecular_formula }}"
                                    autocomplete="off" placeholder="आणविक सूत्र">
                                <label class="form-label" for="molecular_formula">आणविक सूत्र</label>

                                @error('molecular_formula')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <select id="source_id" name="source_id"
                                    class="form-control @error('source_id') is-invalid @enderror">
                                    <option value="">स्रोत छान्नुहोस्</option>
                                    @foreach($sources as $source)
                                    <option value="{{ $source->id }}" {{ $commonName->source_id == $source->id ? 'selected' : '' }}>
                                        {{ $source->sourcename }}
                                    </option>
                                    @endforeach
                                </select>
                                <label class="form-label" for="source_id">स्रोत</label>

                                @error('source_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                अद्यावधिक गर्नुहोस्</button>
                            <a href="{{ route('common-names.index') }}" class="btn btn-secondary ms-2">
                                रद्द गर्नुहोस्</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->
@endsection
