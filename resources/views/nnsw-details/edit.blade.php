@extends('layouts.base')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">NNSW विवरण सम्पादन गर्नुहोस्</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('panjikaran.workflow', ['panjikaran' => $nnswDetail->panjikaran_id, 'step' => 5]) }}">कार्यप्रवाह</a></li>
                        <li class="breadcrumb-item active">NNSW विवरण सम्पादन</li>
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
                    <form action="{{ route('nnsw-details.update', $nnswDetail->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="from_workflow" value="1">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('nepal_rastriya_ekdwar_pranalima_anurodh_no') is-invalid @enderror"
                                        name="nepal_rastriya_ekdwar_pranalima_anurodh_no"
                                        value="{{ old('nepal_rastriya_ekdwar_pranalima_anurodh_no', $nnswDetail->nepal_rastriya_ekdwar_pranalima_anurodh_no) }}"
                                        placeholder="नेपाल राष्ट्रिय एकद्वार प्रणालीमा अनुरोध नं.">
                                    <label for="nepal_rastriya_ekdwar_pranalima_anurodh_no">नेपाल राष्ट्रिय एकद्वार प्रणालीमा अनुरोध नं.</label>
                                    @error('nepal_rastriya_ekdwar_pranalima_anurodh_no')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('nepal_rastriya_ekdwar_pranalima_anurodh_date') is-invalid @enderror"
                                        name="nepal_rastriya_ekdwar_pranalima_anurodh_date"
                                        value="{{ old('nepal_rastriya_ekdwar_pranalima_anurodh_date', $nnswDetail->nepal_rastriya_ekdwar_pranalima_anurodh_date ? $nnswDetail->nepal_rastriya_ekdwar_pranalima_anurodh_date->format('Y-m-d') : '') }}"
                                        placeholder="नेपाल राष्ट्रिय एकद्वार प्रणालीमा अनुरोध मिति">
                                    <label for="nepal_rastriya_ekdwar_pranalima_anurodh_date">नेपाल राष्ट्रिय एकद्वार प्रणालीमा अनुरोध मिति</label>
                                    @error('nepal_rastriya_ekdwar_pranalima_anurodh_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('company_code') is-invalid @enderror"
                                        name="company_code" value="{{ old('company_code', $nnswDetail->company_code) }}"
                                        placeholder="कम्पनी कोड">
                                    <label for="company_code">कम्पनी कोड</label>
                                    @error('company_code')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('swikrit_no') is-invalid @enderror"
                                        name="swikrit_no" value="{{ old('swikrit_no', $nnswDetail->swikrit_no) }}"
                                        placeholder="स्वीकृति नं.">
                                    <label for="swikrit_no">स्वीकृति नं.</label>
                                    @error('swikrit_no')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('swikrit_date') is-invalid @enderror"
                                        name="swikrit_date"
                                        value="{{ old('swikrit_date', $nnswDetail->swikrit_date ? $nnswDetail->swikrit_date->format('Y-m-d') : '') }}"
                                        placeholder="स्वीकृति मिति">
                                    <label for="swikrit_date">स्वीकृति मिति</label>
                                    @error('swikrit_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('baidata_abadhi') is-invalid @enderror"
                                        name="baidata_abadhi" value="{{ old('baidata_abadhi', $nnswDetail->baidata_abadhi) }}"
                                        placeholder="वैधता अवधि">
                                    <label for="baidata_abadhi">वैधता अवधि</label>
                                    @error('baidata_abadhi')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fa fa-save"></i> अपडेट गर्नुहोस्
                                </button>
                                <a href="{{ route('panjikaran.workflow', ['panjikaran' => $nnswDetail->panjikaran_id, 'step' => 5]) }}" class="btn btn-secondary">
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
