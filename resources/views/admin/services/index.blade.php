@extends('layouts.admin')

@section('title', 'الخدمات')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إدارة الخدمات</h3>
        <div class="card-tools">
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> إضافة  
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th>الأيقونة</th>
                    <th>العنوان (EN)</th>
                    <th>العنوان (AR)</th>
                    <th style="width: 20%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                <tr onclick="window.location='{{ route('admin.services.edit', $service->id) }}';" style="cursor: pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $service->icon }}</td>
                    <td>{{ $service->getTitleEnAttribute() }}</td>
                    <td>{{ $service->getTitleArAttribute() }}</td>
                    <td class="project-actions text-right">
                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display: inline-block;">
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
