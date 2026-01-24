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
                            <th style="width: 1%">#</th>
                            <th>العميل</th>
                            <th>التاريخ</th>
                            <th>المبلغ</th>
                            <th>طريقة الدفع</th>
                            <th>ملاحظات</th>
                            <th style="width: 20%">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr style="cursor: pointer;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->customer->name ?? '—' }}</td>
                                <td>{{ $payment->date->format('Y-m-d') }}</td>
                                <td>{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ $payment->note ?? '—' }}</td>
                                <td class="project-actions text-right">
                                    <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="event.stopPropagation(); return confirm('هل أنت متأكد من حذف هذه الدفعة؟')">
                                            <i class="bi bi-trash"></i> حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">لا يوجد مدفوعات حتى الآن</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection