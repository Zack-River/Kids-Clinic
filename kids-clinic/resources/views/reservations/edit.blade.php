@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">تعديل بيانات الحجز</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}" class="text-decoration-none text-muted">الكشوفات الطبية</a></li>
            <li class="breadcrumb-item active" aria-current="page">تعديل حجز</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-light border-bottom px-4 py-3 d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-muted">edit_calendar</span>
                <h6 class="mb-0 fw-bold">تحديث بيانات الحجز الطبي</h6>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('reservations.update', $reservation) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <!-- Select Kid -->
                        <div class="col-md-6">
                            <label for="kid_id" class="form-label fw-bold">اسم الطفل <span class="text-danger">*</span></label>
                            <select class="form-select @error('kid_id') is-invalid @enderror" id="kid_id" name="kid_id" required>
                                <option value="" disabled>اختر الطفل...</option>
                                @foreach($kids as $kid)
                                    <option value="{{ $kid->id }}" {{ old('kid_id', $reservation->kid_id) == $kid->id ? 'selected' : '' }}>
                                        {{ $kid->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kid_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Visit Date -->
                        <div class="col-md-6">
                            <label for="visit_date" class="form-label fw-bold">تاريخ ووقت الزيارة <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><span class="material-symbols-outlined fs-6 text-muted">event</span></span>
                                <input type="datetime-local" class="form-control border-start-0 ps-0 @error('visit_date') is-invalid @enderror" id="visit_date" name="visit_date" value="{{ old('visit_date', $reservation->visit_date->format('Y-m-d\TH:i')) }}" required>
                                @error('visit_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fee -->
                        <div class="col-md-6">
                            <label for="fee" class="form-label fw-bold">الرسوم المطلوبة <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><span class="material-symbols-outlined fs-6 text-muted">payments</span></span>
                                <input type="number" step="0.01" min="0" class="form-control border-start-0 ps-0 @error('fee') is-invalid @enderror" id="fee" name="fee" value="{{ old('fee', $reservation->fee) }}" required>
                                @error('fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-bold">حالة الحجز <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="Scheduled" {{ old('status', $reservation->status) == 'Scheduled' ? 'selected' : '' }}>مجدول</option>
                                <option value="Completed" {{ old('status', $reservation->status) == 'Completed' ? 'selected' : '' }}>مكتمل</option>
                                <option value="Cancelled" {{ old('status', $reservation->status) == 'Cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Status -->
                        <div class="col-md-6">
                            <label for="payment_status" class="form-label fw-bold">حالة الدفع <span class="text-danger">*</span></label>
                            <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                <option value="Pending" {{ old('payment_status', $reservation->payment_status) == 'Pending' ? 'selected' : '' }}>غير مدفوع (Pending)</option>
                                <option value="Paid" {{ old('payment_status', $reservation->payment_status) == 'Paid' ? 'selected' : '' }}>مدفوع (Paid)</option>
                            </select>
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="col-12">
                            <label for="notes" class="form-label fw-bold">ملاحظات إضافية (اختياري)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $reservation->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-12 text-start mt-4">
                            <button type="submit" class="btn btn-primary-custom px-5 py-2 fw-bold">حفظ التعديلات</button>
                            <a href="{{ route('reservations.index') }}" class="btn btn-light border px-4 py-2 ms-2 text-muted fw-bold">إلغاء</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
