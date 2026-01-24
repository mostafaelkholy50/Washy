@extends('layouts.admin')

@section('title', 'إدارة الطلبات')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">قائمة الطلبات</h3>
            <div class="card-tools">
                <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> إضافة طلب جديد
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 1%">#</th>
                            <th>التاريخ</th>
                            <th>العميل</th>
                            <th>الإجمالي</th>
                            <th>النوع</th>
                            <th style="width: 20%">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->date->format('Y-m-d') }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ number_format($order->total, 2) }} ج</td>
                                <td><span class="badge badge-info text-black">{{ $order->type ?? 'عادي' }}</span></td>
                                <td class="project-actions text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('هل أنت متأكد من حذف الطلب؟ سيتم استرداد المبلغ للعميل')">
                                            <i class="bi bi-trash"></i> حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">لا يوجد طلبات حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection