@extends('layouts.admin')

@section('title', 'تعديل القسم')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">تعديل القسم</h3>
    </div>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
             <div class="row">
                <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="name_en">الاسم (English)</label>
                        <input type="text" name="name_en" class="form-control" id="name_en" value="{{ $category->name_en }}" required>
                    </div>
                </div>
                 <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="name_ar">الاسم (Arabic)</label>
                        <input type="text" name="name_ar" class="form-control" id="name_ar" value="{{ $category->name_ar }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">تحديث</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
