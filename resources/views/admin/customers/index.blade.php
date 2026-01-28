@extends('layouts.admin')

@section('title', 'العملاء')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">إدارة العملاء</h3>
            <div class="card-tools">
                <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-sm">
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
                            <th>الاسم</th>
                            <th>واتساب</th>
                            <th>الموبايل</th>
                            <th>العنوان</th>
                            <th>الرصيد</th>
                            <th>العملة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td class="view-trigger" data-view-url="{{ route('admin.customers.show', $customer->id) }}"
                                    data-view-title="ملف العميل: {{ $customer->name }}" style="cursor: pointer;">
                                    {{ $loop->iteration }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone_whatsapp ?? '—' }}</td>
                                <td>{{ $customer->phone ?? '—' }}</td>
                                <td>
                                    {{ $customer->street }}
                                </td>
                                <td class="{{ $customer->balance->amount < 0 ? 'bg-danger' : 'bg-success' }}">
                                  {{ $customer->balance->amount }}
                                </td>
                                <td>
                                    {{ $customer->preferred_currency }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">لا يوجد عملاء حتى الآن</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
