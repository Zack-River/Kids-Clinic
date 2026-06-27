@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">الحسابات</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">الحسابات</li>
        </ol>
    </nav>
</div>

<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
    <a href="{{ route('accounts.create') }}" class="btn btn-primary-custom px-4 d-flex align-items-center justify-content-center gap-2">
        <span class="material-symbols-outlined fs-5">add</span>
        إضافة معاملة
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
        <span class="material-symbols-outlined text-muted">account_balance_wallet</span>
        <h6 class="mb-0 fw-bold">سجل المعاملات</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center text-nowrap">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="py-3">التاريخ</th>
                    <th scope="col" class="py-3">البيان</th>
                    <th scope="col" class="py-3">النوع</th>
                    <th scope="col" class="py-3">المبلغ</th>
                    <th scope="col" class="py-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @forelse ($accounts as $account)
                <tr>
                    <td>{{ $account->transaction_date->format('Y-m-d') }}</td>
                    <td class="fw-medium">{{ $account->title }}</td>
                    <td>
                        @if($account->type === 'income')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">إيراد</span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">مصروف</span>
                        @endif
                    </td>
                    <td class="fw-bold" dir="ltr">{{ number_format($account->amount, 2) }}</td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('accounts.edit', $account) }}" class="btn btn-sm btn-light text-warning border" title="تعديل"><span class="material-symbols-outlined fs-6">edit</span></a>
                            <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger border" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟')"><span class="material-symbols-outlined fs-6">delete</span></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-muted py-4">لا توجد معاملات مسجلة حتى الآن.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($accounts->hasPages())
    <div class="card-footer bg-white border-top p-3">
        {{ $accounts->links() }}
    </div>
    @endif
</div>
@endsection
