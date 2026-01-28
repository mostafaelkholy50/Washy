@extends('layouts.admin')

@section('title', 'المنتجات')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">إدارة المنتجات</h3>
            <div class="card-tools">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> إضافة منتج
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المنتج</th>
                            <th>النوع</th>
                            <th>السعر</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="view-trigger" data-view-url="{{ route('admin.products.show', $product->id) }}"
                                data-view-title="تفاصيل المنتج: {{ $product->name }}" style="cursor: pointer;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->type ?? '—' }}</td>
                                <td>{{ number_format($product->price, 2) }} {{ $product->currency }}</td>
                                <td>{{ $product->note ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">لا يوجد منتجات حتى الآن</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
