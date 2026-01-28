@extends('layouts.admin')

@section('title', 'تفاصيل الطلب #' . $order->id)

@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger shadow-sm border-0 rounded-3">
            {{ session('error') }}
        </div>
    @endif
    <div class="container-fluid p-0" id="modal-content-area">

        <div class="row g-3 g-lg-4">

            <div class="col-lg-4 col-xl-3">
                <div class="{{ request()->ajax() ? '' : 'sticky-top' }}"
                    style="{{ request()->ajax() ? '' : 'top: 20px; z-index: 10;' }}">
                    <div class="card card-primary card-outline shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                            <h3 class="card-title fw-bold text-primary">
                                <i class="bi bi-info-circle-fill me-2"></i> معلومات الطلب
                            </h3>
                        </div>
                        <div class="card-body px-4">
                            <div class="mb-4 text-end">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">العميل</label>
                                <p class="fw-bold fs-5 mb-0 text-dark">{{ $order->customer->name }}</p>
                            </div>

                            <div class="mb-4 text-end">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">التاريخ</label>
                                <p class="fw-bold mb-0 text-primary"><i class="bi bi-calendar3 me-1"></i>
                                    {{ $order->date->format('Y-m-d') }}</p>
                            </div>

                            <div class="mb-4 text-end">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">النوع</label>
                                <span
                                    class="badge bg-info-subtle text-info rounded-pill px-3 fs-6">{{ $order->type ?? 'غير محدد' }}</span>
                            </div>

                            <div class="mb-2 text-end">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">ملاحظات</label>
                                <p class="text-muted small bg-light p-3 rounded-3 mb-0">
                                    {{ $order->note ?? 'لا يوجد ملاحظات إضافية' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-xl-9">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h3 class="card-title fw-bold text-primary">
                            <i class="bi bi-bag-check-fill me-2"></i> أصناف الطلب
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">المنتج</th>
                                        <th class="py-3">السعر</th>
                                        <th class="py-3">الكمية</th>
                                        <th class="py-3 text-end pe-4">الإجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark">{{ $item->product->name }}</td>
                                            <td class="text-muted">{{ number_format($item->unit_price, 2) }} <span
                                                    class="small">{{ $item->currency }}</span></td>
                                            <td><span
                                                    class="badge bg-light text-dark border shadow-sm px-3 rounded-pill">{{ $item->quantity }}</span>
                                            </td>
                                            <td class="text-end pe-4 fw-bold text-primary">
                                                {{ number_format($item->subtotal, 2) }} <span
                                                    class="small">{{ $item->currency }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light-subtle">
                                    <tr class="border-top-2">
                                        <th colspan="3" class="text-end py-4 pe-3 fs-5">الإجمالي النهائي:</th>
                                        <th class="text-end pe-4 py-4 fs-4 text-primary fw-bold">
                                            {{ number_format($order->total, 2) }} <span
                                                class="fs-6">{{ $order->currency }}</span>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4 mb-4">
                    <a href="{{ route('admin.orders.index') }}"
                        class="btn btn-light rounded-pill px-4 shadow-sm w-100 w-md-auto font-weight-bold">
                        <i class="bi bi-arrow-right me-1"></i> رجوع للطلبات
                    </a>

                    <div class="d-flex gap-2 w-100 w-md-auto">
                        <a href="{{ route('admin.orders.pdf', $order->id) }}"
                            class="btn btn-outline-danger rounded-pill px-4 flex-grow-1 flex-md-grow-0 shadow-sm font-weight-bold">
                            <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF
                        </a>

                        @php
                            $whatsapp_number = $order->customer->phone_whatsapp ?: $order->customer->phone;
                            $whatsapp_number = preg_replace('/[^0-9]/', '', $whatsapp_number);
                            if (str_starts_with($whatsapp_number, '0')) {
                                $whatsapp_number = '2' . $whatsapp_number;
                            }

                            $message = "فاتورة طلب رقم #{$order->id}\n";
                            $message .= "العميل: {$order->customer->name}\n";
                            $message .= "التاريخ: " . $order->date->format('Y-m-d') . "\n";
                            $message .= "الإجمالي: " . number_format($order->total, 2) . " " . $order->currency . "\n";
                            $message .= "الرصيد الحالي: " . number_format($order->customer->balance?->amount ?? 0, 2) . " " . ($order->customer->balance?->currency ?? 'EGP') . "\n";
                            $message .= "سيتم إرسال الـ PDF إليكم الآن.";

                            $whatsapp_url = "https://wa.me/{$whatsapp_number}?text=" . urlencode($message);
                        @endphp

                        <a href="{{ $whatsapp_url }}" target="_blank"
                            class="btn btn-success rounded-pill px-4 flex-grow-1 flex-md-grow-0 shadow-sm font-weight-bold">
                            <i class="bi bi-whatsapp me-1"></i> واتساب
                        </a>
                        <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank"
                            class="btn btn-outline-info rounded-pill px-4 flex-grow-1 flex-md-grow-0 shadow-sm font-weight-bold">
                            <i class="bi bi-printer-fill me-1"></i> طباعة
                        </a>

                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                            class="flex-grow-1 flex-md-grow-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4 w-100 shadow-sm font-weight-bold"
                                onclick="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                                <i class="bi bi-trash-fill me-1"></i> حذف
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(request()->ajax())
        <style>
            .sticky-top {
                position: relative !important;
                top: auto !important;
            }

            .card {
                margin-bottom: 1.25rem !important;
            }

            .modal-body-premium {
                padding: 1.25rem 1rem;
            }

            .table-responsive {
                font-size: 0.95rem;
            }

            @media (max-width: 991.98px) {

                .col-lg-4,
                .col-lg-8,
                .col-xl-3,
                .col-xl-9 {
                    flex: 0 0 100% !important;
                    max-width: 100% !important;
                }
            }

            @media (max-width: 576px) {
                .modal-body-premium {
                    padding: 1rem 0.75rem;
                }
            }
        </style>
    @endif
@endsection