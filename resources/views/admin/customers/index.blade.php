@extends('layouts.admin')

@section('title', 'العملاء')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">إدارة العملاء</h3>
            <div class="card-tools">
                <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> إضافة عميل
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 1%">#</th>
                            <th>الاسم</th>
                            <th>واتساب</th>
                            <th>الموبايل</th>
                            <th>العنوان</th>
                            <th>العملة</th>
                            <th style="width: 20%">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr onclick="window.location='{{ route('admin.customers.edit', $customer->id) }}';"
                                style="cursor: pointer;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone_whatsapp ?? '—' }}</td>
                                <td>{{ $customer->phone ?? '—' }}</td>
                                <td>
                                    {{ $customer->street }} - {{ $customer->area }}
                                    @if($customer->house_number)
                                        - منزل {{ $customer->house_number }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $customer->preferred_currency }}</span>
                                </td>
                                <td class="project-actions text-right">
                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="event.stopPropagation(); return confirm('هل أنت متأكد من حذف العميل {{ $customer->name }}؟')">
                                            <i class="bi bi-trash"></i> حذف
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> عرض التفاصيل
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">لا يوجد عملاء حتى الآن</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection