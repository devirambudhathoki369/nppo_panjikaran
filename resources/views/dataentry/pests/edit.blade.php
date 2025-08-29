@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">कीरा सम्पादन गर्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('pests.index') }}">कीराको विवरण</a></li>
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
                                    <form action="{{ route('pests.update', $pest->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row justify-content-center">
                                            <div class="col-md-8 mb-3">
                                                <div class="form-floating">
                                                    <input id="pest" type="text"
                                                        class="form-control @error('pest') is-invalid @enderror"
                                                        name="pest" value="{{ old('pest', $pest->pest) }}" required
                                                        autocomplete="off" placeholder="कीराको नाम">
                                                    <label class="form-label" for="pest">कीराको नाम</label>

                                                    @error('pest')
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
                                                <a href="{{ route('pests.index') }}" class="btn btn-secondary">
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
