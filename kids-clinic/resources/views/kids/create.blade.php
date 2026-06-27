@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">إضافة ملف طفل جديد</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kids.index') }}" class="text-decoration-none text-muted">سجلات الأطفال</a></li>
            <li class="breadcrumb-item active" aria-current="page">إضافة طفل</li>
        </ol>
    </nav>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/css/intlTelInput.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .iti { width: 100%; display: block; }
    .iti__search-input { direction: ltr; }
    .iti__selected-dial-code { margin-right: 4px; }
    .iti__flag-container { padding-left: 16px !important; }
</style>
@endpush

<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-light border-bottom px-4 py-3 d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-muted">person_add</span>
                <h6 class="mb-0 fw-bold">البيانات الأساسية</h6>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('kids.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <!-- Child Name -->
                        <div class="col-md-6">
                            <label for="full_name" class="form-label fw-bold">اسم الطفل <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><span class="material-symbols-outlined fs-6 text-muted">person</span></span>
                                <input type="text" class="form-control border-start-0 ps-0 @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="أدخل اسم الطفل رباعي" required minlength="3" pattern="^[\u0621-\u064Aa-zA-Z\s]+$" oninvalid="this.setCustomValidity('يرجى إدخال اسم صحيح (3 أحرف على الأقل، أحرف فقط)')" oninput="this.setCustomValidity('')">
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Parent Name -->
                        <div class="col-md-6">
                            <label for="parent_name" class="form-label fw-bold">اسم ولي الأمر</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><span class="material-symbols-outlined fs-6 text-muted">family_restroom</span></span>
                                <input type="text" class="form-control border-start-0 ps-0 @error('parent_name') is-invalid @enderror" id="parent_name" name="parent_name" value="{{ old('parent_name') }}" placeholder="اسم ولي الأمر" minlength="3" pattern="^[\u0621-\u064Aa-zA-Z\s]+$" oninvalid="this.setCustomValidity('يرجى إدخال اسم صحيح (أحرف فقط)')" oninput="this.setCustomValidity('')">
                                @error('parent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <label for="contact_phone" class="form-label fw-bold d-block">رقم تليفون ولي الأمر</label>
                            <div class="w-100 position-relative">
                                <input type="tel" dir="ltr" style="text-align: right !important;" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}">
                            </div>
                            <div class="invalid-feedback d-none" id="phone_error"></div>
                            @error('contact_phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">الجنس <span class="text-danger">*</span></label>
                            <div class="d-flex gap-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" {{ old('gender', 'Male') == 'Male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genderMale">
                                        ذكر
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genderFemale">
                                        أنثى
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-6">
                            <label for="date_of_birth" class="form-label fw-bold">تاريخ الميلاد <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><span class="material-symbols-outlined fs-6 text-muted">calendar_month</span></span>
                                <input type="text" class="form-control bg-white border-start-0 ps-0 @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" placeholder="اختر تاريخ الميلاد" required oninvalid="this.setCustomValidity('تاريخ الميلاد مطلوب')" oninput="this.setCustomValidity('')">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Age Display (Auto-calculated) -->
                        <div class="col-12">
                            <div class="alert alert-secondary d-flex align-items-center gap-2 mb-0 border-0" role="alert">
                                <span class="material-symbols-outlined text-muted">calculate</span>
                                <div>
                                    <strong>العمر المحسوب:</strong> <span id="calculatedAge">أدخل تاريخ الميلاد لحساب العمر</span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-12 text-start mt-4">
                            <button type="submit" class="btn btn-primary-custom px-5 py-2 fw-bold">حفظ البيانات</button>
                            <a href="{{ route('kids.index') }}" class="btn btn-light border px-4 py-2 ms-2 text-muted fw-bold">إلغاء</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('date_of_birth').addEventListener('change', function() {
        if(!this.value) return;
        
        const dob = new Date(this.value);
        const today = new Date();
        
        let years = today.getFullYear() - dob.getFullYear();
        let months = today.getMonth() - dob.getMonth();
        let days = today.getDate() - dob.getDate();
        
        if (months < 0 || (months === 0 && today.getDate() < dob.getDate())) {
            years--;
            months += 12;
        }
        
        if (days < 0) {
            months--;
            // Get days in previous month
            const lastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
            days += lastMonth.getDate();
        }
        
        if(years < 0) {
            document.getElementById('calculatedAge').textContent = "تاريخ غير صحيح";
            return;
        }
        
        document.getElementById('calculatedAge').textContent = 
            `${years} سنة و ${months} شهر و ${days} يوم`;
    });
    
    // Trigger on load if value exists (for validation errors)
    if(document.getElementById('date_of_birth').value) {
        document.getElementById('date_of_birth').dispatchEvent(new Event('change'));
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ar.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const maxDate = new Date();
        maxDate.setMonth(maxDate.getMonth() - 1);
        
        flatpickr("#date_of_birth", {
            locale: "ar",
            maxDate: maxDate,
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                document.getElementById('date_of_birth').dispatchEvent(new Event('change'));
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/intlTelInput.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.querySelector("#contact_phone");

        const iti = window.intlTelInput(input, {
            initialCountry: "eg",
            separateDialCode: true,
            showSelectedDialCode: true,
            formatOnDisplay: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/utils.js",
        });

        // Update the hidden value before form submission
        const form = input.closest('form');
        const phoneError = document.getElementById('phone_error');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (input.value.trim() !== '') {
                    if (!iti.isValidNumber()) {
                        e.preventDefault();
                        input.classList.add('is-invalid');
                        phoneError.textContent = 'رقم التليفون المدخل غير صالح للبلد المحددة.';
                        phoneError.classList.remove('d-none');
                        phoneError.classList.add('d-block');
                        return;
                    }
                    input.value = iti.getNumber();
                }
            });
            input.addEventListener('input', function() {
                input.classList.remove('is-invalid');
                phoneError.classList.remove('d-block');
                phoneError.classList.add('d-none');
            });
        }
    });
</script>
@endpush
