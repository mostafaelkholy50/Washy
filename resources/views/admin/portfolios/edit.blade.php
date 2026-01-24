@extends('layouts.admin')

@section('title', 'تعديل العمل')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">تعديل العمل</h3>
    </div>
    <form action="{{ route('admin.portfolios.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
             <div class="row">
                <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="title_en">العنوان (English)</label>
                        <input type="text" name="title_en" class="form-control" id="title_en" value="{{ $portfolio->getTitleEnAttribute() }}" required>
                    </div>
                </div>
                 <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="title_ar">العنوان (Arabic)</label>
                        <input type="text" name="title_ar" class="form-control" id="title_ar" value="{{ $portfolio->getTitleArAttribute() }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="description_en">الوصف (English)</label>
                        <textarea name="description_en" class="form-control" id="description_en" rows="3">{{ $portfolio->getDescriptionEnAttribute() }}</textarea>
                    </div>
                </div>
                 <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="description_ar">الوصف (Arabic)</label>
                        <textarea name="description_ar" class="form-control" id="description_ar" rows="3">{{ $portfolio->getDescriptionArAttribute() }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="form-group mb-3">
                <label for="category_id">القسم</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">اختر القسم</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $portfolio->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="image">الصورة</label>
                 @if($portfolio->image)
                    <div class="mb-2">
                        <img src="{{ asset($portfolio->image) }}" width="150" class="img-thumbnail">
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
            <a href="{{ route('admin.portfolios.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
