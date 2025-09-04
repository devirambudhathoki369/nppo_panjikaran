@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">कमन विवरण</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">कमन विवरण</li>
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
                    <!-- Add Button -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fa fa-plus"></i> नयाँ थप्नुहोस्
                            </button>
                        </div>
                    </div>

                    <table class="table align-middle datatable dt-responsive table-check nowrap"
                        style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th width="3%">S.N.</th>
                                <th width="15%">सामान्य नाम</th>
                                <th width="15%">रासायनिक नाम</th>
                                <th width="15%">IUPAC नाम</th>
                                <th width="12%">CAS नम्बर</th>
                                <th width="12%">आणविक सूत्र</th>
                                <th width="10%">स्रोत</th>
                                <th width="5%"></th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($common_names as $sn => $commonName)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $commonName->common_name }}</td>
                                    <td>{{ $commonName->rasayanik_name }}</td>
                                    <td>{{ $commonName->iupac_name }}</td>
                                    <td>{{ $commonName->cas_no }}</td>
                                    <td>{{ $commonName->molecular_formula }}</td>
                                    <td>{{ $commonName->source ? $commonName->source->sourcename : '-' }}</td>
                                    <td>
                                        <a href="{{ route('common-names.edit', $commonName->id) }}"
                                            class="btn btn-success btn-xs"><i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <form action="{{ route('common-names.destroy', $commonName->id) }}"
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

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">नयाँ कमन नाम थप्नुहोस्</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('common-names.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="common_name" type="text"
                                        class="form-control @error('common_name') is-invalid @enderror"
                                        name="common_name" value="{{ old('common_name') }}" required
                                        autocomplete="off" placeholder="सामान्य नाम">
                                    <label class="form-label" for="common_name">सामान्य नाम</label>

                                    @error('common_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="rasayanik_name" type="text"
                                        class="form-control @error('rasayanik_name') is-invalid @enderror"
                                        name="rasayanik_name" value="{{ old('rasayanik_name') }}"
                                        autocomplete="off" placeholder="रासायनिक नाम">
                                    <label class="form-label" for="rasayanik_name">रासायनिक नाम</label>

                                    @error('rasayanik_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="iupac_name" type="text"
                                        class="form-control @error('iupac_name') is-invalid @enderror"
                                        name="iupac_name" value="{{ old('iupac_name') }}"
                                        autocomplete="off" placeholder="IUPAC नाम">
                                    <label class="form-label" for="iupac_name">IUPAC नाम</label>

                                    @error('iupac_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="cas_no" type="text"
                                        class="form-control @error('cas_no') is-invalid @enderror"
                                        name="cas_no" value="{{ old('cas_no') }}"
                                        autocomplete="off" placeholder="CAS नम्बर">
                                    <label class="form-label" for="cas_no">CAS नम्बर</label>

                                    @error('cas_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input id="molecular_formula" type="text"
                                        class="form-control @error('molecular_formula') is-invalid @enderror"
                                        name="molecular_formula" value="{{ old('molecular_formula') }}"
                                        autocomplete="off" placeholder="आणविक सूत्र">
                                    <label class="form-label" for="molecular_formula">आणविक सूत्र</label>

                                    @error('molecular_formula')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select id="source_id" name="source_id"
                                        class="form-select @error('source_id') is-invalid @enderror">
                                        <option value="">स्रोत छान्नुहोस्</option>
                                        @foreach($sources as $source)
                                        <option value="{{ $source->id }}" {{ old('source_id') == $source->id ? 'selected' : '' }}>
                                            {{ $source->sourcename }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label class="form-label" for="source_id">स्रोत</label>

                                    @error('source_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">रद्द गर्नुहोस्</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> सेभ गर्नुहोस्
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
