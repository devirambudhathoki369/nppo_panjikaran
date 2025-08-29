@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">युनिट सम्पादन गर्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('units.index') }}">युनिट</a></li>
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
                    <form action="{{ route('units.update', $unit->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="unit_name" type="text"
                                        class="form-control @error('unit_name') is-invalid @enderror" name="unit_name"
                                        value="{{ $unit->unit_name }}" required autocomplete="off" placeholder="युनिट">
                                    <label class="form-label" for="unit_name">युनिट</label>

                                    @error('unit_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <select class="form-control @error('unit_type') is-invalid @enderror" name="unit_type"
                                        id="unit_type" required>
                                        <option value="formulation"
                                            {{ old('unit_type', $unit->unit_type) == 'formulation' ? 'selected' : '' }}>
                                            Formulation
                                        </option>
                                        <option value="container"
                                            {{ old('unit_type', $unit->unit_type) == 'container' ? 'selected' : '' }}>
                                            Container
                                        </option>
                                    </select>
                                    <label for="unit_type">युनिट प्रकार</label>

                                    @error('unit_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-2 mb-3">
                                <label for="">&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i>
                                    अद्यावधिक गर्नुहोस् </button>
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
