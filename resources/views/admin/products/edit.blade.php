@extends('layouts.admin')

@section('title', 'تعديل المنتج')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">تعديل المنتج: {{ $product->name }}</h3>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name">اسم المنتج <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="type">نوع المنتج</label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" id="type">
                                <option value="" disabled {{ old('type', $product->type) ? '' : 'selected' }}>اختر نوع
                                    المنتج</option>
                                <option value="غسيل" {{ old('type', $product->type) == 'غسيل' ? 'selected' : '' }}>غسيل
                                </option>
                                <option value="كيّ" {{ old('type', $product->type) == 'كيّ' ? 'selected' : '' }}>كيّ</option>
                                <option value="غسيل/كيّ" {{ old('type', $product->type) == 'غسيل/كيّ' ? 'selected' : '' }}>
                                    غسيل/كيّ</option>
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
                                value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="currency">العملة <span class="text-danger">*</span></label>
                            <select name="currency" id="currency"
                                class="form-control @error('currency') is-invalid @enderror" required>
                                <option value="EGP" {{ old('currency', $product->currency) == 'EGP' ? 'selected' : '' }}>جنيه
                                    مصري (EGP)</option>
                                <option value="USD" {{ old('currency', $product->currency) == 'USD' ? 'selected' : '' }}>دولار
                                    أمريكي (USD)</option>
                                <option value="KWD" {{ old('currency', $product->currency) == 'KWD' ? 'selected' : '' }}>دينار
                                    كويتي (KWD)</option>
                                <option value="SAR" {{ old('currency', $product->currency) == 'SAR' ? 'selected' : '' }}>ريال
                                    سعودي (SAR)</option>
                                <option value="AED" {{ old('currency', $product->currency) == 'AED' ? 'selected' : '' }}>درهم
                                    إماراتي (AED)</option>
                            </select>
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="note">ملاحظات</label>
                            <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note"
                                rows="3">{{ old('note', $product->note) }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> حفظ التعديلات
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-default float-end">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection