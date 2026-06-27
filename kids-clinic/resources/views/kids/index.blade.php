@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/css/intlTelInput.css">
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">سجلات الأطفال</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">سجلات الأطفال</li>
        </ol>
    </nav>
</div>

<!-- Actions Bar -->
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
    <a href="{{ route('kids.create') }}" class="btn btn-primary-custom px-4 d-flex align-items-center justify-content-center gap-2">
        <span class="material-symbols-outlined fs-5">person_add</span>
        إضافة جديد
    </a>
    
    <form id="searchForm" action="{{ route('kids.index') }}" method="GET" class="search-input-wrapper" style="width: 100%; max-width: 300px;">
        <span class="material-symbols-outlined">search</span>
        <input type="text" id="searchInput" name="search" class="form-control bg-white" placeholder="بحث بالاسم أو رقم التليفون..." value="{{ request('search') }}">
    </form>
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
        <span class="material-symbols-outlined text-muted">list_alt</span>
        <h6 class="mb-0 fw-bold">ملفات الأطفال المسجلين</h6>
    </div>
    <div class="table-responsive" id="kidsTableContainer">
        <table class="table table-hover align-middle mb-0 text-center text-nowrap">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="py-3">اسم الطفل</th>
                    <th scope="col" class="py-3">الجنس</th>
                    <th scope="col" class="py-3">العمر</th>
                    <th scope="col" class="py-3">رقم التليفون</th>
                    <th scope="col" class="py-3">خيارات الحجز</th>
                    <th scope="col" class="py-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse ($kids as $kid)
                <tr>
                    <td class="fw-medium text-nowrap">{{ $kid->full_name }}</td>
                    <td>{{ $kid->gender === 'Male' ? 'ذكر' : 'أنثى' }}</td>
                    <td>{{ $kid->age }}</td>
                    <td>
                        @if($kid->contact_phone)
                        <div class="d-flex align-items-center justify-content-center gap-2 text-success phone-container" data-phone="{{ $kid->contact_phone }}">
                            <span class="material-symbols-outlined fs-6">chat</span>
                            <div class="phone-formatted" dir="ltr">
                                <span dir="ltr">{{ $kid->contact_phone }}</span>
                            </div>
                        </div>
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('reservations.create', ['kid_id' => $kid->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">حجز جديد</a>
                    </td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('kids.show', $kid) }}" class="btn btn-sm btn-light text-primary border" title="عرض السجل"><span class="material-symbols-outlined fs-6">visibility</span></a>
                            <a href="{{ route('kids.edit', $kid) }}" class="btn btn-sm btn-light text-warning border" title="تعديل"><span class="material-symbols-outlined fs-6">edit</span></a>
                            <form action="{{ route('kids.destroy', $kid) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger border" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟')"><span class="material-symbols-outlined fs-6">delete</span></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-muted py-4">لا توجد سجلات أطفال مسجلة حتى الآن.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/intlTelInput.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dummyInput = document.createElement('input');
        const iti = window.intlTelInput(dummyInput, {
            initialCountry: "eg",
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/utils.js",
        });

        window.formatPhones = function() {
            document.querySelectorAll('.phone-container').forEach(container => {
                let rawPhone = container.getAttribute('data-phone');
                if (!rawPhone) return;

                if (!rawPhone.startsWith('+')) {
                    rawPhone = '+20' + (rawPhone.startsWith('0') ? rawPhone.substring(1) : rawPhone);
                }

                iti.setNumber(rawPhone);
                const countryData = iti.getSelectedCountryData();
                const dialCode = countryData.dialCode ? '+' + countryData.dialCode : '+20';
                const iso2 = countryData.iso2 ? countryData.iso2 : 'eg';
                const countryName = countryData.name ? countryData.name : 'Egypt';
                
                let nationalNumber = rawPhone.replace(dialCode, '').trim();

                const formattedHtml = `
                    <div class="d-flex align-items-center gap-1" dir="ltr">
                        <div class="iti__flag iti__${iso2} shadow-sm border border-secondary border-opacity-25 rounded-1" style="transform: scale(0.85); margin-right: 4px;" title="${countryName}"></div>
                        <span class="text-secondary fw-bold" style="font-size: 0.85rem;">${dialCode}</span>
                        <span class="fw-medium text-dark ms-1">${nationalNumber}</span>
                    </div>
                `;
                container.querySelector('.phone-formatted').innerHTML = formattedHtml;
            });
        };

        // Run formatting after utils load
        setTimeout(window.formatPhones, 300);

        let debounceTimer;
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
        });

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const url = new URL(searchForm.action);
                url.searchParams.set('search', searchInput.value);
                
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newTable = doc.getElementById('kidsTableContainer');
                        if (newTable) {
                            document.getElementById('kidsTableContainer').innerHTML = newTable.innerHTML;
                            // Re-format phones after AJAX replaces table contents
                            window.formatPhones();
                        }
                    })
                    .catch(error => console.error('Error fetching search results:', error));
            }, 300);
        });
    });
</script>
@endpush
