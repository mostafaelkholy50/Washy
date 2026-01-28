@extends('layouts.admin')

@section('title', 'ملف العميل: ' . $customer->name)

@section('content')
  <div class="container-fluid" id="modal-content-area">

    <div class="row">

        <div class="col-lg-4 col-xl-3">
            <div class="{{ request()->ajax() ? '' : 'sticky-top' }}" style="{{ request()->ajax() ? '' : 'top: 20px; z-index: 10;' }}">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-body box-profile">
                        <div class="text-center mb-4">
                            <div class="avatar-circle mx-auto bg-light d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border-radius: 50%;">
                                <i class="bi bi-person-circle display-4 text-primary"></i>
                            </div>
                        </div>
                        <h3 class="profile-username text-center fw-bold">{{ $customer->name }}</h3>
                        <p class="text-muted text-center mb-4">عميل المصبغة</p>

                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="text-muted"><i class="bi bi-telephone-fill me-2"></i> الهاتف</span>
                                <span class="fw-bold">{{ $customer->phone ?? '—' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="text-muted"><i class="bi bi-whatsapp me-2"></i> واتساب</span>
                                <a class="text-decoration-none text-success fw-bold" href="https://wa.me/{{ $customer->phone_whatsapp }}" target="_blank">
                                    {{ $customer->phone_whatsapp ?? '—' }} <i class="bi bi-whatsapp"></i>
                                </a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="text-muted"><i class="bi bi-geo-alt-fill me-2"></i> العنوان</span>
                                <span class="small text-muted text-wrap text-end" style="max-width: 60%;">
                                    {{ implode(' - ', array_filter([$customer->area, $customer->street, "م: " . $customer->house_number])) ?: 'غير مسجل' }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="text-muted"><i class="bi bi-currency-exchange me-2"></i> العملة المفضلة</span>
                                <span class="badge bg-secondary rounded-pill px-3">{{ $customer->preferred_currency }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card shadow-sm border-0 {{ $customer->balance->amount >= 0 ? 'bg-success-subtle' : 'bg-danger-subtle' }} mt-4">
                    <div class="card-body text-center py-4">
                        <h6 class="text-uppercase fw-bold text-muted mb-3">حالة الرصيد الحالي</h6>
                        <h2 class="display-6 fw-bold mb-2 {{ $customer->balance->amount >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($customer->balance->amount, 2) }}
                            <small class="fs-6">{{ $customer->balance->currency }}</small>
                        </h2>
                        @if($customer->balance->amount < 0)
                            <span class="badge bg-danger rounded-pill px-3 py-2">عليه مديونية للمصبغة</span>
                        @else
                            <span class="badge bg-success rounded-pill px-3 py-2">رصيد متاح</span>
                        @endif
                        <p class="text-muted mt-4 mb-0 small opacity-75">
                            <i class="bi bi-info-circle me-1"></i> آخر ملاحظة: {{ $customer->balance->note ?? 'لا يوجد' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-xl-9 {{ request()->ajax() ? 'mt-4 mt-lg-0' : 'mt-4 mt-lg-0' }}">
            <div class="card shadow-sm">
                <div class="card-header bg-white p-3">
                    <ul class="nav nav-pills custom-pills">
                        <li class="nav-item"><a class="nav-link active rounded-pill px-4" href="#orders" data-bs-toggle="tab">الطلبات (الواتير)</a></li>
                        <li class="nav-item"><a class="nav-link rounded-pill px-4" href="#payments" data-bs-toggle="tab">المدفوعات</a></li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">
                        <!-- تبويب الطلبات -->
                        <div class="active tab-pane" id="orders">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">رقم الطلب</th>
                                            <th>التاريخ</th>
                                            <th>الأصناف</th>
                                            <th>الإجمالي</th>
                                            <th class="text-center">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customer->orders as $order)
                                            <tr>
                                                <td class="ps-4 fw-bold text-primary">#{{ $order->id }}</td>
                                                <td>{{ $order->date->format('Y-m-d') }}</td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($order->items as $item)
                                                            <span class="badge bg-light text-dark border-0 shadow-sm py-1">
                                                                {{ $item->product->name }} <span class="text-primary fs-xs">({{ $item->quantity }})</span>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="fw-bold">{{ number_format($order->total, 2) }} {{ $order->currency }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-light border-0 shadow-sm text-primary rounded-circle" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bi bi-inbox display-6 d-block mb-3 opacity-25"></i> لا توجد طلبات سابقة
                                            </td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- تبويب المدفوعات -->
                        <div class="tab-pane" id="payments">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">التاريخ</th>
                                            <th>المبلغ</th>
                                            <th>الطريقة</th>
                                            <th>ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customer->payments as $payment)
                                            <tr>
                                                <td class="ps-4">{{ $payment->date->format('Y-m-d') }}</td>
                                                <td class="text-success fw-bold">+ {{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
                                                <td><span class="badge bg-info-subtle text-info border-0 rounded-pill px-3">{{ $payment->payment_method }}</span></td>
                                                <td class="text-muted small">{{ $payment->note ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center py-5 text-muted">
                                                <i class="bi bi-cash display-6 d-block mb-3 opacity-25"></i> لا توجد دفعات مسجلة
                                            </td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-light rounded-pill px-4">
                        <i class="bi bi-arrow-right me-1"></i> رجوع للقائمة
                    </a>
                    <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning rounded-pill px-4">
                        <i class="bi bi-pencil me-1"></i> تعديل البيانات
                    </a>
                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill px-4" onclick="return confirm('هل أنت متأكد من حذف العميل {{ $customer->name }}؟')">
                            <i class="bi bi-trash me-1"></i> حذف
                        </button>
                    </form>
                </div>
        </div>

    </div>
</div>

@if(request()->ajax())
<style>
    .modal-body-premium {
        padding: 1.5rem 1rem;
    }
    .sticky-top {
        position: relative !important;
        top: auto !important;
    }
    .card {
        margin-bottom: 1.5rem !important;
    }
    @media (min-width: 992px) {
        #modal-content-area .row > .col-lg-4 {
            padding-right: 1rem;
        }
        #modal-content-area .row > .col-lg-8 {
            padding-left: 1rem;
        }
    }
    @media (max-width: 991.98px) {
        .col-lg-4, .col-lg-8, .col-xl-3, .col-xl-9 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endif
@endsection