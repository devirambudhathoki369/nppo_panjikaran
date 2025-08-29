@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">युनिट विवरण</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">युनिट विवरण</li>
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
                                    <form action="{{ route('units.store') }}" method="POST">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating">
                                                    <input id="unit_name" type="text"
                                                        class="form-control @error('unit_name') is-invalid @enderror"
                                                        name="unit_name" value="{{ old('unit_name') }}" required
                                                        autocomplete="off" placeholder="युनिट नाम">
                                                    <label class="form-label" for="unit_name">युनिट नाम</label>

                                                    @error('unit_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <select class="form-control @error('unit_type') is-invalid @enderror"
                                                        name="unit_type" id="unit_type" required>
                                                        <option value="formulation"
                                                            {{ old('unit_type') == 'formulation' ? 'selected' : '' }}>
                                                            Formulation</option>
                                                        <option value="container"
                                                            {{ old('unit_type') == 'container' ? 'selected' : '' }}>
                                                            Container</option>
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
                                <th width="50%">युनिट नाम</th>
                                <th width="25%">युनिट प्रकार</th>

                                <th width="10%"></th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $sn => $unit)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $unit->unit_name }}</td>
                                    <td>{{ ucfirst($unit->unit_type) }}</td>
                                    <td>
                                        <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-success btn-xs"><i
                                                class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <form action="{{ route('units.destroy', $unit->id) }}" method="POST">
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
