@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">إدارة المستخدمين</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">المستخدمين</li>
        </ol>
    </nav>
</div>

<!-- Actions Bar -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('users.create') }}" class="btn btn-primary-custom px-4 d-flex align-items-center gap-2">
        <span class="material-symbols-outlined fs-5">person_add</span>
        إضافة مستخدم جديد
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Data Table Card -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-light border-bottom px-4 py-3 d-flex align-items-center gap-2">
        <span class="material-symbols-outlined text-muted">group</span>
        <h6 class="mb-0 fw-bold">قائمة حسابات النظام</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center text-nowrap">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="py-3">الاسم</th>
                    <th scope="col" class="py-3">اسم المستخدم (Username)</th>
                    <th scope="col" class="py-3">الصلاحية</th>
                    <th scope="col" class="py-3">حالة الحساب</th>
                    <th scope="col" class="py-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse ($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle overflow-hidden bg-light d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                @if($user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span class="material-symbols-outlined text-muted" style="font-size: 20px;">person</span>
                                @endif
                            </div>
                            <span class="fw-bold text-dark">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td dir="ltr">{{ $user->username }}</td>
                    <td>
                        <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $user->role->name ?? 'بلا صلاحية' }}</span>
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success px-3 py-2 rounded-pill">نشط</span>
                        @else
                            <span class="badge bg-danger px-3 py-2 rounded-pill">موقوف</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            @if(!(auth()->user()->role->name === 'Mod' && $user->role->name === 'Admin'))
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-light text-warning border" title="تعديل"><span class="material-symbols-outlined fs-6">edit</span></a>
                            @endif
                            @if(auth()->id() !== $user->id && !(auth()->user()->role->name === 'Mod' && in_array($user->role->name, ['Admin', 'Mod'])))
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger border" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذا الحساب نهائياً؟')"><span class="material-symbols-outlined fs-6">delete</span></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-muted py-4">لا يوجد مستخدمين.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
