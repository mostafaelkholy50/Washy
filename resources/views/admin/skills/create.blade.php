@extends('layouts.admin')

@section('title', 'إضافة مهارة')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">إضافة مهارة جديدة</h3>
    </div>
    <form action="{{ route('admin.skills.store') }}" method="POST">
        @csrf
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
                        <label for="name_ar">اسم المهارة (عربي)</label>
                        <input type="text" name="name_ar" class="form-control" id="name_ar" required>
                    </div>
                </div>

                <!-- English Tab -->
                <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab" dir="ltr">
                     <div class="form-group mb-3">
                        <label for="name_en">Skill Name (English)</label>
                        <input type="text" name="name_en" class="form-control" id="name_en" required>
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="percentage">النسبة المئوية (0-100)</label>
                <input type="number" name="percentage" class="form-control" id="percentage" min="0" max="100" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
            <a href="{{ route('admin.skills.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
