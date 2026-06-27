@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">سجلات الحجوزات الطبية</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">الكشوفات الطبية</li>
        </ol>
    </nav>
</div>

<!-- Actions Bar -->
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
    <a href="{{ route('reservations.create') }}" class="btn btn-primary-custom px-4 d-flex align-items-center justify-content-center gap-2">
        <span class="material-symbols-outlined fs-5">calendar_add_on</span>
        إضافة حجز جديد
    </a>
    
    <div class="d-flex gap-2">
        <form action="{{ route('reservations.index') }}" method="GET" class="d-flex gap-2">
            <select name="status" class="form-select bg-white" onchange="this.form.submit()">
                <option value="">جميع الحالات</option>
                <option value="Scheduled" {{ request('status') == 'Scheduled' ? 'selected' : '' }}>مجدول</option>
                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>مكتمل</option>
                <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>ملغي</option>
            </select>
        </form>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Data Table Card -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-light border-bottom px-4 py-3 d-flex align-items-center gap-2">
        <span class="material-symbols-outlined text-muted">book_online</span>
        <h6 class="mb-0 fw-bold">جدول الحجوزات</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="py-3">الطفل</th>
                    <th scope="col" class="py-3">تاريخ ووقت الزيارة</th>
                    <th scope="col" class="py-3">حالة الحجز</th>
                    <th scope="col" class="py-3">الرسوم (ج.م)</th>
                    <th scope="col" class="py-3">الدفع</th>
                    <th scope="col" class="py-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse ($reservations as $reservation)
                <tr>
                    <td class="fw-medium">
                        <a href="{{ route('kids.show', $reservation->kid_id) }}" class="text-decoration-none">{{ $reservation->kid->full_name }}</a>
                    </td>
                    <td dir="ltr">{{ $reservation->visit_date->format('Y-m-d h:i A') }}</td>
                    <td>
                        @if($reservation->status == 'Scheduled')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">مجدول</span>
                        @elseif($reservation->status == 'Completed')
                            <span class="badge bg-success px-3 py-2 rounded-pill">مكتمل</span>
                        @else
                            <span class="badge bg-danger px-3 py-2 rounded-pill">ملغي</span>
                        @endif
                    </td>
                    <td>{{ number_format($reservation->fee, 2) }}</td>
                    <td>
                        @if($reservation->payment_status == 'Paid')
                            <span class="text-success fw-bold d-flex align-items-center justify-content-center gap-1"><span class="material-symbols-outlined fs-6">check_circle</span> مدفوع</span>
                        @else
                            <span class="text-danger fw-bold d-flex align-items-center justify-content-center gap-1"><span class="material-symbols-outlined fs-6">cancel</span> غير مدفوع</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-light text-primary border" title="عرض السجل"><span class="material-symbols-outlined fs-6">visibility</span></a>
                            <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-sm btn-light text-warning border" title="تعديل"><span class="material-symbols-outlined fs-6">edit</span></a>
                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger border" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟')"><span class="material-symbols-outlined fs-6">delete</span></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-muted py-4">لا توجد حجوزات مسجلة حتى الآن.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
