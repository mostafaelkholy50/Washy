@extends('layouts.admin')

@section('title', 'أعضاء الفريق')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إدارة الأعضاء</h3>
        <div class="card-tools">
            <a href="{{ route('admin.members.create') }}" class="btn btn-primary btn-sm">
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
                    <th>الاسم</th>
                    <th>الدور الوظيفي</th>
                    <th style="width: 20%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr onclick="window.location='{{ route('admin.members.edit', $member->id) }}';" style="cursor: pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($member->image)
                        <img src="{{ asset($member->image) }}" alt="Member" class="img-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        @endif
                    </td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->job_title }}</td>
                    <td class="project-actions text-right">
                        <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" style="display: inline-block;">
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
