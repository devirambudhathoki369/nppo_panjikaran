@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">बिषादिको प्रकार</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">बिषादिको प्रकार</li>
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
                                    <form action="{{ route('bishadi-types.store') }}" method="POST">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <input id="prakar" type="text"
                                                        class="form-control @error('prakar') is-invalid @enderror"
                                                        name="prakar" value="{{ old('prakar') }}" required
                                                        autocomplete="off" placeholder="बिषादिको प्रकार">
                                                    <label class="form-label" for="prakar">बिषादिको प्रकार</label>

                                                    @error('prakar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <input id="type_code" type="text"
                                                        class="form-control @error('type_code') is-invalid @enderror"
                                                        name="type_code" value="{{ old('type_code') }}" required
                                                        autocomplete="off" placeholder="टाइप कोड">
                                                    <label class="form-label" for="type_code">टाइप कोड</label>

                                                    @error('type_code')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary btn-block"><i
                                                        class="fa fa-save"></i>
                                                    सेभ गर्नुहोस् </button>
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
                    <table class="table align-middle datatable dt-responsive table-check nowrap"
                        style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="5%">S.N.</th>
                                <th width="40%">बिषादिको प्रकार</th>
                                <th width="35%">टाइप कोड</th>
                                <th width="10%"></th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bishadiTypes as $sn => $bishadiType)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $bishadiType->prakar }}</td>
                                    <td>{{ $bishadiType->type_code }}</td>
                                    <td>
                                        <a href="{{ route('bishadi-types.edit', $bishadiType->id) }}"
                                            class="btn btn-success"><i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <form action="{{ route('bishadi-types.destroy', $bishadiType->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger"
                                                onclick="return confirm('तपाईं यो डाटा मेटाउन निश्चित हुनुहुन्छ?')"
                                                title="मेट्नुहोस्">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
