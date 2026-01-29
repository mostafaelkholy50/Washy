@extends('layouts.admin')

@section('title', 'تعديل العملة: ' . $currency->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-warning card-outline shadow-sm">

            <div class="card-header bg-white">
                <h3 class="card-title fw-bold">تعديل العملة</h3>
            </div>

            <form id="update-form" action="{{ route('admin.currencies.update', $currency->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">
                                اسم العملة <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                   class="form-control rounded-3 @error('name') is-invalid @enderror"
                                   value="{{ old('name', $currency->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="code" class="form-label">
                                كود العملة (ISO) <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="code" id="code"
                                   class="form-control rounded-3 @error('code') is-invalid @enderror"
                                   value="{{ old('code', $currency->code) }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="symbol" class="form-label">الرمز</label>
                            <input type="text" name="symbol" id="symbol"
                                   class="form-control rounded-3 @error('symbol') is-invalid @enderror"
                                   value="{{ old('symbol', $currency->symbol) }}">
                            @error('symbol')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox"
                               name="is_favorite" id="is_favorite" value="1"
                               {{ old('is_favorite', $currency->is_favorite) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_favorite">
                            تعيين كعملة افتراضية
                        </label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox"
                               name="is_active" id="is_active" value="1"
                               {{ old('is_active', $currency->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            العملة نشطة
                        </label>
                    </div>
                </div>
            </form>

            <div class="card-footer bg-white d-flex justify-content-between align-items-center gap-3">

                <div style="margin-left: auto;">
                    @if(!$currency->is_favorite)
                        <form action="{{ route('admin.currencies.destroy', $currency->id) }}"
                              method="POST"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذه العملة؟\nهذا الإجراء لا يمكن التراجع عنه.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-pill px-4 py-2">
                                <i class="bi bi-trash3 me-2"></i> حذف العملة
                            </button>
                        </form>
                    @endif
                </div>

                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.currencies.index') }}"
                       class="btn btn-light border rounded-pill px-5 py-2">
                        إلغاء
                    </a>

                    <button type="submit"
                            form="update-form"
                            class="btn btn-warning rounded-pill px-5 py-2 fw-semibold">
                        <i class="bi bi-check2-circle me-2"></i>تحديث العملة
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
