@extends('layouts.admin')

@section('title', 'تعديل بيانات العميل')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">تعديل بيانات العميل: {{ $customer->name }}</h3>
        </div>

        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row">

                    <!-- الاسم -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name">الاسم الكامل <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $customer->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- رقم الواتساب -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="phone_whatsapp">رقم الواتساب</label>
                            <input type="text" name="phone_whatsapp" id="phone_whatsapp"
                                class="form-control @error('phone_whatsapp') is-invalid @enderror"
                                value="{{ old('phone_whatsapp', $customer->phone_whatsapp) }}">
                            @error('phone_whatsapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- رقم الموبايل العادي -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="phone">رقم الموبايل</label>
                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $customer->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- الشارع -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="street">الشارع</label>
                            <input type="text" name="street" id="street"
                                class="form-control @error('street') is-invalid @enderror"
                                value="{{ old('street', $customer->street) }}">
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- المنطقة -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="area">المنطقة</label>
                            <input type="text" name="area" id="area"
                                class="form-control @error('area') is-invalid @enderror"
                                value="{{ old('area', $customer->area) }}">
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- القطعة -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="piece">القطعة</label>
                            <input type="text" name="piece" id="piece"
                                class="form-control @error('piece') is-invalid @enderror"
                                value="{{ old('piece', $customer->piece) }}">
                            @error('piece')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- رقم المنزل -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="house_number">رقم المنزل</label>
                            <input type="text" name="house_number" id="house_number"
                                class="form-control @error('house_number') is-invalid @enderror"
                                value="{{ old('house_number', $customer->house_number) }}">
                            @error('house_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="preferred_currency">العملة المفضلة <span class="text-danger">*</span></label>
                            <select name="preferred_currency" id="preferred_currency"
                                class="form-control @error('preferred_currency') is-invalid @enderror" required>
                                <option value="EGP" {{ old('preferred_currency', $customer->preferred_currency) == 'EGP' ? 'selected' : '' }}>جنيه مصري (EGP)</option>
                                <option value="USD" {{ old('preferred_currency', $customer->preferred_currency) == 'USD' ? 'selected' : '' }}>دولار أمريكي (USD)</option>
                                <option value="KWD" {{ old('preferred_currency', $customer->preferred_currency) == 'KWD' ? 'selected' : '' }}>دينار كويتي (KWD)</option>
                                <option value="SAR" {{ old('preferred_currency', $customer->preferred_currency) == 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                                <option value="AED" {{ old('preferred_currency', $customer->preferred_currency) == 'AED' ? 'selected' : '' }}>درهم إماراتي (AED)</option>
                            </select>
                            @error('preferred_currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- الملاحظات -->
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="notes">ملاحظات إضافية</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $customer->notes) }}</textarea>
                            @error('notes')
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
                <a href="{{ route('admin.customers.index') }}" class="btn btn-default float-end">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection