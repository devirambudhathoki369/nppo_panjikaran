@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">डेटाबेस ब्याकअप</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">डेटाबेस ब्याकअप</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-database-export text-primary"></i>
                        डेटाबेस ब्याकअप डाउनलोड गर्नुहोस्
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="mdi mdi-information"></i> सूचना:</h6>
                        <ul class="mb-0">
                            <li>यो सुविधाले तोकिएको मिति दायराको डाटा ब्याकअप गर्छ।</li>
                            <li>ब्याकअप फाइल SQL ढाँचामा डाउनलोड हुनेछ।</li>
                            <li>कृपया मिति दायरा सही रूपमा छान्नुहोस्।</li>
                        </ul>
                    </div>

                    <form action="{{ route('database.backup.download') }}" method="POST" id="backupForm">
                        @csrf
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="alert alert-warning">
                                    <h6><i class="mdi mdi-alert"></i> चेतावनी:</h6>
                                    <p class="mb-0">यो सम्पूर्ण डेटाबेसको ब्याकअप डाउनलोड गर्नेछ। डेटाबेसको आकारअनुसार केही समय लाग्न सक्छ।</p>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg" id="downloadBtn">
                                    <i class="mdi mdi-download"></i>
                                    सम्पूर्ण डेटाबेस डाउनलोड गर्नुहोस्
                                </button>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        ब्याकअप तयार हुन केही समय लाग्न सक्छ, कृपया पर्खनुहोस्।
                                    </small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Instructions Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-help-circle text-info"></i>
                        निर्देशनहरू
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="mdi mdi-check-circle text-success"></i> ब्याकअप कसरी लिने:</h6>
                            <ol>
                                <li>देखि मिति र सम्म मिति छान्नुहोस्</li>
                                <li>"ब्याकअप डाउनलोड गर्नुहोस्" बटनमा क्लिक गर्नुहोस्</li>
                                <li>फाइल आफ्नै कम्प्युटरमा सेभ गर्नुहोस्</li>
                                <li>सुरक्षित स्थानमा भण्डारण गर्नुहोस्</li>
                            </ol>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="mdi mdi-alert-circle text-warning"></i> महत्वपूर्ण सुझावहरू:</h6>
                            <ul>
                                <li>नियमित रूपमा ब्याकअप लिनुहोस्</li>
                                <li>ब्याकअप फाइलहरू सुरक्षित राख्नुहोस्</li>
                                <li>ठूलो डाटा भएमा धैर्य गर्नुहोस्</li>
                                <li>इन्टरनेट जडान स्थिर राख्नुहोस्</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.getElementById('backupForm').addEventListener('submit', function() {
        const downloadBtn = document.getElementById('downloadBtn');
        const originalText = downloadBtn.innerHTML;

        // Disable button and show loading state
        downloadBtn.disabled = true;
        downloadBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> ब्याकअप तयार गरिँदै...';

        // Re-enable button after 30 seconds (in case of slow download)
        setTimeout(function() {
            downloadBtn.disabled = false;
            downloadBtn.innerHTML = originalText;
        }, 30000);
    });

    // Validate date range
    document.getElementById('from_date').addEventListener('change', validateDateRange);
    document.getElementById('to_date').addEventListener('change', validateDateRange);

    function validateDateRange() {
        const fromDate = document.getElementById('from_date').value;
        const toDate = document.getElementById('to_date').value;

        if (fromDate && toDate) {
            if (new Date(fromDate) > new Date(toDate)) {
                alert('देखि मिति सम्म मिति भन्दा पहिले हुनुपर्छ।');
                document.getElementById('to_date').value = fromDate;
            }
        }
    }
</script>
@endsection
