@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">تفاصيل الحجز</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}" class="text-decoration-none text-muted">الكشوفات الطبية</a></li>
            <li class="breadcrumb-item active" aria-current="page">عرض الحجز</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-light border-bottom px-4 py-3 d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-muted">calendar_today</span>
                <h6 class="mb-0 fw-bold">ملخص الحجز الطبي</h6>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">الطفل المريض</p>
                        <h5 class="fw-bold"><a href="{{ route('kids.show', $reservation->kid_id) }}" class="text-decoration-none">{{ $reservation->kid->full_name }}</a></h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">تاريخ ووقت الزيارة</p>
                        <h5 class="fw-bold" dir="ltr">{{ $reservation->visit_date->format('Y-m-d h:i A') }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">حالة الحجز</p>
                        <h5 class="fw-bold">
                            @if($reservation->status == 'Scheduled')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">مجدول</span>
                            @elseif($reservation->status == 'Completed')
                                <span class="badge bg-success px-3 py-2 rounded-pill">مكتمل</span>
                            @else
                                <span class="badge bg-danger px-3 py-2 rounded-pill">ملغي</span>
                            @endif
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">حالة الدفع</p>
                        <h5 class="fw-bold">
                            @if($reservation->payment_status == 'Paid')
                                <span class="text-success fw-bold d-flex align-items-center gap-1"><span class="material-symbols-outlined fs-6">check_circle</span> مدفوع</span>
                            @else
                                <span class="text-danger fw-bold d-flex align-items-center gap-1"><span class="material-symbols-outlined fs-6">cancel</span> غير مدفوع</span>
                            @endif
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">الرسوم المطلوبة</p>
                        <h5 class="fw-bold">{{ number_format($reservation->fee, 2) }} ج.م</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">تم الإنشاء بواسطة</p>
                        <h5 class="fw-bold">{{ $reservation->user->name ?? 'غير محدد' }}</h5>
                    </div>
                    <div class="col-12">
                        <p class="text-muted mb-1">ملاحظات</p>
                        <div class="bg-light p-3 rounded border">
                            {{ $reservation->notes ?: 'لا توجد ملاحظات إضافية.' }}
                        </div>
                    </div>
                </div>

                <div class="mt-5 d-flex gap-2">
                    <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-warning fw-bold px-4">تعديل بيانات الحجز</a>
                    <a href="{{ route('reservations.index') }}" class="btn btn-light border fw-bold px-4 text-muted">العودة للقائمة</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
