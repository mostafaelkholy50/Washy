@extends('layouts.admin')

@section('title', 'الأرصدة')

@section('content')
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header border-bottom-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="card-title fw-bold text-primary">نظرة عامة على أرصدة العملاء</h3>
                <a href="{{ route('admin.customers.index') }}"
                    class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> العودة لقائمة العملاء
                </a>
            </div>

            <form action="{{ route('admin.balances.index') }}" method="GET" class="bg-light p-3 rounded-3 mb-2">
                <div class="row g-2">
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="بحث باسم العميل..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill">بحث</button>
                            <a href="{{ route('admin.balances.index') }}" class="btn btn-outline-secondary rounded-pill"
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
                                onclick="window.location='{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}'">
                                اسم العميل <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th class="text-center" style="cursor: pointer;"
                                onclick="window.location='{{ request()->fullUrlWithQuery(['sort' => 'balance', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}'">
                                الرصيد الحالي <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th class="text-center">العملة</th>
                            <th class="text-center">الحالة</th>
                            <th>آخر ملاحظة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">
                                    {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.customers.show', $customer->id) }}"
                                        class="text-dark fw-bold text-decoration-none">
                                        {{ $customer->name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <h5
                                        class="mb-0 fw-bold {{ $customer->balance && $customer->balance->amount < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $customer->balance ? number_format($customer->balance->amount, 2) : '0.00' }}
                                    </h5>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-bold">
                                        {{ $customer->balance->currency ?? $customer->preferred_currency ?? 'غير محدد' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($customer->balance)
                                        @if($customer->balance->amount < 0)
                                            <span class="badge bg-danger rounded-pill px-3">مديونية</span>
                                        @elseif($customer->balance->amount > 0)
                                            <span class="badge bg-success rounded-pill px-3">رصيد متاح</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3">صفر</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3">لا يوجد رصيد</span>
                                    @endif
                                </td>
                                <td class="text-muted small">
                                    {{ Str::limit($customer->balance->note ?? '—', 40) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-wallet2 display-4 d-block mb-3 opacity-25"></i>
                                    لا يوجد عملاء يطابقون هذا البحث
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
