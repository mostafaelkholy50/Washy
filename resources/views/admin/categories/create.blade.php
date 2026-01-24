@extends('layouts.admin')

@section('title', 'إضافة قسم')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إضافة قسم جديد</h3>
    </div>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="card-body">
             <div class="row">
                <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="name_en">الاسم (English)</label>
                        <input type="text" name="name_en" class="form-control" id="name_en" required>
                    </div>
                </div>
                 <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="name_ar">الاسم (Arabic)</label>
                        <input type="text" name="name_ar" class="form-control" id="name_ar" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
