@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">सिफारिस गरिएको बाली सम्पादन गर्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikarans.index') }}">पञ्जीकरणको सूची</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('recommended-crops.index', ['panjikaran_id' => $recommendedCrop->panjikaran_id]) }}">सिफारिस
                                गरिएको बालीको सूची</a></li>
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

                    <form action="{{ route('recommended-crops.update', $recommendedCrop->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="from_workflow" value="2">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="crop_id" class="form-label">बाली <span class="text-danger">*</span></label>
                                    <select class="form-select @error('crop_id') is-invalid @enderror" id="crop_id"
                                        name="crop_id" required>
                                        <option value="">बाली छान्नुहोस्</option>
                                        @foreach ($crops as $crop)
                                            <option value="{{ $crop->id }}"
                                                {{ old('crop_id', $recommendedCrop->crop_id) == $crop->id ? 'selected' : '' }}>
                                                {{ $crop->crop_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('crop_id')
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
                                <a href="{{ route('recommended-crops.index', ['panjikaran_id' => $recommendedCrop->panjikaran_id]) }}"
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
