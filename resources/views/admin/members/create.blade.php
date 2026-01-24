@extends('layouts.admin')

@section('title', 'إضافة عضو')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إضافة عضو جديد</h3>
    </div>
    <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="name">الاسم</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="role">الدور الوظيفي</label>
                <input type="text" name="role" class="form-control" id="role" required>
            </div>
            
            <div class="form-group mb-3">
                <label for="facebook">رابط Facebook</label>
                <input type="text" name="facebook" class="form-control" id="facebook">
            </div>
            <div class="form-group mb-3">
                <label for="twitter">رابط Twitter</label>
                <input type="text" name="twitter" class="form-control" id="twitter">
            </div>
             <div class="form-group mb-3">
                <label for="linkedin">رابط LinkedIn</label>
                <input type="text" name="linkedin" class="form-control" id="linkedin">
            </div>
             <div class="form-group mb-3">
                <label for="instagram">رابط Instagram</label>
                <input type="text" name="instagram" class="form-control" id="instagram">
            </div>

            <div class="form-group mb-3">
                <label for="image">الصورة الشخصية</label>
                <div class="input-group">
                    <input type="file" name="image" class="form-control" id="image" required>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
