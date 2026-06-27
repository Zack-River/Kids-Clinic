@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">أنواع التطعيمات</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">التطعيمات</li>
        </ol>
    </nav>
</div>

<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
    <a href="{{ route('vaccines.create') }}" class="btn btn-primary-custom px-4 d-flex align-items-center justify-content-center gap-2">
        <span class="material-symbols-outlined fs-5">add</span>
        إضافة تطعيم
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-light border-bottom px-4 py-3 d-flex align-items-center gap-2">
        <span class="material-symbols-outlined text-muted">vaccines</span>
        <h6 class="mb-0 fw-bold">قائمة التطعيمات المتاحة</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center text-nowrap">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="py-3">الاسم</th>
                    <th scope="col" class="py-3">الفئة</th>
                    <th scope="col" class="py-3">الشركة المصنعة</th>
                    <th scope="col" class="py-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse ($vaccines as $vaccine)
                <tr>
                    <td class="fw-medium">{{ $vaccine->name }}</td>
                    <td>{{ $vaccine->category ?? '-' }}</td>
                    <td>{{ $vaccine->manufacturer ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('vaccines.edit', $vaccine) }}" class="btn btn-sm btn-light text-warning border" title="تعديل"><span class="material-symbols-outlined fs-6">edit</span></a>
                            <form action="{{ route('vaccines.destroy', $vaccine) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger border" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟')"><span class="material-symbols-outlined fs-6">delete</span></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-muted py-4">لا توجد تطعيمات مسجلة حتى الآن.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($vaccines->hasPages())
    <div class="card-footer bg-white border-top p-3">
        {{ $vaccines->links() }}
    </div>
    @endif
</div>
@endsection
