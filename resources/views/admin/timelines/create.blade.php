@extends('layouts.admin')

@section('title', 'إضافة تايم لاين')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إضافة تايم لاين جديد</h3>
    </div>
    <form action="{{ route('admin.timelines.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
             <div class="form-group mb-3">
                <label for="year">السنة (Year)</label>
                <input type="text" name="year" class="form-control" id="year" required>
            </div>

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
                        <label for="description_en">الوصف (English)</label>
                        <textarea name="description_en" class="form-control" id="description_en" rows="3" required></textarea>
                    </div>
                </div>
                 <div class="col-md-6">
                     <div class="form-group mb-3">
                        <label for="description_ar">الوصف (Arabic)</label>
                        <textarea name="description_ar" class="form-control" id="description_ar" rows="3" required></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
            <a href="{{ route('admin.timelines.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
