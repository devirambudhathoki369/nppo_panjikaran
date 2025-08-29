@extends('layouts.base')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">फर्मुलेसन विवरण सम्पादन गर्नुहोस्</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('formulations.index') }}">फर्मुलेसन विवरण</a></li>
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
                <form action="{{ route('formulations.update', $formulation->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input id="formulation_name" type="text"
                                    class="form-control @error('formulation_name') is-invalid @enderror"
                                    name="formulation_name" value="{{ $formulation->formulation_name }}" required
                                    autocomplete="off" placeholder="फर्मुलेसनको विवरण">
                                <label class="form-label" for="formulation_name">फर्मुलेसनको विवरण</label>

                                @error('formulation_name')
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