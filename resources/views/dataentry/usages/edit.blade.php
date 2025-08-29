@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">उपयोग सम्पादन गर्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('usages.index') }}">उपयोगको विवरण</a></li>
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
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('usages.update', $usage->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row justify-content-center">
                                            <div class="col-md-8 mb-3">
                                                <div class="form-floating">
                                                    <input id="usage_name" type="text"
                                                        class="form-control @error('usage_name') is-invalid @enderror"
                                                        name="usage_name"
                                                        value="{{ old('usage_name', $usage->usage_name) }}" required
                                                        autocomplete="off" placeholder="उपयोगको नाम">
                                                    <label class="form-label" for="usage_name">उपयोगको नाम</label>

                                                    @error('usage_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-primary me-2">
                                                    <i class="fa fa-save"></i> अपडेट गर्नुहोस्
                                                </button>
                                                <a href="{{ route('usages.index') }}" class="btn btn-secondary">
                                                    <i class="fa fa-arrow-left"></i> फिर्ता जानुहोस्
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
