@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">إضافة حجز جديد</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}" class="text-decoration-none text-muted">الكشوفات الطبية</a></li>
            <li class="breadcrumb-item active" aria-current="page">حجز جديد</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-light border-bottom px-4 py-3 d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-muted">book_online</span>
                <h6 class="mb-0 fw-bold">بيانات الحجز الطبي</h6>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <!-- Select Kid -->
                        <div class="col-md-6">
                            <label for="kid_id" class="form-label fw-bold">اسم الطفل <span class="text-danger">*</span></label>
                            <select class="form-select @error('kid_id') is-invalid @enderror" id="kid_id" name="kid_id" required>
                                <option value="" disabled {{ old('kid_id', $selectedKidId) ? '' : 'selected' }}>اختر الطفل...</option>
                                @foreach($kids as $kid)
                                    <option value="{{ $kid->id }}" {{ old('kid_id', $selectedKidId) == $kid->id ? 'selected' : '' }}>
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
                                <input type="datetime-local" class="form-control border-start-0 ps-0 @error('visit_date') is-invalid @enderror" id="visit_date" name="visit_date" value="{{ old('visit_date') }}" required>
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
                                <input type="number" step="0.01" min="0" class="form-control border-start-0 ps-0 @error('fee') is-invalid @enderror" id="fee" name="fee" value="{{ old('fee', '0.00') }}" required>
                                @error('fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="col-12">
                            <label for="notes" class="form-label fw-bold">ملاحظات إضافية (اختياري)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="أي تفاصيل أو أعراض ظاهرة...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-12 text-start mt-4">
                            <button type="submit" class="btn btn-primary-custom px-5 py-2 fw-bold">تأكيد الحجز</button>
                            <a href="{{ route('reservations.index') }}" class="btn btn-light border px-4 py-2 ms-2 text-muted fw-bold">إلغاء</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
