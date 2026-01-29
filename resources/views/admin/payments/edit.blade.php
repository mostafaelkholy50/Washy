@extends('layouts.admin')

@section('title', 'تعديل دفعة')

@section('content')
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">تعديل دفعة #{{ $payment->id }}</h3>
        </div>
        <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="customer_id">العميل <span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_id"
                                class="form-control @error('customer_id') is-invalid @enderror" required>
                                <option value="">اختر العميل...</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id', $payment->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->phone_whatsapp ?? $customer->phone ?? '—' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="date">التاريخ <span class="text-danger">*</span></label>
                            <input 
                                type="date" 
                                name="date" 
                                id="date" 
                                class="form-control @error('date') is-invalid @enderror" 
                                value="{{ old('date', $payment->date->format('Y-m-d')) }}" 
                                required
                            >
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="amount">المبلغ <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="amount"
                                class="form-control @error('amount') is-invalid @enderror" id="amount"
                                value="{{ old('amount', $payment->amount) }}" required>
                            @error('amount')
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
                                    <option value="{{ $currency->id }}" 
                                        {{ old('currency_id', $payment->currency_id) == $currency->id ? 'selected' : '' }}>
                                        {{ $currency->name }} ({{ $currency->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('currency_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="payment_method">طريقة الدفع <span class="text-danger">*</span></label>
                            <select name="payment_method" id="payment_method"
                                class="form-control @error('payment_method') is-invalid @enderror" required>
                                <option value="">اختر طريقة الدفع...</option>
                                <option value="كاش" {{ old('payment_method', $payment->payment_method) == 'كاش' ? 'selected' : '' }}>كاش</option>
                                <option value="كريديت" {{ old('payment_method', $payment->payment_method) == 'كريديت' ? 'selected' : '' }}>كريديت</option>
                                <option value="تحويل" {{ old('payment_method', $payment->payment_method) == 'تحويل' ? 'selected' : '' }}>تحويل</option>
                                <option value="بونص" {{ old('payment_method', $payment->payment_method) == 'بونص' ? 'selected' : '' }}>بونص</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="note">ملاحظات</label>
                            <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note"
                                rows="3">{{ old('note', $payment->note) }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-warning">تحديث الدفعة</button>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-default float-end">إلغاء</a>
            </div>
        </form>
    </div>
    @push('scripts')
<script>
    flatpickr("#date", {
        dateFormat: "Y-m-d",
     });
</script>
@endpush
@endsection
