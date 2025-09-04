@extends('layouts.base')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;500;600;700&display=swap');

    .dashboard-container {
        background: #f8f9fa;
        min-height: calc(100vh - 120px);
        padding: 1.5rem 0;
    }

    .dashboard-welcome {
        background: white;
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
        font-family: 'Noto Sans Devanagari', sans-serif;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #dee2e6;
    }

    .welcome-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #495057;
        font-family: 'Noto Sans Devanagari', sans-serif;
    }

    .welcome-subtitle {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 400;
        font-family: 'Noto Sans Devanagari', sans-serif;
    }

    .stats-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
        border: 1px solid #dee2e6;
        text-decoration: none;
        color: inherit;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        text-decoration: none;
        color: inherit;
    }

    /* Card Colors matching your existing design */
    .stat-card.primary {
        border-left: 4px solid #6f42c1;
        background: linear-gradient(135deg, #f8f7ff 0%, white 100%);
    }

    .stat-card.success {
        border-left: 4px solid #28a745;
        background: linear-gradient(135deg, #f8fff8 0%, white 100%);
    }

    .stat-card.info {
        border-left: 4px solid #17a2b8;
        background: linear-gradient(135deg, #f7fdff 0%, white 100%);
    }

    .stat-card.secondary {
        border-left: 4px solid #6c757d;
        background: linear-gradient(135deg, #f8f9fa 0%, white 100%);
    }

    .stat-card.warning {
        border-left: 4px solid #fd7e14;
        background: linear-gradient(135deg, #fff8f0 0%, white 100%);
        position: relative;
    }

    .stat-card.danger {
        border-left: 4px solid #dc3545;
        background: linear-gradient(135deg, #fff5f5 0%, white 100%);
        position: relative;
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        display: block;
        filter: grayscale(0.2);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #495057;
        font-family: 'Noto Sans Devanagari', sans-serif;
    }

    .stat-card.primary .stat-number {
        color: #6f42c1;
    }

    .stat-card.success .stat-number {
        color: #28a745;
    }

    .stat-card.info .stat-number {
        color: #17a2b8;
    }

    .stat-card.secondary .stat-number {
        color: #6c757d;
    }

    .stat-card.warning .stat-number {
        color: #fd7e14;
    }

    .stat-card.danger .stat-number {
        color: #dc3545;
    }

    .stat-label {
        color: #6c757d;
        font-weight: 500;
        font-family: 'Noto Sans Devanagari', sans-serif;
        font-size: 0.875rem;
        line-height: 1.4;
    }

    .stat-badge {
        display: inline-block;
        background: #dc3545;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .stat-badge.warning {
        background: #fd7e14;
    }

    /* Alert indicators like your existing design */
    .alert-dot {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: pulse-dot 2s infinite;
    }

    .stat-card.warning .alert-dot {
        background: #fd7e14;
    }

    .stat-card.danger .alert-dot {
        background: #dc3545;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.1); }
    }

    .dashboard-footer {
        text-align: center;
        margin-top: 2rem;
        color: #6c757d;
        font-family: 'Noto Sans Devanagari', sans-serif;
        font-size: 0.875rem;
    }

    @media (max-width: 1024px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .dashboard-container {
            padding: 1rem 0;
        }

        .dashboard-welcome {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .welcome-title {
            font-size: 1.25rem;
        }

        .welcome-subtitle {
            font-size: 0.8rem;
        }

        .stats-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-card {
            padding: 1.25rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .stat-label {
            font-size: 0.8rem;
        }

        .stat-icon {
            font-size: 2rem;
        }
    }
</style>

<div class="dashboard-container">
    <div class="container">
        <div class="dashboard-welcome">
            <div class="welcome-content">
                <h1 class="welcome-title">
                    प्लान्ट क्वारेन्टाइन तथा बिषादी व्यवस्थापन केन्द्र
                </h1>
                <p class="welcome-subtitle">
                    जीवनाशक विषादी पञ्जीकरण प्रणाली
                </p>
            </div>
        </div>

        <div class="stats-container">
            <!-- First Row -->
            <div class="stats-row">
                <a href="{{ route('dataentry.checklists.index', ['list_type' => 'registered']) }}" class="stat-card primary">
                    <div class="stat-icon">📝</div>
                    <div class="stat-number">{{ $countRegistered }}</div>
                    <div class="stat-label">दर्ता भएका चेकलिष्ट</div>
                </a>

                <a href="{{ route('dataentry.checklists.index', ['list_type' => 'verified']) }}" class="stat-card success">
                    <div class="stat-icon">✅</div>
                    <div class="stat-number">{{ $countVerified }}</div>
                    <div class="stat-label">रूजु भई स्वीकृत हुन बाँकी चेकलिष्ट</div>
                </a>

                <a href="{{ route('dataentry.checklists.index', ['list_type' => 'approved']) }}" class="stat-card info">
                    <div class="stat-icon">✔️</div>
                    <div class="stat-number">{{ $countApproved }}</div>
                    <div class="stat-label">स्वीकृत भएका चेकलिष्ट</div>
                </a>
            </div>

            <!-- Second Row -->
            <div class="stats-row">
                <a href="{{ route('panjikarans.index') }}" class="stat-card secondary">
                    <div class="stat-icon">📋</div>
                    <div class="stat-number">{{ $countPanjikaran }}</div>
                    <div class="stat-label">पञ्जीकरण</div>
                </a>

                <a href="{{ route('renewals.index', ['expiring' => 'soon']) }}" class="stat-card warning">
                    @if($countExpiringRenewals > 0)
                        <div class="alert-dot"></div>
                    @endif
                    <div class="stat-icon">⏰</div>
                    <div class="stat-number">{{ $countExpiringRenewals }}</div>
                    <div class="stat-label">
                        एक महिना भित्र म्याद सकिने पञ्जीकरण
                        @if($countExpiringRenewals > 0)
                            <span class="stat-badge warning">तत्काल ध्यान दिनुहोस्</span>
                        @endif
                    </div>
                </a>

                <a href="{{ route('renewals.index', ['expired' => 'true']) }}" class="stat-card danger">
                    @if($countExpiredRenewals > 0)
                        <div class="alert-dot"></div>
                    @endif
                    <div class="stat-icon">⚠️</div>
                    <div class="stat-number">{{ $countExpiredRenewals }}</div>
                    <div class="stat-label">
                        म्याद सकिएका पञ्जीकरण
                        @if($countExpiredRenewals > 0)
                            <span class="stat-badge">कारबाही आवश्यक</span>
                        @endif
                    </div>
                </a>
            </div>
        </div>

        <div class="dashboard-footer">
            <p>© {{ date('Y') }} प्लान्ट क्वारेन्टाइन तथा बिषादी व्यवस्थापन केन्द्र। सबै अधिकार सुरक्षित।</p>
        </div>
    </div>
</div>
@endsection
