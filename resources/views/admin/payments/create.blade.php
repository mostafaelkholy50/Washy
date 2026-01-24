@extends('layouts.admin')

@section('title', 'إضافة دفعة')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">إضافة دفعة جديدة</h3>
        </div>
        <form action="{{ route('admin.payments.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="customer_id">العميل <span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_id"
                                class="form-control @error('customer_id') is-invalid @enderror" required>
                                <option value="">اختر العميل...</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
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
            value="{{ old('date') }}" 
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
                                value="{{ old('amount') }}" required>
                            @error('amount')
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
                                <option value="كاش" {{ old('payment_method') == 'كاش' ? 'selected' : '' }}>كاش</option>
                                <option value="كريديت" {{ old('payment_method') == 'كريديت' ? 'selected' : '' }}>كريديت
                                </option>
                                <option value="تحويل" {{ old('payment_method') == 'تحويل' ? 'selected' : '' }}>تحويل</option>
                                <option value="بونص" {{ old('payment_method') == 'بونص' ? 'selected' : '' }}>بونص</option>
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
                                rows="3">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">حفظ الدفعة</button>
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