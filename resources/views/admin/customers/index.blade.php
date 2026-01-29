@extends('layouts.admin')

@section('title', 'العملاء')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header border-bottom-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="card-title fw-bold text-primary">إدارة العملاء</h3>
                <a href="{{ route('admin.customers.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> إضافة
                </a>
            </div>

            <form action="{{ route('admin.customers.index') }}" method="GET" class="bg-light p-3 rounded-3 mb-2">
                <div class="row g-2">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="بحث بالاسم، الرقم، أو المنطقة..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="currency_id" class="form-select">
                            <option value="">كل العملات</option>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}" {{ request('currency_id') == $currency->id ? 'selected' : '' }}>
                                    {{ $currency->name }} ({{ $currency->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="sort" class="form-select">
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>الأحدث</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>الاسم</option>
                            <option value="area" {{ request('sort') == 'area' ? 'selected' : '' }}>المنطقة</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill">تصفية</button>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary rounded-pill" title="إعادة تعيين"><i class="bi bi-arrow-clockwise"></i></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="ps-4">#</th>
                            <th style="cursor: pointer;" onclick="window.location='{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}'">
                                الاسم <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th>واتساب</th>
                            <th>الموبايل</th>
                            <th style="cursor: pointer;" onclick="window.location='{{ request()->fullUrlWithQuery(['sort' => 'area', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}'">
                                المنطقة <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th class="text-center">الرصيد</th>
                            <th>العملة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td class="ps-4 view-trigger" data-view-url="{{ route('admin.customers.show', $customer->id) }}"
                                    data-view-title="ملف العميل: {{ $customer->name }}" style="cursor: pointer;">
                                    {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                                </td>
                                <td class="fw-bold text-dark">{{ $customer->name }}</td>
                                <td>{{ $customer->phone_whatsapp ?? '—' }}</td>
                                <td>{{ $customer->phone ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $customer->area ?? '—' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $customer->balance->amount < 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} px-3 py-2 rounded-pill fs-6">
                                        {{ number_format($customer->balance->amount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted small fw-bold">{{ $customer->currency->code ?? $customer->preferred_currency }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-people display-4 mb-3 d-block"></i>
                                        <p class="fs-5">لا يوجد عملاء يطابقون هذا البحث</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($customers->hasPages())
        <div class="card-footer bg-white border-top-0 pt-3">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
@endsection
