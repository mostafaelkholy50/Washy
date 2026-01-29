@extends('layouts.admin')

@section('title', 'إدارة العملات')

@section('content')
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header border-bottom-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="card-title fw-bold text-primary">إدارة العملات</h3>
                <a href="{{ route('admin.currencies.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> إضافة 
                </a>
            </div>

            <form action="{{ route('admin.currencies.index') }}" method="GET" class="bg-light p-3 rounded-3 mb-2">
                <div class="row g-2">
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="بحث باسم العملة أو الكود..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill">بحث</button>
                            <a href="{{ route('admin.currencies.index') }}" class="btn btn-outline-secondary rounded-pill"
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
                            <th>الاسم</th>
                            <th>الكود</th>
                            <th>الرمز</th>
                            <th>الحالة</th>
                            <th>الافتراضية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($currencies as $currency)
                            <tr class="{{ $currency->is_favorite ? 'bg-primary-subtle' : '' }}">
                                <td class="ps-4">{{ $loop->iteration }}</td>
                                <td class="fw-bold text-dark">{{ $currency->name }}</td>
                                <td><span
                                        class="badge bg-secondary-subtle text-secondary border px-3">{{ $currency->code }}</span>
                                </td>
                                <td class="fw-bold">{{ $currency->symbol ?? '—' }}</td>
                                <td>
                                    @if($currency->is_active)
                                        <span class="badge bg-success rounded-pill px-3">نشط</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3">غير نشط</span>
                                    @endif
                                </td>
                                <td>
                                    @if($currency->is_favorite)
                                        <span class="badge bg-primary rounded-pill px-3 shadow-sm border border-primary-subtle">
                                            <i class="bi bi-star-fill me-1"></i> افتراضية
                                        </span>
                                    @else
                                        <form action="{{ route('admin.currencies.favorite', $currency->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                title="تعيين كافتراضية">
                                                <i class="bi bi-star me-1"></i> تعيين
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="text-muted">
                                        <i class="bi bi-currency-exchange display-4 mb-3 d-block"></i>
                                        <p class="fs-5">لا توجد عملات تطابق هذا البحث</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection