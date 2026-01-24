@extends('layouts.admin')

@section('title', 'تعديل الشريحة')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">تعديل الشريحة</h3>
    </div>
    <form action="{{ route('admin.slides.update', $slide->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            
            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" id="langTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="ar-tab" data-bs-toggle="tab" data-bs-target="#ar" type="button" role="tab" aria-controls="ar" aria-selected="true">العربية</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en" type="button" role="tab" aria-controls="en" aria-selected="false">English</button>
                </li>
            </ul>

             <div class="tab-content mb-4" id="langTabContent">
                <!-- Arabic Tab -->
                <div class="tab-pane fade show active" id="ar" role="tabpanel" aria-labelledby="ar-tab">
                    <div class="form-group mb-3">
                        <label for="title_ar">العنوان (عربي)</label>
                        <input type="text" name="title_ar" class="form-control" id="title_ar" value="{{ $slide->getTitleArAttribute() }}">
                    </div>
                </div>
                 <!-- English Tab -->
                <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab" dir="ltr">
                    <div class="form-group mb-3">
                        <label for="title_en">Title (English)</label>
                        <input type="text" name="title_en" class="form-control" id="title_en" value="{{ $slide->getTitleEnAttribute() }}">
                    </div>
                </div>
            </div>

            <hr>

            <div class="form-group mb-3">
                <label for="image">صورة الخلفية</label>
                @if($slide->image)
                    <div class="mb-2">
                        <img src="{{ asset($slide->image) }}" width="150" class="img-thumbnail">
                    </div>
                @endif
                <div class="input-group">
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                <small class="text-muted">اتركها فارغة للإبقاء على الصورة الحالية</small>
            </div>

            <div class="form-group mb-3">
                <label for="foreground_image">الصورة الأمامية</label>
                @if($slide->foreground_image)
                    <div class="mb-2">
                        <img src="{{ asset($slide->foreground_image) }}" width="150" class="img-thumbnail">
                    </div>
                @endif
                <div class="input-group">
                    <input type="file" name="foreground_image" class="form-control" id="foreground_image">
                </div>
                <small class="text-muted">اتركها فارغة للإبقاء على الصورة الحالية</small>
            </div>

            <div class="form-group mb-3">
                <label for="sort_order">ترتيب الظهور</label>
                <input type="number" name="sort_order" class="form-control" id="sort_order" value="{{ $slide->sort_order }}">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">تحديث</button>
            <a href="{{ route('admin.slides.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
