@extends('layouts.base')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@300;400;500;600;700&display=swap');

    .dashboard-welcome {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 16px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        text-align: center;
        font-family: 'Noto Sans Devanagari', sans-serif;
    }

    .welcome-title {
        font-size: 2.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        line-height: 1.3;
        font-family: 'Noto Sans Devanagari', sans-serif;
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 400;
        font-family: 'Noto Sans Devanagari', sans-serif;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease;
        border: 1px solid #f1f5f9;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        display: block;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #64748b;
        font-weight: 500;
        font-family: 'Noto Sans Devanagari', sans-serif;
    }

    @media (max-width: 768px) {
        .dashboard-welcome {
            padding: 2rem;
        }

        .welcome-title {
            font-size: 1.8rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<div class="dashboard-welcome">
    <div class="welcome-content">
        <h1 class="welcome-title">
            प्लान्ट क्वारेन्टाइन तथा बिषादी व्यवस्थापन केन्द्र
        </h1>
        <p class="welcome-subtitle">
            {{-- {{ now()->format('H') < 12 ? 'शुभ प्रभात!' : (now()->format('H') < 17 ? 'शुभ दिन!' : 'शुभ साँझ!') }} --}}
            जीवनाशक विषादी पञ्जीकरण प्रणाली
        </p>
    </div>
</div>

<div class="dashboard-content">
    <div class="stats-grid">


        <a href="{{ route('dataentry.checklists.index', ['list_type' => 'registered']) }}">
            <div class="stat-card">
                <div class="stat-icon">📝</div>
                <div class="stat-number">{{ $countRegistered }}</div>
                <div class="stat-label">दर्ता भएका चेकलिष्ट</div>
            </div>
        </a>

        <a href="{{ route('dataentry.checklists.index', ['list_type' => 'verified']) }}">
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-number">{{ $countVerified }}</div>
                <div class="stat-label">रूजु भई स्वीकृत हुन बाँकी चेकलिष्ट</div>
            </div>
        </a>

        <a href="{{ route('dataentry.checklists.index', ['list_type' => 'approved']) }}">
            <div class="stat-card">
                <div class="stat-icon">✔️</div>
                <div class="stat-number">{{ $countApproved }}</div>
                <div class="stat-label">स्वीकृत भएका चेकलिष्ट</div>
            </div>
        </a>

        <a href="{{ route('panjikarans.index') }}">
            <div class="stat-card">
                <div class="stat-icon">📋</div>
                <div class="stat-number">{{ $countPanjikaran }}</div>
                <div class="stat-label">पञ्जीकरण</div>
            </div>
        </a>
    </div>
</div>
@endsection
