@extends('layouts.admin')

@section('title', 'إضافة عملة جديدة')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title fw-bold">إضافة عملة جديدة</h3>
                </div>
                <form action="{{ route('admin.currencies.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">اسم العملة <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control rounded-3 @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="مثال: جنيه مصري" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="code" class="form-label">كود العملة (ISO) <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="code" id="code"
                                    class="form-control rounded-3 @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}" placeholder="مثال: EGP" required>
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
                                    value="{{ old('symbol') }}" placeholder="مثال: £ أو ج.م">
                                @error('symbol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_favorite" id="is_favorite" value="1" {{ old('is_favorite') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_favorite">تعيين كعملة افتراضية</label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">العملة نشطة</label>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-end">
                        <a href="{{ route('admin.currencies.index') }}" class="btn btn-light rounded-pill px-4">إلغاء</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">حفظ العملة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection