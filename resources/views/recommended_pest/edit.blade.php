@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">सिफारिस गरिएको कीरा सम्पादन गर्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikarans.index') }}">पञ्जीकरणको सूची</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('recommended-pests.index', ['panjikaran_id' => $recommendedPest->panjikaran_id]) }}">सिफारिस
                                गरिएको कीराको सूची</a></li>
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

                    <form action="{{ route('recommended-pests.update', $recommendedPest->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="from_workflow" value="3">


                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="pest_id" class="form-label">कीरा <span class="text-danger">*</span></label>
                                    <select class="form-select @error('pest_id') is-invalid @enderror" id="pest_id"
                                        name="pest_id" required>
                                        <option value="">कीरा छान्नुहोस्</option>
                                        @foreach ($pests as $pest)
                                            <option value="{{ $pest->id }}"
                                                {{ old('pest_id', $recommendedPest->pest_id) == $pest->id ? 'selected' : '' }}>
                                                {{ $pest->pest }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pest_id')
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
                                <a href="{{ route('recommended-pests.index', ['panjikaran_id' => $recommendedPest->panjikaran_id]) }}"
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
