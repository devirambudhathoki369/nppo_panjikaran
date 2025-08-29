@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">नयाँ पेश गर्ने व्यक्ति, संस्था वा निकायको / उत्पादक थप्नुहोस्</h4>

                    <form action="{{ route('dataentry.checklists.store') }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label for="LicenseNo" class="form-label">इजाजतपत्र नं.</label>
                                <input type="text" class="form-control @error('LicenseNo') is-invalid @enderror"
                                    id="LicenseNo" name="LicenseNo" value="{{ old('LicenseNo') }}" required>
                                @error('LicenseNo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="license-loading" class="text-info mt-1" style="display: none;">
                                    <small>Loading...</small>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="ImporterName" class="form-label">पेश गर्ने व्यक्ति, संस्था वा निकायको
                                    नाम</label>
                                <input type="text" class="form-control @error('ImporterName') is-invalid @enderror"
                                    id="ImporterName" name="ImporterName" value="{{ old('ImporterName') }}" required>
                                @error('ImporterName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="name-error" class="text-danger mt-1" style="display: none;">
                                    <small></small>
                                </div>
                                <div id="name-success" class="text-success mt-1" style="display: none;">
                                    <small><i class="fas fa-check"></i> इजाजतपत्र पुष्टि भयो र नाम स्वचालित रूपमा
                                        भरियो</small>
                                </div>
                                <div id="view-profile-section" class="mt-2" style="display: none;">
                                    <a href="#" id="view-profile-btn" class="btn btn-sm btn-outline-primary"
                                        target="_blank">
                                        <i class="fas fa-eye"></i> प्रोफाइल हेर्नुहोस्
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="ApplicationType" class="form-label">आवेदनको प्रकार</label>
                                <select class="form-control @error('ApplicationType') is-invalid @enderror"
                                    id="ApplicationType" name="ApplicationType" required>
                                    <option value="">छान्नुहोस्</option>
                                    @for ($i = 0; $i <= 1; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('ApplicationType') == $i ? 'selected' : '' }}>{{ checklistType($i) }}
                                        </option>
                                    @endfor
                                </select>
                                @error('ApplicationType')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="formulation_id" class="form-label">फर्मुलेशन</label>
                                <select class="form-control @error('formulation_id') is-invalid @enderror"
                                    id="formulation_id" name="formulation_id" required>
                                    <option value="">छान्नुहोस्</option>
                                    @foreach ($formulations as $formulation)
                                        <option value="{{ $formulation->id }}"
                                            {{ old('formulation_id') == $formulation->id ? 'selected' : '' }}>
                                            {{ $formulation->formulation_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('formulation_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="bishadi_type_id" class="form-label">बिषादिको प्रकार</label>
                                <select class="form-control @error('bishadi_type_id') is-invalid @enderror"
                                    id="bishadi_type_id" name="bishadi_type_id" required>
                                    <option value="">छान्नुहोस्</option>
                                    @foreach ($bishadiTypes as $bishadiType)
                                        <option value="{{ $bishadiType->id }}"
                                            {{ old('bishadi_type_id') == $bishadiType->id ? 'selected' : '' }}>
                                            {{ $bishadiType->prakar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bishadi_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="TradeNameOfPesticide" class="form-label">जीवनाशक विषादीको ब्यापारिक नाम</label>
                                <input type="text"
                                    class="form-control @error('TradeNameOfPesticide') is-invalid @enderror"
                                    id="TradeNameOfPesticide" name="TradeNameOfPesticide"
                                    value="{{ old('TradeNameOfPesticide') }}" required>
                                @error('TradeNameOfPesticide')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> सेभ गर्नुहोस्
                                </button>
                                <a href="{{ route('dataentry.checklists.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> रद्द गर्नुहोस्
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let typingTimer;
            const doneTypingInterval = 1000; // 1 second delay after user stops typing

            $('#LicenseNo').on('keyup', function() {
                clearTimeout(typingTimer);
                const licenseNo = $(this).val().trim();

                if (licenseNo.length > 0) {
                    typingTimer = setTimeout(function() {
                        fetchLicenseInfo(licenseNo);
                    }, doneTypingInterval);
                } else {
                    // Clear the importer name field if license number is empty
                    $('#ImporterName').val('');
                    hideMessages();
                    hideViewProfileButton();
                }
            });

            $('#LicenseNo').on('keydown', function() {
                clearTimeout(typingTimer);
            });

            function fetchLicenseInfo(licenseNo) {
                showLoading();
                hideMessages();

                $.ajax({
                    url: '{{ route('getLicenseInfo') }}',
                    method: 'GET',
                    data: {
                        license_no: licenseNo
                    },
                    success: function(response) {
                        hideLoading();

                        if (response.success) {
                            $('#ImporterName').val(response.data.agrovet_name);
                            showSuccess('इजाजतपत्र पुष्टि भयो र नाम स्वचालित रूपमा भरियो');
                            showViewProfileButton(licenseNo);
                        } else {
                            $('#ImporterName').val('').focus();
                            showError(response.message);
                            hideViewProfileButton();
                        }
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        $('#ImporterName').val('').focus();
                        showError(
                            'इजाजतपत्र जानकारी प्राप्त गर्न समस्या भयो। कृपया नाम आफैं प्रविष्ट गर्नुहोस्।'
                        );
                        hideViewProfileButton();
                        console.error('AJAX Error:', error);
                    }
                });
            }

            function showLoading() {
                $('#license-loading').show();
            }

            function hideLoading() {
                $('#license-loading').hide();
            }

            function showError(message) {
                $('#name-error small').text(message);
                $('#name-error').show();
            }

            function showSuccess(message) {
                $('#name-success small').html('<i class="fas fa-check"></i> ' + message);
                $('#name-success').show();
                $('#name-error').hide();
            }

            function hideMessages() {
                $('#name-error').hide();
                $('#name-success').hide();
            }

            function showViewProfileButton(licenseNo) {
                const profileUrl = '{{ route('license.profile', ':licenseNo') }}';
                $('#view-profile-btn').attr('href', profileUrl.replace(':licenseNo', licenseNo));
                $('#view-profile-section').show();
            }

            function hideViewProfileButton() {
                $('#view-profile-section').hide();
            }
        });
    </script>
@endsection
