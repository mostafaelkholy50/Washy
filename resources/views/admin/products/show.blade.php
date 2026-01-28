@extends('layouts.admin')

@section('title', 'تفاصيل المنتج: ' . $product->name)

@section('content')
<div class="container-fluid {{ request()->ajax() ? 'p-0' : '' }}" id="modal-content-area">

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">

            <div class="card card-primary card-outline shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 text-center">
                    <div class="product-icon bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width: 80px; height: 80px; border-radius: 50%;">
                        <i class="bi bi-box-seam display-6"></i>
                    </div>
                    <p class="text-primary mb-0 small">تفاصيل الصنف</p>
                </div>

                <div class="card-body px-md-5 px-4 pb-4">
                    <div class="row g-4 mt-2 text-end">

                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">اسم المنتج</label>
                            <p class="fw-bold fs-5 mb-0 text-dark">{{ $product->name }}</p>
                        </div>

                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">نوع الخدمة</label>
                            <p class="fw-bold mb-0">
                                <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2 fs-6">
                                    {{ $product->type ?? 'غير محدد' }}
                                </span>
                            </p>
                        </div>

                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">سعر الخدمة</label>
                            <p class="fw-bold fs-4 mb-0 text-primary">
                                {{ number_format($product->price, 2) }}
                                <small class="fs-6 text-muted ms-1">{{ $product->currency }}</small>
                            </p>
                        </div>

                        <div class="col-12">
                            <label class="text-muted small text-uppercase fw-bold mb-2 d-block">الوصف / الملاحظات</label>
                            <div class="bg-light p-3 rounded-3 border-start border-primary border-4 text-muted lh-base">
                                {{ $product->note ?? 'لا يوجد ملاحظات مسجلة لهذا المنتج' }}
                            </div>
                        </div>

                    </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-3 mt-5 pt-3 border-top">
                            <a href="{{ route('admin.products.index') }}"
                               class="btn btn-light rounded-pill px-4 shadow-sm fw-bold">
                                <i class="bi bi-arrow-right me-1"></i> رجوع للقائمة
                            </a>

                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="btn btn-warning rounded-pill px-4 shadow-sm fw-bold text-white">
                                <i class="bi bi-pencil me-1"></i> تعديل
                            </a>

                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold"
                                        onclick="return confirm('هل أنت متأكد من حذف المنتج {{ $product->name }}؟')">
                                    <i class="bi bi-trash me-1"></i> حذف
                                </button>
                            </form>
                        </div>
                </div>
            </div>

        </div>
    </div>

</div>

@if(request()->ajax())
    <style>
        /* تعديلات خاصة بالمودال فقط */
        #modal-content-area {
            padding: 0 !important;
        }

        .card {
            margin-bottom: 1rem !important;
            border-radius: 12px !important;
        }

        .card-body {
            padding: 1.5rem 1.25rem !important;
        }

        .product-icon {
            width: 70px !important;
            height: 70px !important;
        }

        .product-icon i {
            font-size: 2.5rem !important;
        }

        .modal-body-premium {
            padding: 1.25rem 1rem !important;
        }

        @media (max-width: 575.98px) {
            .card-header {
                padding: 1.25rem 1rem !important;
            }
            h3.card-title {
                font-size: 1.4rem !important;
            }
            .fs-4 {
                font-size: 1.6rem !important;
            }
        }
    </style>
@endif
@endsection
