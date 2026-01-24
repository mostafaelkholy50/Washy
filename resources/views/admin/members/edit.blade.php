@extends('layouts.admin')

@section('title', 'تعديل العضو')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">تعديل العضو</h3>
    </div>
    <form action="{{ route('admin.members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
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
                        <label>الاسم (عربي)</label>
                        <input type="text" name="name_ar" class="form-control" value="{{ $member->getNameArAttribute() }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>المسمى الوظيفي (عربي)</label>
                        <input type="text" name="job_title_ar" class="form-control" value="{{ $member->getJobTitleArAttribute() }}" required>
                    </div>
                </div>

                <!-- English Tab -->
                <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab" dir="ltr">
                    <div class="form-group mb-3">
                        <label>Name (English)</label>
                        <input type="text" name="name_en" class="form-control" value="{{ $member->getNameEnAttribute() }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Job Title (English)</label>
                        <input type="text" name="job_title_en" class="form-control" value="{{ $member->getJobTitleEnAttribute() }}" required>
                    </div>
                </div>
            </div>

            <hr>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="facebook">رابط Facebook</label>
                    <input type="text" name="facebook" class="form-control" id="facebook" value="{{ $member->facebook }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="twitter">رابط Twitter</label>
                    <input type="text" name="twitter" class="form-control" id="twitter" value="{{ $member->twitter }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="linkedin">رابط LinkedIn</label>
                    <input type="text" name="linkedin" class="form-control" id="linkedin" value="{{ $member->linkedin }}">
                </div>
                 <div class="col-md-6 mb-3">
                    <label for="instagram">رابط Instagram</label>
                    <input type="text" name="instagram" class="form-control" id="instagram" value="{{ $member->instagram }}">
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="image">الصورة الشخصية</label>
                 @if($member->image)
                    <div class="mb-2">
                        <img src="{{ asset($member->image) }}" width="150" class="img-thumbnail">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" id="image">
                 <small class="text-muted">اتركها فارغة للإبقاء على الصورة الحالية</small>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">تحديث</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-default float-end">إلغاء</a>
        </div>
    </form>
</div>
@endsection
