@extends('layouts.admin')

@section('title', 'تعديل المقال')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">تعديل المقال</h3>
    </div>
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
             <div class="row">
                <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="title_en">العنوان (English)</label>
                        <input type="text" name="title_en" class="form-control" id="title_en" value="{{ $post->getTitleEnAttribute() }}" required>
                    </div>
                </div>
                 <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="title_ar">العنوان (Arabic)</label>
                        <input type="text" name="title_ar" class="form-control" id="title_ar" value="{{ $post->getTitleArAttribute() }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="content_en">المحتوى (English)</label>
                        <textarea name="content_en" class="form-control" id="content_en" rows="5">{{ $post->getContentEnAttribute() }}</textarea>
                    </div>
                </div>
                 <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="content_ar">المحتوى (Arabic)</label>
                        <textarea name="content_ar" class="form-control" id="content_ar" rows="5">{{ $post->getContentArAttribute() }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="form-group mb-3">
                <label for="published_at">تاريخ النشر</label>
                <input type="date" name="published_at" class="form-control" id="published_at" value="{{ $post->published_at ? $post->published_at->format('Y-m-d') : '' }}">
            </div>

            <div class="form-group mb-3">
                <label for="image">الصورة</label>
                 @if($post->image)
                    <div class="mb-2">
                        <img src="{{ asset($post->image) }}" width="150" class="img-thumbnail">
                    </div>
                @endif
                <div class="input-group">
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                 <small class="text-muted">اتركها فارغة للإبقاء على الصورة الحالية</small>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">تحديث</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
