@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">H.C.S विवरण सम्पादन गर्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikaran.workflow', ['panjikaran' => $hcsDetail->panjikaran_id, 'step' => 4]) }}">कार्यप्रवाह</a></li>
                        <li class="breadcrumb-item active">H.C.S विवरण सम्पादन</li>
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
                    <form action="{{ route('hcs-details.update', $hcsDetail->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="from_workflow" value="1">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('hcs_code') is-invalid @enderror"
                                        name="hcs_code" value="{{ old('hcs_code', $hcsDetail->hcs_code) }}" required
                                        placeholder="H.C.S कोड">
                                    <label for="hcs_code">H.C.S कोड</label>
                                    @error('hcs_code')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('self_life_of_the_product') is-invalid @enderror"
                                        name="self_life_of_the_product" value="{{ old('self_life_of_the_product', $hcsDetail->self_life_of_the_product) }}"
                                        placeholder="उत्पादनको शेल्फ लाइफ">
                                    <label for="self_life_of_the_product">उत्पादनको शेल्फ लाइफ</label>
                                    @error('self_life_of_the_product')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        name="date" value="{{ old('date', $hcsDetail->date ? $hcsDetail->date->format('Y-m-d') : '') }}"
                                        placeholder="मिति">
                                    <label for="date">मिति</label>
                                    @error('date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <textarea class="form-control @error('tax_payment_bhauchar_details') is-invalid @enderror"
                                        name="tax_payment_bhauchar_details" rows="4" style="height: 100px;"
                                        placeholder="कर भुक्तानी भौचर विवरण">{{ old('tax_payment_bhauchar_details', $hcsDetail->tax_payment_bhauchar_details) }}</textarea>
                                    <label for="tax_payment_bhauchar_details">कर भुक्तानी भौचर विवरण</label>
                                    @error('tax_payment_bhauchar_details')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa fa-save"></i> अपडेट गर्नुहोस्
                                </button>
                                <a href="{{ route('panjikaran.workflow', ['panjikaran' => $hcsDetail->panjikaran_id, 'step' => 4]) }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> फिर्ता जानुहोस्
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
