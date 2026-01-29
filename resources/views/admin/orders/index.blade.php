@extends('layouts.admin')

@section('title', 'إدارة الطلبات')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header border-bottom-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="card-title fw-bold text-primary">قائمة الطلبات</h3>
                <a href="{{ route('admin.orders.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> إضافة طلب جديد
                </a>
            </div>

            <form action="{{ route('admin.orders.index') }}" method="GET" class="bg-light p-3 rounded-3 mb-2">
                <div class="row g-2">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="رقم الطلب أو العميل..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="bi bi-calendar3 text-muted"></i></span>
                            <input type="text" name="date" id="filter_date" class="form-control border-start-0 ps-0"
                                placeholder="التاريخ..." value="{{ request('date') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="type" class="form-select">
                            <option value="">كل الأنواع</option>
                            @foreach($orderTypes as $type)
                                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill">تصفية</button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-pill"
                                title="إعادة تعيين"><i class="bi bi-arrow-clockwise"></i></a>
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
                            <th style="cursor: pointer;"
                                onclick="window.location='{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}'">
                                رقم الطلب <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th style="cursor: pointer;"
                                onclick="window.location='{{ request()->fullUrlWithQuery(['sort' => 'date', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}'">
                                التاريخ <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th>العميل</th>
                            <th style="cursor: pointer;"
                                onclick="window.location='{{ request()->fullUrlWithQuery(['sort' => 'total', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}'">
                                الإجمالي <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th>النوع</th>
                            <th>رصيد العميل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="ps-4 view-trigger" data-view-url="{{ route('admin.orders.show', $order->id) }}"
                                    data-view-title="تفاصيل الطلب #{{ $order->id }}" style="cursor: pointer;">
                                    {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                                </td>
                                <td><span class="badge bg-light text-dark border fw-bold px-3">#{{ $order->id }}</span></td>
                                <td class="text-muted">{{ $order->date->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.customers.show', $order->customer->id) }}"
                                        class="text-decoration-none fw-bold text-dark">
                                        {{ $order->customer->name }}
                                    </a>
                                </td>
                                <td class="fw-bold text-primary">
                                    {{ number_format($order->total, 2) }}
                                    <small>{{ $order->currency_rel->code ?? $order->currency }}</small>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 rounded-pill">
                                        {{ $order->type ?? 'عادي' }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge {{ ($order->customer->balance?->amount ?? 0) < 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} rounded-pill px-3">
                                        {{ number_format($order->customer->balance?->amount ?? 0, 2) }}
                                        {{ $order->currency_rel->code ?? $order->currency }}
                                    </span>
                                </td>
                               
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-cart-x display-4 mb-3 d-block"></i>
                                        <p class="fs-5">لا يوجد طلبات تطابق هذا البحث</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
            <div class="card-footer bg-white border-top-0 pt-3">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            flatpickr("#filter_date", {
                dateFormat: "Y-m-d",
                allowInput: true
            });
        </script>
    @endpush
@endsection