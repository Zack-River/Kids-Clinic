@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">تعديل حساب المستخدم</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none text-muted">المستخدمين</a></li>
            <li class="breadcrumb-item active" aria-current="page">تعديل مستخدم</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-xl-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-light border-bottom px-4 py-3 d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-muted">manage_accounts</span>
                <h6 class="mb-0 fw-bold">تحديث بيانات الحساب: {{ $user->name }}</h6>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">الاسم الكامل <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="username" class="form-label fw-bold">اسم المستخدم (للدخول) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" dir="ltr" required>
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="role_id" class="form-label fw-bold">صلاحية الحساب <span class="text-danger">*</span></label>
                            <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold ms-2" for="is_active">الحساب مفعل (يسمح بتسجيل الدخول)</label>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <hr>
                            <h6 class="fw-bold mb-3 text-danger"><span class="material-symbols-outlined fs-6 align-middle me-1">lock_reset</span> تغيير كلمة المرور (اختياري)</h6>
                            <p class="text-muted small">اترك الحقول فارغة إذا كنت لا تريد تغيير كلمة المرور الحالية.</p>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="password" class="form-label fw-bold">كلمة المرور الجديدة</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" dir="ltr">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="password_confirmation" class="form-label fw-bold">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" dir="ltr">
                        </div>

                        <div class="col-12 text-start mt-5">
                            <button type="submit" class="btn btn-primary-custom px-5 py-2 fw-bold">حفظ التعديلات</button>
                            <a href="{{ route('users.index') }}" class="btn btn-light border px-4 py-2 ms-2 text-muted fw-bold">إلغاء</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
