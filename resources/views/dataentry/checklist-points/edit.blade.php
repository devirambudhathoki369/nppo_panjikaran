@extends('layouts.base')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">चेकलिष्टका बुँदा सम्पादन गर्नुहोस्</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('checklist-points.index') }}">चेकलिष्टका बुँदा</a></li>
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
                <form action="{{ route('checklist-points.update', $checklistItem->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input id="CheckListItem" type="text"
                                    class="form-control @error('CheckListItem') is-invalid @enderror"
                                    name="CheckListItem" value="{{ $checklistItem->CheckListItem }}" required
                                    autocomplete="off" placeholder="चेकलिष्ट बुँदा">
                                <label class="form-label" for="CheckListItem">चेकलिष्ट बुँदा</label>

                                @error('CheckListItem')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-floating">
                                <select class="form-control @error('Type') is-invalid @enderror" name="Type"
                                    id="Type" required>
                                    @for($i = 0; $i <= 2; $i++)
                                        <option value="{{ $i }}" {{ old('Type', $checklistItem->Type) == $i ? 'selected' : '' }}>{{ checklistType($i) }}</option>
                                        @endfor

                                </select>
                                <label for="Type">प्रकार</label>

                                @error('Type')
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