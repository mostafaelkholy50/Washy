@extends('layouts.admin')

@section('title', 'إضافة منتج')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">إضافة منتج جديد</h3>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name">اسم المنتج <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="type">نوع المنتج</label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" id="type">
                                <option value="" disabled selected>اختر نوع المنتج</option>
                                <option value="غسيل" {{ old('type') == 'غسيل' ? 'selected' : '' }}>غسيل</option>
                                <option value="كيّ" {{ old('type') == 'كيّ' ? 'selected' : '' }}>كيّ</option>
                                <option value="غسيل/كيّ" {{ old('type') == 'غسيل/كيّ' ? 'selected' : '' }}>غسيل/كيّ</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="price">السعر <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price"
                                class="form-control @error('price') is-invalid @enderror" id="price"
                                value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="currency_id">العملة <span class="text-danger">*</span></label>
                            <select name="currency_id" id="currency_id"
                                class="form-control @error('currency_id') is-invalid @enderror" required>
                                <option value="">اختر العملة</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" {{ old('currency_id', $favoriteCurrency->id ?? '') == $currency->id ? 'selected' : '' }}>
                                        {{ $currency->name }} ({{ $currency->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('currency_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="note">ملاحظات</label>
                            <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note"
                                rows="3">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">حفظ المنتج</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-default float-end">إلغاء</a>
            </div>
        </form>
    </div>
@endsection