@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">الاستشارات الطبية</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">الاستشارات</li>
        </ol>
    </nav>
</div>

<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
    <a href="{{ route('consultations.create') }}" class="btn btn-primary-custom px-4 d-flex align-items-center justify-content-center gap-2">
        <span class="material-symbols-outlined fs-5">add</span>
        إضافة استشارة
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
        <span class="material-symbols-outlined text-muted">chat</span>
        <h6 class="mb-0 fw-bold">سجل الاستشارات</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center text-nowrap">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="py-3">رقم الحجز</th>
                    <th scope="col" class="py-3">اسم الطفل</th>
                    <th scope="col" class="py-3">الطبيب المعالج</th>
                    <th scope="col" class="py-3">التاريخ</th>
                    <th scope="col" class="py-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse ($consultations as $consultation)
                <tr>
                    <td class="fw-bold">#{{ $consultation->reservation_id }}</td>
                    <td class="fw-medium">{{ $consultation->reservation->kid->full_name ?? 'غير محدد' }}</td>
                    <td>{{ $consultation->user->name ?? 'طبيب' }}</td>
                    <td dir="ltr">{{ $consultation->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('consultations.edit', $consultation) }}" class="btn btn-sm btn-light text-warning border" title="تعديل"><span class="material-symbols-outlined fs-6">edit</span></a>
                            <form action="{{ route('consultations.destroy', $consultation) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger border" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟')"><span class="material-symbols-outlined fs-6">delete</span></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-muted py-4">لا توجد استشارات مسجلة حتى الآن.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($consultations->hasPages())
    <div class="card-footer bg-white border-top p-3">
        {{ $consultations->links() }}
    </div>
    @endif
</div>
@endsection
