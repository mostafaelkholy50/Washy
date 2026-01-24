@extends('layouts.admin')

@section('title', 'المهارات')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إدارة المهارات</h3>
        <div class="card-tools">
            <a href="{{ route('admin.skills.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> إضافة  
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th>اسم المهارة</th>
                    <th>النسبة المئوية</th>
                    <th style="width: 20%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($skills as $skill)
                <tr onclick="window.location='{{ route('admin.skills.edit', $skill->id) }}';" style="cursor: pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $skill->name }}</td>
                    <td>
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-success" style="width: {{ $skill->percent }}%"></div>
                        </div>
                        <small>{{ $skill->percent }}%</small>
                    </td>
                    <td class="project-actions text-right">
                        <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" style="display: inline-block;">
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
