@extends('layouts.base')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">देशको विवरण</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">देशको विवरण</li>
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
                                <form action="{{ route('countries.store') }}" method="POST">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input id="country_name" type="text"
                                                    class="form-control @error('country_name') is-invalid @enderror"
                                                    name="country_name" value="{{ old('country_name') }}" required
                                                    autocomplete="off" placeholder="देशको नाम">
                                                <label class="form-label" for="country_name">देशको नाम</label>

                                                @error('country_name')
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
                            <th width="50%">देशको नाम</th>
                            <th width="10%"></th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $sn => $country)
                        <tr>
                            <td>{{ ++$sn }}</td>
                            <td>{{ $country->country_name }}</td>
                            <td>
                                <a href="{{ route('countries.edit', $country->id) }}"
                                    class="btn btn-success btn-xs"><i class="bx bx-edit"></i>
                                </a>
                            </td>
                            <td align="center">
                                <form action="{{ route('countries.destroy', $country->id) }}"
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
