@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">لوحة التحكم</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">لوحة التحكم</li>
        </ol>
    </nav>
</div>

<!-- Stats Grid -->
<div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card" style="background-color: #54a0ff;">
            <span class="material-symbols-outlined bg-icon">child_care</span>
            <div class="stat-value">{{ $totalKids ?? 0 }}</div>
            <h3>سجلات الأطفال</h3>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card" style="background-color: #10ac84;">
            <span class="material-symbols-outlined bg-icon">medical_services</span>
            <div class="stat-value">{{ $todayReservations ?? 0 }}</div>
            <h3>كشوفات اليوم</h3>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card" style="background-color: #FF9F43;">
            <span class="material-symbols-outlined bg-icon">chat</span>
            <div class="stat-value">{{ $todayConsultations ?? 0 }}</div>
            <h3>استشارات اليوم</h3>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card" style="background-color: #FF6B6B;">
            <span class="material-symbols-outlined bg-icon">vaccines</span>
            <div class="stat-value">{{ $todayVaccines ?? 0 }}</div>
            <h3>تطعيمات اليوم</h3>
        </div>
    </div>
</div>
@endsection
