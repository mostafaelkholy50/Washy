@extends('layouts.admin')

@section('title', 'المدفوعات')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header border-bottom-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="card-title fw-bold text-primary">إدارة المدفوعات</h3>
                <div>
                    <a href="{{ request()->fullUrlWithQuery(['print' => 1]) }}" target="_blank"
                        class="btn btn-secondary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-printer me-1"></i> طباعة الكل
                    </a>
                    <a href="{{ route('admin.payments.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm ms-2">
                        <i class="bi bi-plus-lg me-1"></i> إضافة
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.payments.index') }}" method="GET" class="bg-light p-3 rounded-3 mb-2">
                <div class="row g-2">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="اسم العميل..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="bi bi-calendar3 text-muted"></i></span>
                            <input type="text" name="date" id="payment_date" class="form-control border-start-0 ps-0"
                                placeholder="التاريخ..." value="{{ request('date') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="method" class="form-select">
                            <option value="">كل الطرق</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method }}" {{ request('method') == $method ? 'selected' : '' }}>{{ $method }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill">تصفية</button>
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary rounded-pill"
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
                                الرقم <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th>العميل</th>
                            <th style="cursor: pointer;"
                                onclick="window.location='{{ request()->fullUrlWithQuery(['sort' => 'date', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}'">
                                التاريخ <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th style="cursor: pointer;"
                                onclick="window.location='{{ request()->fullUrlWithQuery(['sort' => 'amount', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}'">
                                المبلغ <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th>طريقة الدفع</th>
                            <th>رصيد العميل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td class="ps-4 view-trigger" data-view-url="{{ route('admin.payments.show', $payment->id) }}"
                                    data-view-title="تفاصيل الدفعة" style="cursor: pointer;">
                                    {{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}
                                </td>
                                <td><span class="badge bg-light text-dark border px-3">#{{ $payment->id }}</span></td>
                                <td class="fw-bold text-dark">{{ $payment->customer->name ?? '—' }}</td>
                                <td class="text-muted">{{ $payment->date->format('Y-m-d') }}</td>
                                <td class="fw-bold text-success">
                                    {{ number_format($payment->amount, 2) }}
                                    <small>{{ $payment->currency_rel->code ?? $payment->currency }}</small>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                        {{ $payment->payment_method }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge {{ ($payment->customer->balance?->amount ?? 0) < 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} rounded-pill px-3">
                                        {{ number_format($payment->customer->balance?->amount ?? 0, 2) }}
                                        {{ $payment->currency_rel->code ?? $payment->currency }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-cash-stack display-4 mb-3 d-block"></i>
                                        <p class="fs-5">لا يوجد مدفوعات تطابق هذا البحث</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($payments->hasPages())
            <div class="card-footer bg-white border-top-0 pt-3">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            flatpickr("#payment_date", {
                dateFormat: "Y-m-d",
                allowInput: true
            });
        </script>
    @endpush
@endsection