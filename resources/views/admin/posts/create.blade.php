@extends('layouts.admin')

@section('title', 'إضافة مقال')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إضافة مقال جديد</h3>
    </div>
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
             <div class="row">
                <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="title_en">العنوان (English)</label>
                        <input type="text" name="title_en" class="form-control" id="title_en" required>
                    </div>
                </div>
                 <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="title_ar">العنوان (Arabic)</label>
                        <input type="text" name="title_ar" class="form-control" id="title_ar" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="content_en">المحتوى (English)</label>
                        <textarea name="content_en" class="form-control" id="content_en" rows="5"></textarea>
                    </div>
                </div>
                 <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="content_ar">المحتوى (Arabic)</label>
                        <textarea name="content_ar" class="form-control" id="content_ar" rows="5"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="form-group mb-3">
                <label for="published_at">تاريخ النشر</label>
                <input type="date" name="published_at" class="form-control" id="published_at">
            </div>

            <div class="form-group mb-3">
                <label for="image">الصورة</label>
                <div class="input-group">
                    <input type="file" name="image" class="form-control" id="image" required>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
