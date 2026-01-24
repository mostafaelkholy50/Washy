@extends('layouts.admin')

@section('title', 'المقالات')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إدارة المقالات</h3>
        <div class="card-tools">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
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
                    <th>تاريخ النشر</th>
                     <th style="width: 20%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr onclick="window.location='{{ route('admin.posts.edit', $post->id) }}';" style="cursor: pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($post->image)
                        <img src="{{ asset($post->image) }}" alt="Post" class="img-fluid" style="max-height: 50px;">
                        @endif
                    </td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->published_at ? $post->published_at->format('Y-m-d') : 'مسودة' }}</td>
                    <td class="project-actions text-right">
                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display: inline-block;">
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
