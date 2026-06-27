@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">عرض بيانات الطفل</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kids.index') }}" class="text-decoration-none text-muted">سجلات الأطفال</a></li>
            <li class="breadcrumb-item active" aria-current="page">بيانات الطفل</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-light border-bottom px-4 py-3 d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-muted">person</span>
                <h6 class="mb-0 fw-bold">البيانات الأساسية</h6>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">اسم الطفل</p>
                        <h5 class="fw-bold">{{ $kid->full_name }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">تاريخ الميلاد</p>
                        <h5 class="fw-bold">{{ $kid->date_of_birth }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">الجنس</p>
                        <h5 class="fw-bold">{{ $kid->gender === 'Male' ? 'ذكر' : 'أنثى' }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">اسم ولي الأمر</p>
                        <h5 class="fw-bold">{{ $kid->parent_name ?? 'غير محدد' }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">رقم تليفون ولي الأمر</p>
                        <h5 class="fw-bold" dir="ltr">{{ $kid->contact_phone ?? 'غير محدد' }}</h5>
                    </div>
                </div>

                <div class="mt-5 d-flex gap-2">
                    <a href="{{ route('kids.edit', $kid) }}" class="btn btn-warning fw-bold px-4">تعديل البيانات</a>
                    <a href="{{ route('kids.index') }}" class="btn btn-light border fw-bold px-4 text-muted">العودة للسجل</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
