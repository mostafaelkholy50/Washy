@extends('layouts.admin')

@section('title', 'المنتجات')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header border-bottom-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="card-title fw-bold text-primary">قائمة المنتجات</h3>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> إضافة
                </a>
            </div>

            <form action="{{ route('admin.products.index') }}" method="GET" class="bg-light p-3 rounded-3 mb-2">
                <div class="row g-2">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="اسم المنتج أو النوع..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="currency_id" class="form-select">
                            <option value="">كل العملات</option>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}" {{ request('currency_id') == $currency->id ? 'selected' : '' }}>{{ $currency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill">تصفية</button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill"
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
                                الاسم <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th style="cursor: pointer;"
                                onclick="window.location='{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}'">
                                السعر <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th style="cursor: pointer;"
                                onclick="window.location='{{ request()->fullUrlWithQuery(['sort' => 'type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}'">
                                النوع <i class="bi bi-arrow-down-up small ms-1 opacity-50"></i>
                            </th>
                            <th>العملة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="ps-4 view-trigger" data-view-url="{{ route('admin.products.show', $product->id) }}"
                                    data-view-title="تفاصيل المنتج" style="cursor: pointer;">
                                    {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                                </td>
                                <td class="fw-bold text-dark">{{ $product->name }}</td>
                                <td class="fw-bold text-success">
                                    {{ number_format($product->price, 2) }}
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3">{{ $product->type ?? '—' }}</span>
                                </td>
                                <td class="fw-bold text-muted small">
                                    {{ $product->currency_rel->code ?? $product->currency }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-box display-4 mb-3 d-block"></i>
                                        <p class="fs-5">لا يوجد منتجات تطابق هذا البحث</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
            <div class="card-footer bg-white border-top-0 pt-3">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
