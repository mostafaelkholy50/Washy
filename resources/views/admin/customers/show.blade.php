@extends('layouts.admin')

@section('title', 'ملف العميل: ' . $customer->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <i class="bi bi-person-circle display-1 text-secondary"></i>
                    </div>
                    <h3 class="profile-username text-center">{{ $customer->name }}</h3>
                    <p class="text-muted text-center">عميل المصبغة</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>رقم الهاتف</b> <a class="float-end text-decoration-none">{{ $customer->phone ?? '—' }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>واتساب</b> <a class="float-end text-decoration-none text-success" href="https://wa.me/{{ $customer->phone_whatsapp }}" target="_blank">
                                {{ $customer->phone_whatsapp ?? '—' }} <i class="bi bi-whatsapp"></i>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>العنوان</b> <span class="float-end small text-muted text-wrap text-end" style="max-width: 60%;">
                                {{ implode(' - ', array_filter([$customer->area, $customer->street, "م: ".$customer->house_number])) ?: 'غير مسجل' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card {{ $customer->balance->amount >= 0 ? 'card-success' : 'card-danger' }} card-outline">
                <div class="card-header">
                    <h3 class="card-title">حالة الرصيد الحالي</h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-5 font-weight-bold {{ $customer->balance->amount >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ number_format($customer->balance->amount, 2) }} <small>ج.م</small>
                    </h1>
                    @if($customer->balance->amount < 0)
                        <span class="badge bg-danger">عليه مديونية للمصبغة</span>
                    @else
                        <span class="badge bg-success">رصيد متاح</span>
                    @endif
                    <p class="text-muted mt-3 mb-0 small">
                        <i class="bi bi-info-circle"></i> آخر ملاحظة: {{ $customer->balance->note ?? 'لا يوجد' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#orders" data-bs-toggle="tab">الطلبات (الواتير)</a></li>
                        <li class="nav-item"><a class="nav-link" href="#payments" data-bs-toggle="tab">المدفوعات</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="orders">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>رقم الطلب</th>
                                            <th>التاريخ</th>
                                            <th>الأصناف</th>
                                            <th>الإجمالي</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customer->orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->date->format('Y-m-d') }}</td>
                                            <td>
                                                @foreach($order->items as $item)
                                                    <span class="badge bg-light text-dark border">
                                                        {{ $item->product->name }} ({{ $item->quantity }})
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td class="fw-bold">{{ number_format($order->total, 2) }} ج</td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info text-white">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="5" class="text-center text-muted">لا توجد طلبات سابقة</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane" id="payments">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>التاريخ</th>
                                            <th>المبلغ</th>
                                            <th>الطريقة</th>
                                            <th>ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customer->payments as $payment)
                                        <tr>
                                            <td>{{ $payment->date->format('Y-m-d') }}</td>
                                            <td class="text-success fw-bold">+ {{ number_format($payment->amount, 2) }} ج</td>
                                            <td><span class="badge bg-secondary">{{ $payment->payment_method }}</span></td>
                                            <td>{{ $payment->note ?? '—' }}</td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center text-muted">لا توجد دفعات مسجلة</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right"></i> رجوع للقائمة
                </a>
                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> تعديل البيانات
                </a>
            </div>
        </div>
    </div>
</div>
@endsection