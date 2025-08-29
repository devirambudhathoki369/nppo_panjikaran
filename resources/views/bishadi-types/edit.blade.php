@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">बिषादिको प्रकार सम्पादन</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('bishadi-types.index') }}">बिषादिको प्रकार</a></li>
                        <li class="breadcrumb-item active">सम्पादन</li>
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
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('bishadi-types.update', $bishadiType->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input id="prakar" type="text"
                                                        class="form-control @error('prakar') is-invalid @enderror"
                                                        name="prakar" value="{{ old('prakar', $bishadiType->prakar) }}"
                                                        required autocomplete="off" placeholder="बिषादिको प्रकार">
                                                    <label class="form-label" for="prakar">बिषादिको प्रकार</label>

                                                    @error('prakar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <div class="form-floating">
                                                    <input id="type_code" type="text"
                                                        class="form-control @error('type_code') is-invalid @enderror"
                                                        name="type_code"
                                                        value="{{ old('type_code', $bishadiType->type_code) }}" required
                                                        autocomplete="off" placeholder="टाइप कोड">
                                                    <label class="form-label" for="type_code">टाइप कोड</label>

                                                    @error('type_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3 text-center">
                                                <button type="submit" class="btn btn-primary me-2">
                                                    <i class="fa fa-save"></i> अपडेट गर्नुहोस्
                                                </button>
                                                <a href="{{ route('bishadi-types.index') }}" class="btn btn-secondary">
                                                    <i class="fa fa-arrow-left"></i> फिर्ता
                                                </a>
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
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
