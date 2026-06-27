@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">تعديل الاستشارة</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('consultations.index') }}" class="text-decoration-none text-muted">الاستشارات</a></li>
            <li class="breadcrumb-item active" aria-current="page">تعديل الاستشارة</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('consultations.update', $consultation) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label fw-bold">الحجز الطبي</label>
                        <input type="text" class="form-control bg-light" value="حجز #{{ $consultation->reservation_id }} - {{ $consultation->reservation->kid->full_name ?? 'بدون اسم' }}" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="diagnosis_notes" class="form-label fw-bold">ملاحظات التشخيص</label>
                        <textarea class="form-control @error('diagnosis_notes') is-invalid @enderror" id="diagnosis_notes" name="diagnosis_notes" rows="6">{{ old('diagnosis_notes', $consultation->diagnosis_notes) }}</textarea>
                        @error('diagnosis_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <a href="{{ route('consultations.index') }}" class="btn btn-light px-4">إلغاء</a>
                        <button type="submit" class="btn btn-primary-custom px-5">تحديث الاستشارة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
