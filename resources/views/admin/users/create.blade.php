@extends('layouts.admin')

@section('title', 'إضافة مستخدم')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إضافة مستخدم جديد</h3>
    </div>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="name">الاسم</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">كلمة المرور</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
             <div class="form-group mb-3">
                <label for="password_confirmation">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
