@extends('layouts.admin')

@section('title', 'الشرائح (Slider)')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إدارة الشرائح</h3>
        <div class="card-tools">
            <a href="{{ route('admin.slides.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> إضافة 
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="width: 20%">الخلفية</th>
                    <th style="width: 20%">الصورة الأمامية</th>
                    <th>العنوان</th>
                    <th style="width: 10%">الترتيب</th>
                    <th style="width: 20%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($slides as $slide)
                <tr onclick="window.location='{{ route('admin.slides.edit', $slide->id) }}';" style="cursor: pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ asset($slide->image) }}" alt="Background" class="img-fluid" style="max-height: 50px;">
                    </td>
                    <td>
                        @if($slide->foreground_image)
                        <img src="{{ asset($slide->foreground_image) }}" alt="Foreground" class="img-fluid" style="max-height: 50px;">
                        @else
                        -
                        @endif
                    </td>
                    <td>{{ $slide->title ?? '-' }}</td>
                    <td>{{ $slide->sort_order }}</td>
                    <td class="project-actions text-right">
                        <form action="{{ route('admin.slides.destroy', $slide->id) }}" method="POST" style="display: inline-block;">
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
