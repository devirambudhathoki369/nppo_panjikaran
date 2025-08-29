@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">वर्गीकरण सम्पादन गर्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikarans.index') }}">पञ्जीकरणको सूची</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('bargikarans.index', ['panjikaran_id' => $bargikaran->panjikaran_id]) }}">वर्गीकरणको
                                सूची</a></li>
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bargikarans.update', $bargikaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="from_workflow" value="1">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">कोड <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('code') is-invalid @enderror"
                                        id="code" name="code" value="{{ old('code', $bargikaran->code) }}" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="make" class="form-label">बनावट <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('make') is-invalid @enderror"
                                        id="make" name="make" value="{{ old('make', $bargikaran->make) }}" required>
                                    @error('make')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> अपडेट गर्नुहोस्
                                </button>
                                <a href="{{ route('bargikarans.index', ['panjikaran_id' => $bargikaran->panjikaran_id]) }}"
                                    class="btn btn-secondary">
                                    <i class="fa fa-times"></i> रद्द गर्नुहोस्
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
@endsection
