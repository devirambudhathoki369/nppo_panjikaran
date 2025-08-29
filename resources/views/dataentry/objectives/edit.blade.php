@extends('layouts.base')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">उद्देश्य सम्पादन गर्नुहोस्</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('objectives.index') }}">उद्देश्यको विवरण</a></li>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('objectives.update', $objective->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row justify-content-center">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input id="objective" type="text"
                                                    class="form-control @error('objective') is-invalid @enderror"
                                                    name="objective" value="{{ old('objective', $objective->objective) }}" required
                                                    autocomplete="off" placeholder="उद्देश्य">
                                                <label class="form-label" for="objective">उद्देश्य</label>

                                                @error('objective')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="">&nbsp;</label>
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fa fa-save"></i>
                                                    अपडेट गर्नुहोस् </button>
                                                <a href="{{ route('objectives.index') }}" class="btn btn-secondary">
                                                    <i class="fa fa-arrow-left"></i> फिर्ता
                                                </a>
                                            </div>
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
