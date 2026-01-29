@extends('layouts.admin')

@section('title', 'إضافة عميل')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">إضافة عميل جديد</h3>
        </div>
        <form action="{{ route('admin.customers.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name">الاسم الكامل <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="phone_whatsapp">رقم الواتساب</label>
                            <input type="text" name="phone_whatsapp"
                                class="form-control @error('phone_whatsapp') is-invalid @enderror" id="phone_whatsapp"
                                value="{{ old('phone_whatsapp') }}">
                            @error('phone_whatsapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="phone">رقم الموبايل</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="area">المنطقة</label>
                            <input type="text" name="area" class="form-control @error('area') is-invalid @enderror"
                                id="area" value="{{ old('area') }}">
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="piece">القطعة</label>
                            <input type="text" name="piece" class="form-control @error('piece') is-invalid @enderror"
                                id="piece" value="{{ old('piece') }}">
                            @error('piece')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="street">الشارع</label>
                            <input type="text" name="street" class="form-control @error('street') is-invalid @enderror"
                                id="street" value="{{ old('street') }}">
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="house_number">رقم المنزل</label>
                            <input type="text" name="house_number"
                                class="form-control @error('house_number') is-invalid @enderror" id="house_number"
                                value="{{ old('house_number') }}">
                            @error('house_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="currency_id">العملة المفضلة <span class="text-danger">*</span></label>
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
                            <label for="notes">ملاحظات</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="notes"
                                rows="3" required>{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">حفظ العميل</button>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-default float-end">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
