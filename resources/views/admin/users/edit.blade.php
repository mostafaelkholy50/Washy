@extends('layouts.admin')

@section('title', 'تعديل المستخدم')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">تعديل المستخدم</h3>
    </div>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="name">الاسم</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">كلمة المرور (اتركها فارغة إذا لم ترد التغيير)</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
             <div class="form-group mb-3">
                <label for="password_confirmation">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">تحديث</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
