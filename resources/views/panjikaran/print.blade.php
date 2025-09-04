@extends('layouts.base')

@section('title', 'जीवनाशक विषादी पञ्जीकरण अभिलेख - प्रिन्ट')

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@300;400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .print-container {
        font-family: 'Noto Sans Devanagari', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.8;
        color: #333;
        background: #fff;
        padding: 20px;
        font-size: 14px;
    }

    .print-actions {
        text-align: center;
        margin-bottom: 20px;
    }

    .print-btn {
        background: #007bff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        margin: 0 5px;
    }

    .print-btn:hover {
        background: #0056b3;
    }

    .print-btn.secondary {
        background: #6c757d;
    }

    .form-header {
        text-align: center;
        border-bottom: 3px solid #000;
        padding-bottom: 15px;
        margin-bottom: 30px;
    }

    .form-header h1 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .form-header h2 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .form-header h3 {
        font-size: 14px;
        font-weight: normal;
        margin-bottom: 5px;
    }

    .form-content {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-section {
        margin-bottom: 25px;
    }

    .section-title {
        font-weight: bold;
        font-size: 15px;
        text-decoration: underline;
        margin-bottom: 15px;
        text-align: center;
    }

    .form-row {
        margin-bottom: 12px;
        display: flex;
        align-items: baseline;
    }

    .form-label {
        min-width: 40px;
        font-weight: bold;
        margin-right: 10px;
    }

    .form-value {
        flex: 1;
        padding-bottom: 2px;
        min-height: 20px;
    }

    .checkbox-group {
        margin: 15px 0;
    }

    .checkbox-item {
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }

    .checkbox-item input[type="checkbox"] {
        margin-right: 8px;
    }

    .signature-section {
        margin-top: 40px;
        clear: both;
    }

    .signature-row {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        margin-top: 30px;
    }

    .signature-box {
        text-align: center;
        flex: 1;
        border: 1px solid #333;
        padding: 20px;
        min-height: 150px;
    }

    .signature-line {
        border-bottom: 1px solid #333;
        margin-bottom: 5px;
        height: 40px;
    }

    .company-section {
        margin: 20px 0;
    }

    .company-details {
        margin-left: 20px;
    }

    @media print {
        .print-actions {
            display: none;
        }

        body {
            padding: 0;
            font-size: 12px;
        }

        .form-content {
            max-width: 100%;
        }
    }

    @media (max-width: 768px) {
        .print-container {
            padding: 10px;
        }

        .signature-row {
            flex-direction: column;
            gap: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="print-container">
    <div class="print-actions">
        <button onclick="window.print()" class="print-btn">
            <i class="fas fa-print"></i> प्रिन्ट गर्नुहोस्
        </button>
        <button onclick="window.history.back()" class="print-btn secondary">
            <i class="fas fa-arrow-left"></i> फिर्ता जानुहोस्
        </button>
        {{-- <button onclick="downloadPDF()" class="print-btn" style="background: #28a745;">
            <i class="fas fa-download"></i> PDF डाउनलोड
        </button> --}}
    </div>

    <div class="form-header">
        <h2>अनुसूची-२</h2>
        <h3>(नियम ५ को उपनियम (१) सँग सम्बन्धित)</h3>
        <h1>जीवनाशक विषादी पञ्जीकरण अभिलेखको ढाँचा</h1>
        <h2>नेपाल सरकार</h2>
        <h3>कृषि तथा पशुपन्छी विकास मन्त्रालय</h3>
        <h3>प्लान्ट क्वारेन्टीन तथा विषादी व्यवस्थापन केन्द्र</h3>
        <h3>हरिहरभवन, ललितपुर</h3>
    </div>

    <div class="form-content">
        <div class="section-title">जीवनाशक विषादी पञ्जीकरणको अभिलेख</div>

        <p style="text-align: justify; margin-bottom: 20px;">
            जीवनाशक विषादी व्यवस्थापन ऐन, २०७६ को दफा ३ तथा जीवनाशक विषादी व्यवस्थापन नियमावली, २०७७ को नियम ५ को उपनियम (१) बमोजिम देहायका जीवनाशक विषादीको उत्पादन/संशोधन/निकासी/पेठारी/व्यावसायिक प्रयोग/भण्डारण/बिक्री वितरण/आयातपत्यार/व्यापिक वा पुनः व्यापिकको लागि पञ्जीकरण गरी देहाय बमोजिम अभिलेख राखिएको छ ।
        </p>

        <div class="form-section">
            <div class="section-title">जीवनाशक विषादीको:</div>

            <div class="form-row">
                <span class="form-label">१.</span>
                <span style="margin-right: 20px;">पञ्जीकरण नं.:</span>
                <span class="form-value">{{ $panjikaran->checklist->PanjikaranDecisionNo ?? '..........' }}</span>
            </div>

            <div class="form-row">
                <span class="form-label">२.</span>
                <span style="margin-right: 20px;">पञ्जीकरण मिति:</span>
                <span class="form-value">{{ $panjikaran->created_at ? $panjikaran->created_at->format('Y-m-d') : '..........' }}</span>
            </div>

            <div class="form-row">
                <span class="form-label">३.</span>
                <span style="margin-right: 20px;">व्यापारिक नाम:</span>
                <span class="form-value">{{ $panjikaran->checklist->TradeNameOfPesticide ?? '..........' }}</span>
            </div>

            <div class="form-row">
                <span class="form-label">४.</span>
                <span style="margin-right: 20px;">साधारण नाम:</span>
                <span class="form-value">
                    @if($panjikaran->checklist && $panjikaran->checklist->check_list_formulations->count() > 0)
                        @foreach($panjikaran->checklist->check_list_formulations as $formulation)
                            {{ $formulation->common_name->common_name ?? '..........' }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    @else
                        ..........
                    @endif
                </span>
            </div>

            <div class="form-row">
                <span class="form-label">५.</span>
                <span style="margin-right: 20px;">रासायनिक नाम:</span>
                <span class="form-value">{{ $panjikaran->ChemicalName ?? '..........' }}</span>
            </div>

            <div class="form-row">
                <span class="form-label">६.</span>
                <span style="margin-right: 20px;">आइ.यु.पि.ए.सी. नाम:</span>
                <span class="form-value">{{ $panjikaran->IUPAC_Name ?? '..........' }}</span>
            </div>

            <div class="form-row">
                <span class="form-label">७.</span>
                <span style="margin-right: 20px;">क्यास नं.:</span>
                <span class="form-value">{{ $panjikaran->Cas_No ?? '..........' }}</span>
            </div>

            <div class="form-row">
                <span class="form-label">८.</span>
                <span style="margin-right: 20px;">आणविक सूत्र:</span>
                <span class="form-value">{{ $panjikaran->Atomic_Formula ?? '..........' }}</span>
            </div>
        </div>

        <!-- Source/Origin Section -->
        <div class="form-section">
            <div class="form-row">
                <span class="form-label">९.</span>
                <span style="margin-right: 20px;">बनेको स्रोत:</span>
                <span class="form-value">{{ $panjikaran->source->sourcename ?? '..........' }}</span>
            </div>
        </div>

        <!-- Pesticide Group Section -->
        <div class="form-section">
            <div class="form-row">
    <span class="form-label">१०.</span>
    <span style="margin-right: 20px;">जीवनाशक विषादीको समूह: {{ $panjikaran->checklist->bishadiType->prakar ?? 'N/A' }}</span>
</div>
            {{-- <div style="margin-left: 30px;">
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox"> (क) अर्गानोफस्फेट
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox"> (ख) कार्बामेटस
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox"> (ग) पाइरेथ्याइड्स
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox"> (घ) नियोनिकोटिनवाइड्स
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox"> (ङ) फिनायल एमाइड्स
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox"> (च) फिनायल अल्कानोएटस
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox"> (छ) ट्राजिन्स
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox"> (ज) बेन्ज्याइमिक एसिड
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox"> (झ) थलिमाइड्स
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox"> (ञ) डिप्याइरिड्स
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox"> (ट) अन्य .........................
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Purpose/Objective Section -->
        <div class="form-section">
            <div class="form-row">
                <span class="form-label">११.</span>
                <span style="margin-right: 20px;">पञ्जीकरणको उद्देश्य:</span>
                <span class="form-value">{{ $panjikaran->usage->usage_name ?? '..........' }}</span>
            </div>
        </div>

        <!-- Usage/Application Section -->
        <div class="form-section">
            <div class="form-row">
                <span class="form-label">१२.</span>
                <span style="margin-right: 20px;">प्रयोग:</span>
                <span class="form-value">{{ $panjikaran->usage->usage_name ?? '..........' }}</span>
            </div>
        </div>

        <!-- Additional Details -->
        <div class="form-section">
            <div class="form-row">
                <span class="form-label">१३.</span>
                <span style="margin-right: 20px;">जीवनाशक विषादीको प्रभावक मात्रा ५० (LD₅₀):</span>
                <span class="form-value">{{ $panjikaran->DapperQuantity ?? '..........' }} {{ $panjikaran->unit->unit_name }}</span>
            </div>

            <div class="form-row">
                <span class="form-label">१४.</span>
                <span style="margin-right: 20px;">पदर्थे अवधि:</span>
                <span class="form-value">{{ $panjikaran->Waiting_duration ?? '..........' }}</span>
            </div>

            <div class="form-row">
                <span class="form-label">१५.</span>
                <span style="margin-right: 20px;">विष लागेको प्राथमिक उपचार:</span>
                <span class="form-value">{{ $panjikaran->FirstAid ?? '..........' }}</span>
            </div>

            <div class="form-row">
                <span class="form-label">१६.</span>
                <span style="margin-right: 20px;">जीवनाशक विषादीको वर्गीकरण:</span>
                <span class="form-value">
                    @if($panjikaran->bargikarans->count() > 0)
                        @foreach($panjikaran->bargikarans as $bargikaran)
                            Code: {{ $bargikaran->code }}, Make: {{ $bargikaran->make }}{{ !$loop->last ? '; ' : '' }}
                        @endforeach
                    @else
                        ..........
                    @endif
                </span>
            </div>

            <div class="form-row">
                <span class="form-label">१७.</span>
                <span style="margin-right: 20px;">सम्मिश्रण:</span>
                <span class="form-value">{{ $panjikaran->checklist->formulation->formulation_name ?? '..........' }}</span>
            </div>

            <div class="form-row">
                <span class="form-label">१८.</span>
                <span style="margin-right: 20px;">कन्टेनरको किसिम र क्षमता (पारिमाण):</span>
                <span class="form-value">
                    @if($panjikaran->checklist && $panjikaran->checklist->check_list_containers->count() > 0)
                        @foreach($panjikaran->checklist->check_list_containers as $container)
                            {{ $container->container->container_name ?? '..........' }} - {{ $container->capacity ?? '..........' }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    @else
                        ..........
                    @endif
                </span>
            </div>

            <div class="form-row">
                <span class="form-label">१९.</span>
                <span style="margin-right: 20px;">लक्षित बाली तथा शत्रुजीव:</span>
                <span class="form-value">
                    बाली: @if($panjikaran->recommendedCrops->count() > 0)
                        @foreach($panjikaran->recommendedCrops as $crop)
                            {{ $crop->crop->crop_name ?? '..........' }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    @else
                        ..........
                    @endif
                    <br>
                    कीरा: @if($panjikaran->recommendedPests->count() > 0)
                        @foreach($panjikaran->recommendedPests as $pest)
                            {{ $pest->pest->pest ?? '..........' }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    @else
                        ..........
                    @endif
                </span>
            </div>

            <div class="form-row">
                <span class="form-label">२०.</span>
                <span style="margin-right: 20px;">जीवनाशक विषादी र भाँडाका बिसर्जन गर्ने तरिका:</span>
                <span class="form-value">{{ $panjikaran->packageDestroy->packagedestroy_name ?? '..........' }}</span>
            </div>
        </div>

        <!-- Company Details Section -->
        <div class="form-section company-section">
            <div class="form-row">
                <span class="form-label">२१.</span>
                <span>विदेशी उत्पादक भएको कम्पनीको नाम र ठेगाना:</span>
            </div>
            <div class="company-details">
                <div class="form-row">
                    <span style="margin-right: 20px;">नाम:</span>
                    <span class="form-value">{{ $panjikaran->Foreign_producer_company_name ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">ठेगाना:</span>
                    <span class="form-value">{{ $panjikaran->Foreign_producer_company_address ?? '..........' }}</span>
                </div>
            </div>

            <div class="form-row" style="margin-top: 15px;">
                <span class="form-label">२२.</span>
                <span>नेपालमा उत्पादक भएको कम्पनीको नाम, ठेगाना, सम्पर्क टेलिफोन/मोबाइल नम्बर:</span>
            </div>
            <div class="company-details">
                <div class="form-row">
                    <span style="margin-right: 20px;">नाम:</span>
                    <span class="form-value">{{ $panjikaran->Nepali_producer_company_name ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">ठेगाना:</span>
                    <span class="form-value">{{ $panjikaran->Nepali_producer_company_address ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">सम्पर्क:</span>
                    <span class="form-value">{{ $panjikaran->Nepali_producer_company_contact ?? '..........' }}</span>
                </div>
            </div>

            <div class="form-row" style="margin-top: 15px;">
                <span class="form-label">२३.</span>
                <span>संसलेषण गर्ने कम्पनीको नाम, ठेगाना, ईमेल र सम्पर्क टेलिफोन/मोबाइल नम्बर:</span>
            </div>
            <div class="company-details">
                <div class="form-row">
                    <span style="margin-right: 20px;">नाम:</span>
                    <span class="form-value">{{ $panjikaran->Samejasamcompany_s_detail_name ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">ठेगाना:</span>
                    <span class="form-value">{{ $panjikaran->Samejasamcompany_s_detail_address ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">ईमेल:</span>
                    <span class="form-value">{{ $panjikaran->Samejasamcompany_s_detail_email ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">सम्पर्क:</span>
                    <span class="form-value">{{ $panjikaran->Samejasamcompany_s_detail_contact ?? '..........' }}</span>
                </div>
            </div>

            <div class="form-row" style="margin-top: 15px;">
                <span class="form-label">२४.</span>
                <span>प्याकिङ/पुनप्याकिङ गर्ने कम्पनीको नाम, ठेगाना, ईमेल र सम्पर्क टेलिफोन/मोबाइल नम्बर:</span>
            </div>
            <div class="company-details">
                <div class="form-row">
                    <span style="margin-right: 20px;">नाम:</span>
                    <span class="form-value">{{ $panjikaran->Packing_company_details_name ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">ठेगाना:</span>
                    <span class="form-value">{{ $panjikaran->Packing_company_details_address ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">ईमेल:</span>
                    <span class="form-value">{{ $panjikaran->Packing_company_details_email ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">सम्पर्क:</span>
                    <span class="form-value">{{ $panjikaran->Packing_company_details_contact ?? '..........' }}</span>
                </div>
            </div>

            <div class="form-row" style="margin-top: 15px;">
                <span class="form-label">२५.</span>
                <span>पेठारीकर्ताको नाम, ठेगाना, ईमेल र सम्पर्क टेलिफोन/मोबाइल नम्बर:</span>
            </div>
            <div class="company-details">
                <div class="form-row">
                    <span style="margin-right: 20px;">नाम:</span>
                    <span class="form-value">{{ $panjikaran->Paitharkarta_company_details_name ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">ठेगाना:</span>
                    <span class="form-value">{{ $panjikaran->Paitharkarta_company_details_address ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">ईमेल:</span>
                    <span class="form-value">{{ $panjikaran->Paitharkarta_company_details_email ?? '..........' }}</span>
                </div>
                <div class="form-row">
                    <span style="margin-right: 20px;">सम्पर्क:</span>
                    <span class="form-value">{{ $panjikaran->Paitharkarta_company_details_contact ?? '..........' }}</span>
                </div>
            </div>
        </div>

        <div class="signature-section">
            <div class="signature-row">
                <div class="signature-box">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                        <div style="width: 45%;">
                            <div style="text-decoration: underline; margin-bottom: 15px; font-weight: bold;">पञ्जीकरण गर्ने अधिकारीको</div>
                            <div style="text-decoration: underline; margin-bottom: 15px;">दस्तखत:</div>
                            <div style="height: 40px; margin-bottom: 10px;"></div>
                            <div style="margin-bottom: 5px;">नाम: {{ $panjikaran->checklist->creator->name ?? '............' }}</div>
                            <div style="margin-bottom: 5px;">पद: {{ $panjikaran->checklist->creator->designation ?? '............' }}</div>
                            <div>मिति: {{ $panjikaran->checklist->getCreatedDateNepaliAttribute() ?? '..............' }}</div>
                        </div>

                        <div style="width: 45%;">
                            <div style="text-decoration: underline; margin-bottom: 15px; font-weight: bold;">स्वीकृत गर्ने अधिकारीको</div>
                            <div style="text-decoration: underline; margin-bottom: 15px;">दस्तखत:</div>
                            <div style="height: 40px; margin-bottom: 10px;"></div>
                            <div style="margin-bottom: 5px;">नाम: {{ $panjikaran->checklist->approver->name ?? '..............' }}</div>
                            <div style="margin-bottom: 5px;">पद: {{ $panjikaran->checklist->approver->designation ?? '..............' }}</div>
                            <div>मिति: {{ $panjikaran->checklist->getApprovedDateNepaliAttribute() ?? '..............' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Print function
    function printPage() {
        window.print();
    }

    // PDF Download function (requires additional setup)
    function downloadPDF() {
        // You can implement PDF generation here
        // Options: 1. Use browser's print to PDF
        //          2. Use server-side PDF generation (dompdf, wkhtmltopdf)
        //          3. Use client-side libraries like jsPDF

        alert('PDF डाउनलोड सुविधा छिट्टै उपलब्ध हुनेछ।');

        // Alternative: Trigger print dialog and user can save as PDF
        window.print();
    }

    // Auto print when page loads (optional - uncomment if needed)
    // window.addEventListener('load', function() {
    //     setTimeout(() => {
    //         window.print();
    //     }, 1000);
    // });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl+P for print
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            printPage();
        }

        // Escape key to go back
        if (e.key === 'Escape') {
            window.history.back();
        }
    });

    // Hide print actions during printing
    window.addEventListener('beforeprint', function() {
        document.querySelector('.print-actions').style.display = 'none';
    });

    window.addEventListener('afterprint', function() {
        document.querySelector('.print-actions').style.display = 'block';
    });
</script>
@endsection
