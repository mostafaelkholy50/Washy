@extends('layouts.admin')

@section('title', 'الإعدادات العامة')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">تعديل الإعدادات</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                        
                        <div class="mb-3">
                            <label class="form-label">اسم الموقع (عربي)</label>
                            <input type="text" class="form-control" name="site_name_ar" value="{{ old('site_name_ar', $setting->site_name_ar ?? '') }}">
                        </div>

                        <div class="mb-3">
                           <label class="form-label">العنوان (عربي)</label>
                           <input type="text" name="address_ar" class="form-control" value="{{ old('address_ar', $setting->address_ar ?? '') }}">
                        </div>

                        <h5 class="mt-4 text-primary">قسم الترحيب (Welcome)</h5>
                        <div class="mb-3">
                            <label class="form-label">العنوان</label>
                            <textarea class="form-control" name="welcome_title_ar" rows="2">{{ old('welcome_title_ar', $setting->welcome_title_ar ?? '') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">نص الزر 1</label>
                                <input type="text" class="form-control" name="welcome_btn_1_text_ar" value="{{ old('welcome_btn_1_text_ar', $setting->welcome_btn_1_text_ar ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">نص الزر 2</label>
                                <input type="text" class="form-control" name="welcome_btn_2_text_ar" value="{{ old('welcome_btn_2_text_ar', $setting->welcome_btn_2_text_ar ?? '') }}">
                            </div>
                        </div>

                        <h5 class="mt-4 text-primary">من نحن (About)</h5>
                        <div class="mb-3">
                            <label class="form-label">العنوان</label>
                            <input type="text" class="form-control" name="about_title_ar" value="{{ old('about_title_ar', $setting->about_title_ar ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الوصف</label>
                            <textarea class="form-control" name="about_description_ar" rows="3">{{ old('about_description_ar', $setting->about_description_ar ?? '') }}</textarea>
                        </div>

                        <h5 class="mt-4 text-primary">الخدمات (Services)</h5>
                        <div class="mb-3">
                            <label class="form-label">العنوان الرئيسي</label>
                            <input type="text" class="form-control" name="services_title_ar" value="{{ old('services_title_ar', $setting->services_title_ar ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الوصف الرئيسي</label>
                            <textarea class="form-control" name="services_description_ar" rows="3">{{ old('services_description_ar', $setting->services_description_ar ?? '') }}</textarea>
                        </div>
                         <div class="mb-3">
                            <label class="form-label">العنوان الفرعي</label>
                            <input type="text" class="form-control" name="services_sub_title_ar" value="{{ old('services_sub_title_ar', $setting->services_sub_title_ar ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الوصف الفرعي</label>
                            <textarea class="form-control" name="services_sub_description_ar" rows="3">{{ old('services_sub_description_ar', $setting->services_sub_description_ar ?? '') }}</textarea>
                        </div>

                        <h5 class="mt-4 text-primary">تواصل معنا & CTA</h5>
                         <div class="mb-3">
                            <label class="form-label">عنوان تواصل معنا</label>
                            <input type="text" class="form-control" name="contact_title_ar" value="{{ old('contact_title_ar', $setting->contact_title_ar ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">وصف تواصل معنا</label>
                            <textarea class="form-control" name="contact_description_ar" rows="3">{{ old('contact_description_ar', $setting->contact_description_ar ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">نص الدعوة لاتخاذ إجراء (CTA)</label>
                            <textarea class="form-control" name="cta_text_ar" rows="2">{{ old('cta_text_ar', $setting->cta_text_ar ?? '') }}</textarea>
                        </div>
                         <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">نص زر CTA 1</label>
                                <input type="text" class="form-control" name="cta_button1_text_ar" value="{{ old('cta_button1_text_ar', $setting->cta_button1_text_ar ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">نص زر CTA 2</label>
                                <input type="text" class="form-control" name="cta_button2_text_ar" value="{{ old('cta_button2_text_ar', $setting->cta_button2_text_ar ?? '') }}">
                            </div>
                        </div>

                    </div>

                    <!-- English Tab -->
                    <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab" dir="ltr">
                        
                        <div class="mb-3">
                            <label class="form-label">Site Name (English)</label>
                            <input type="text" class="form-control" name="site_name_en" value="{{ old('site_name_en', $setting->site_name_en ?? '') }}">
                        </div>

                        <div class="mb-3">
                           <label class="form-label">Address (English)</label>
                           <input type="text" name="address_en" class="form-control" value="{{ old('address_en', $setting->address_en ?? '') }}">
                        </div>

                        <h5 class="mt-4 text-primary">Welcome Section</h5>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <textarea class="form-control" name="welcome_title_en" rows="2">{{ old('welcome_title_en', $setting->welcome_title_en ?? '') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Button 1 Text</label>
                                <input type="text" class="form-control" name="welcome_btn_1_text_en" value="{{ old('welcome_btn_1_text_en', $setting->welcome_btn_1_text_en ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Button 2 Text</label>
                                <input type="text" class="form-control" name="welcome_btn_2_text_en" value="{{ old('welcome_btn_2_text_en', $setting->welcome_btn_2_text_en ?? '') }}">
                            </div>
                        </div>

                        <h5 class="mt-4 text-primary">About Section</h5>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="about_title_en" value="{{ old('about_title_en', $setting->about_title_en ?? '') }}">
                        </div>
                         <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="about_description_en" rows="3">{{ old('about_description_en', $setting->about_description_en ?? '') }}</textarea>
                        </div>

                        <h5 class="mt-4 text-primary">Services Section</h5>
                        <div class="mb-3">
                            <label class="form-label">Main Title</label>
                            <input type="text" class="form-control" name="services_title_en" value="{{ old('services_title_en', $setting->services_title_en ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Main Description</label>
                            <textarea class="form-control" name="services_description_en" rows="3">{{ old('services_description_en', $setting->services_description_en ?? '') }}</textarea>
                        </div>
                         <div class="mb-3">
                            <label class="form-label">Subtitle</label>
                            <input type="text" class="form-control" name="services_sub_title_en" value="{{ old('services_sub_title_en', $setting->services_sub_title_en ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sub Description</label>
                            <textarea class="form-control" name="services_sub_description_en" rows="3">{{ old('services_sub_description_en', $setting->services_sub_description_en ?? '') }}</textarea>
                        </div>

                        <h5 class="mt-4 text-primary">Contact & CTA</h5>
                         <div class="mb-3">
                            <label class="form-label">Contact Title</label>
                            <input type="text" class="form-control" name="contact_title_en" value="{{ old('contact_title_en', $setting->contact_title_en ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Description</label>
                            <textarea class="form-control" name="contact_description_en" rows="3">{{ old('contact_description_en', $setting->contact_description_en ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CTA Text</label>
                            <textarea class="form-control" name="cta_text_en" rows="2">{{ old('cta_text_en', $setting->cta_text_en ?? '') }}</textarea>
                        </div>
                         <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CTA Button 1 Text</label>
                                <input type="text" class="form-control" name="cta_button1_text_en" value="{{ old('cta_button1_text_en', $setting->cta_button1_text_en ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CTA Button 2 Text</label>
                                <input type="text" class="form-control" name="cta_button2_text_en" value="{{ old('cta_button2_text_en', $setting->cta_button2_text_en ?? '') }}">
                            </div>
                        </div>

                    </div>
                </div>

                <hr>
                <h4 class="mb-3">إعدادات عامة (مشتركة)</h4>

                <div class="row">
                     <div class="col-md-6">
                        <div class="mb-3">
                            <label for="welcome_btn_1_link" class="form-label">رابط الزر 1 (الترحيب)</label>
                            <input type="text" class="form-control" id="welcome_btn_1_link" name="welcome_btn_1_link" value="{{ old('welcome_btn_1_link', $setting->welcome_btn_1_link ?? '#') }}">
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="mb-3">
                            <label for="welcome_btn_2_link" class="form-label">رابط الزر 2 (الترحيب)</label>
                            <input type="text" class="form-control" id="welcome_btn_2_link" name="welcome_btn_2_link" value="{{ old('welcome_btn_2_link', $setting->welcome_btn_2_link ?? '#') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">الشعار (Logo)</label>
                    @if($setting->logo)
                        <div class="mb-2"><img src="{{ asset($setting->logo) }}" width="100"></div>
                    @endif
                    <input type="file" name="logo" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">الأيقونة (Favicon)</label>
                    @if($setting->favicon)
                        <div class="mb-2"><img src="{{ asset($setting->favicon) }}" width="30"></div>
                    @endif
                    <input type="file" name="favicon" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">بانر أعلى الموقع (Top Banner)</label>
                    @if($setting->top_banner)
                        <div class="mb-2"><img src="{{ asset($setting->top_banner) }}" width="100%"></div>
                    @endif
                    <input type="file" name="top_banner" class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ $setting->email }}">
                    </div>
                    <div class="col-md-6 mb-3">
                         <label class="form-label">الهاتف</label>
                         <input type="text" name="phone" class="form-control" value="{{ $setting->phone }}">
                    </div>
                </div>
                
                 <div class="mb-3">
                     <label class="form-label">رابط LinkedIn</label>
                     <input type="text" name="linkedin" class="form-control" value="{{ $setting->linkedin ?? '' }}">
                 </div>

                <div class="row border p-3 rounded bg-light">
                     <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">لون خلفية شريط الأخبار</label>
                            <input type="color" name="news_ticker_bg_color" class="form-control form-control-color" value="{{ $setting->news_ticker_bg_color ?? '#222222' }}" title="Choose your color">
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">لون نص شريط الأخبار</label>
                            <input type="color" name="news_ticker_text_color" class="form-control form-control-color" value="{{ $setting->news_ticker_text_color ?? '#ffffff' }}" title="Choose your color">
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">اللون الأساسي (Primary Color)</label>
                            <input type="color" name="primary_color" class="form-control form-control-color" value="{{ $setting->primary_color ?? '#e74c3c' }}" title="Choose your color">
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save"></i> حفظ الإعدادات</button>
                </div>
            </form>
        </div>
    </div>
@endsection
