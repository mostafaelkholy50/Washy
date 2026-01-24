@extends('layouts.admin')

@section('title', 'إضافة طلب جديد')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إضافة طلب جديد</h3>
    </div>

    <form action="{{ route('admin.orders.store') }}" method="POST" id="order-form">
        @csrf

        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>العميل <span class="text-danger">*</span></label>
                        <select name="customer_id" class="form-control" required>
                            <option value="">-- اختر العميل --</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} (رصيد: {{ number_format($c->balance->amount ?? 0, 2) }} ج)</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>التاريخ <span class="text-danger">*</span></label>
                        <input type="date" name="date"  id="date"  class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>نوع الطلب</label>
                <input type="text" name="type" class="form-control" placeholder="مثال: تسليم فوري">
            </div>

            <!-- المنتجات الديناميكية -->
            <div class="card card-outline card-secondary mt-4">
                <div class="card-header">
                    <h5>المنتجات</h5>
                </div>
                <div class="card-body" id="items-container">

                    <!-- صف فارغ أول مرة -->
                    <div class="item-row row mb-3 border-bottom pb-3">
                        <div class="col-md-5">
                            <label>المنتج</label>
                            <select name="items[0][product_id]" class="form-control product-select" required>
                                <option value="">-- اختر --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }} - {{ number_format($p->price, 2) }} ج</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label>الكمية</label>
                            <input type="number" name="items[0][quantity]" class="form-control quantity" min="1" value="1" required>
                        </div>
                        <div class="col-md-2">
                            <label>الإجمالي</label>
                            <input type="text" class="form-control subtotal" readonly>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-item">حذف</button>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="button" class="btn btn-success" id="add-item">+ إضافة منتج آخر</button>
                </div>
            </div>

            <div class="mt-4">
                <h4>الإجمالي الكلي: <span id="grand-total">0.00</span> جنيه</h4>
            </div>

            <div class="form-group mt-3">
                <label>ملاحظات</label>
                <textarea name="note" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">حفظ الطلب</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let itemIndex = 1;

    document.getElementById('add-item').addEventListener('click', function () {
        const container = document.getElementById('items-container');
        const newRow = document.createElement('div');
        newRow.className = 'item-row row mb-3 border-bottom pb-3';
        newRow.innerHTML = `
            <div class="col-md-5">
                <label>المنتج</label>
                <select name="items[${itemIndex}][product_id]" class="form-control product-select" required>
                    <option value="">-- اختر --</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }} - {{ number_format($p->price, 2) }} ج</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>الكمية</label>
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" min="1" value="1" required>
            </div>
            <div class="col-md-2">
                <label>الإجمالي</label>
                <input type="text" class="form-control subtotal" readonly>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-item">حذف</button>
            </div>
        `;
        container.appendChild(newRow);
        itemIndex++;
        attachEvents();
    });

    function attachEvents() {
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.onclick = function () {
                this.closest('.item-row').remove();
                calculateGrandTotal();
            };
        });

        document.querySelectorAll('.product-select, .quantity').forEach(el => {
            el.addEventListener('change', calculateSubtotal);
            el.addEventListener('input', calculateSubtotal);
        });
    }

    function calculateSubtotal() {
        const row = this.closest('.item-row');
        const select = row.querySelector('.product-select');
        const qty = row.querySelector('.quantity').value;
        const subtotalEl = row.querySelector('.subtotal');

        if (select.value && qty > 0) {
            const price = parseFloat(select.selectedOptions[0].dataset.price) || 0;
            const subtotal = price * qty;
            subtotalEl.value = subtotal.toFixed(2);
        } else {
            subtotalEl.value = '';
        }
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(el => {
            total += parseFloat(el.value) || 0;
        });
        document.getElementById('grand-total').textContent = total.toFixed(2);
    }

    // ربط الأحداث للصف الأول
    attachEvents();
</script>
<script>
    flatpickr("#date", {
        dateFormat: "Y-m-d",
     });
</script>
@endpush