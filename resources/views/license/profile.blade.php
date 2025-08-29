@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-id-card text-primary"></i> इजाजतपत्र विवरण
                    </h4>
                    <button onclick="window.history.back()" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> फिर्ता जानुहोस्
                    </button>
                </div>
                <div class="card-body">

                    <!-- License Status Banner -->
                    <div class="row mb-4">
                        <div class="col-12">
                            @if ($license->Status == '0')
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> <strong>सक्रिय इजाजतपत्र</strong>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> <strong>निष्क्रिय इजाजतपत्र</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-left-primary">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <i class="fas fa-building"></i> आधारभूत जानकारी
                                    </h5>

                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" style="width: 40%;">इजाजतपत्र नं:</td>
                                            <td>
                                                <span class="badge bg-primary fs-6">{{ $license->LicenseNo }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"> नाम नेपालीमा:</td>
                                            <td>{{ $license->AgrovetName ?? 'उपलब्ध छैन' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"> नाम अंग्रेजीमा:</td>
                                            <td>{{ $license->AgrovetNameEng ?? 'उपलब्ध छैन' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">प्रकार:</td>
                                            <td>
                                                @if ($license->Type == '0')
                                                    <span class="badge bg-info">आयातकर्ता</span>
                                                @elseif($license->Type == '1')
                                                    <span class="badge bg-success">विक्रेता</span>
                                                @else
                                                    <span class="badge bg-secondary">अज्ञात</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-left-success">
                                <div class="card-body">
                                    <h5 class="card-title text-success">
                                        <i class="fas fa-map-marker-alt"></i> ठेगाना विवरण
                                    </h5>

                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" style="width: 40%;"> ठेगाना नेपालीमा:</td>
                                            <td>{{ $license->AgrovetAddress ?? 'उपलब्ध छैन' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"> ठेगाना अंग्रेजीमा:</td>
                                            <td>{{ $license->AgrovetAddressEng ?? 'उपलब्ध छैन' }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <td class="fw-bold">जिल्ला ID:</td>
                                            <td>
                                                {{ $license->DistrictID }}
                                                @if ($district)
                                                    <br><small
                                                        class="text-muted">({{ $district->name ?? ($district->DistrictName ?? '') }})</small>
                                                @endif
                                            </td>
                                        </tr> --}}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- License Dates -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card border-left-warning">
                                <div class="card-body">
                                    <h5 class="card-title text-warning">
                                        <i class="fas fa-calendar-alt"></i> इजाजतपत्र मितिहरू
                                    </h5>

                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" style="width: 50%;">जारी मिति:</td>
                                            <td>
                                                <i class="fas fa-calendar-check text-success"></i>
                                                {{ $license->LicenseIssueDate ?? 'उपलब्ध छैन' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">म्याद सकिने मिति:</td>
                                            <td>
                                                <i class="fas fa-calendar-times text-danger"></i>
                                                {{ $license->LicenseExpiryDate ?? 'उपलब्ध छैन' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-6">
                            <div class="card border-left-info">
                                <div class="card-body">
                                    <h5 class="card-title text-info">
                                        <i class="fas fa-info-circle"></i> सिस्टम जानकारी
                                    </h5>

                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" style="width: 50%;">दर्ता ID:</td>
                                            <td>{{ $license->RegID ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">मुख्य फर्म ID:</td>
                                            <td>{{ $license->MainFirmID ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">प्रयोगकर्ता ID:</td>
                                            <td>{{ $license->UserID ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">अद्यावधिक मिति:</td>
                                            <td>
                                                <small>{{ $license->UpdatedOn ?? ($license->Timestamp ?? 'N/A') }}</small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <!-- Additional Information -->
                    @if ($license->Remarks || $license->isDismiss == '1')
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border-left-secondary">
                                    <div class="card-body">
                                        <h5 class="card-title text-secondary">
                                            <i class="fas fa-sticky-note"></i> थप जानकारी
                                        </h5>

                                        @if ($license->Remarks)
                                            <div class="mb-3">
                                                <strong>टिप्पणी:</strong>
                                                <p class="mt-2 p-3 bg-light rounded">{{ $license->Remarks }}</p>
                                            </div>
                                        @endif

                                        @if ($license->isDismiss == '1')
                                            <div class="alert alert-danger">
                                                <h6><i class="fas fa-ban"></i> इजाजतपत्र रद्द गरिएको</h6>
                                                <p><strong>रद्द मिति:</strong>
                                                    {{ $license->LicenseDismissDate ?? 'उपलब्ध छैन' }}</p>
                                                @if ($license->DismissRemarks)
                                                    <p><strong>रद्द कारण:</strong> {{ $license->DismissRemarks }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    {{-- <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button onclick="window.print()" class="btn btn-info">
                                <i class="fas fa-print"></i> प्रिन्ट गर्नुहोस्
                            </button>
                            <button onclick="window.history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> फिर्ता जानुहोस्
                            </button>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        .border-left-primary {
            border-left: 4px solid #007bff !important;
        }

        .border-left-success {
            border-left: 4px solid #28a745 !important;
        }

        .border-left-warning {
            border-left: 4px solid #ffc107 !important;
        }

        .border-left-info {
            border-left: 4px solid #17a2b8 !important;
        }

        .border-left-secondary {
            border-left: 4px solid #6c757d !important;
        }

        @media print {
            .btn {
                display: none !important;
            }

            .card {
                border: 1px solid #ddd !important;
            }
        }
    </style>
@endsection
