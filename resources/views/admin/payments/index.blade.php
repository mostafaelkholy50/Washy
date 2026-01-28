@extends('layouts.admin')

@section('title', 'المدفوعات')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">إدارة المدفوعات</h3>
            <div class="card-tools">
                <a href="{{ route('admin.payments.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> إضافة
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الرقم</th>
                            <th>العميل</th>
                            <th>التاريخ</th>
                            <th>المبلغ</th>
                            <th>طريقة الدفع</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr class="view-trigger" data-view-url="{{ route('admin.payments.show', $payment->id) }}"
                                data-view-title="تفاصيل الدفعة" style="cursor: pointer;">
                                <td>{{ $loop->iteration }}</td>
                                <td>#{{ $payment->id }}</td>
                                <td>{{ $payment->customer->name ?? '—' }}</td>
                                <td>{{ $payment->date->format('Y-m-d') }}</td>
                                <td>{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ $payment->note ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">لا يوجد مدفوعات حتى الآن</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
