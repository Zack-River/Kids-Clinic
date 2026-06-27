@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">تعديل تطعيم</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vaccines.index') }}" class="text-decoration-none text-muted">التطعيمات</a></li>
            <li class="breadcrumb-item active" aria-current="page">تعديل تطعيم</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('vaccines.update', $vaccine) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">اسم التطعيم</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $vaccine->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category" class="form-label fw-bold">الفئة (اختياري)</label>
                        <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category', $vaccine->category) }}">
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="manufacturer" class="form-label fw-bold">الشركة المصنعة (اختياري)</label>
                        <input type="text" class="form-control @error('manufacturer') is-invalid @enderror" id="manufacturer" name="manufacturer" value="{{ old('manufacturer', $vaccine->manufacturer) }}">
                        @error('manufacturer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <a href="{{ route('vaccines.index') }}" class="btn btn-light px-4">إلغاء</a>
                        <button type="submit" class="btn btn-primary-custom px-5">تحديث التطعيم</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
