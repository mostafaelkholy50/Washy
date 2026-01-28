@extends('layouts.admin')

@section('title', 'إدارة الطلبات')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">قائمة الطلبات</h3>
            <div class="card-tools">
                <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm">
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
                            <th>رقم الطلب</th>
                            <th>التاريخ</th>
                            <th>العميل</th>
                            <th>الإجمالي</th>
                            <th>النوع</th>
                            <th>الرصيد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="view-trigger" data-view-url="{{ route('admin.orders.show', $order->id) }}"
                                    data-view-title="تفاصيل الطلب #{{ $order->id }}" style="cursor: pointer;">
                                    {{ $loop->iteration }}</td>
                                <td >#{{ $order->id }}</td>
                                <td>{{ $order->date->format('Y-m-d') }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ number_format($order->total, 2) }} {{ $order->currency }}</td>
                                <td><span class="badge badge-info text-black">{{ $order->type ?? 'عادي' }}</span></td>
                                <td>{{ $order->currency }} {{ $order->customer->balance?->amount ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">لا يوجد طلبات حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
