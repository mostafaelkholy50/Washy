@extends('layouts.admin')

@section('title', 'الأعمال (Portfolios)')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إدارة الأعمال</h3>
        <div class="card-tools">
            <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> إضافة
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="width: 20%">الصورة</th>
                    <th>العنوان</th>
                    <th>القسم</th>
                    <th style="width: 20%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($portfolios as $portfolio)
                <tr onclick="window.location='{{ route('admin.portfolios.edit', $portfolio->id) }}';" style="cursor: pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($portfolio->image)
                        <img src="{{ asset($portfolio->image) }}" alt="Portfolio" class="img-fluid" style="max-height: 50px;">
                        @endif
                    </td>
                    <td>{{ $portfolio->title }}</td>
                    <td>{{ $portfolio->category ? $portfolio->category->name : '-' }}</td>
                    <td class="project-actions text-right">
                        <form action="{{ route('admin.portfolios.destroy', $portfolio->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="event.stopPropagation(); return confirm('هل أنت متأكد؟')">
                                <i class="bi bi-trash"></i> حذف
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
