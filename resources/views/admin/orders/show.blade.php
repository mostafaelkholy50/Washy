@extends('layouts.admin')

@section('title', 'تفاصيل الطلب #' . $order->id)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">معلومات الطلب</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="bi bi-person mr-1"></i> العميل</strong>
                        <p class="text-muted">{{ $order->customer->name }}</p>
                        <hr>
                        <strong><i class="bi bi-calendar mr-1"></i> التاريخ</strong>
                        <p class="text-muted">{{ $order->date->format('Y-m-d') }}</p>
                        <hr>
                        <strong><i class="bi bi-tag mr-1"></i> النوع</strong>
                        <p class="text-muted">{{ $order->type ?? 'غير محدد' }}</p>
                        <hr>
                        <strong><i class="bi bi-info-circle mr-1"></i> ملاحظات</strong>
                        <p class="text-muted">{{ $order->note ?? 'لا يوجد' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">أصناف الطلب</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-valign-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>المنتج</th>
                                        <th>السعر</th>
                                        <th>الكمية</th>
                                        <th>الإجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ number_format($item->unit_price, 2) }} ج</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->subtotal, 2) }} ج</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light">
                                        <th colspan="3" class="text-right text-end">الإجمالي النهائي:</th>
                                        <th class="text-primary">{{ number_format($order->total, 2) }} جنيه</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-3 mb-4">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-default w-100 w-md-auto">
                        <i class="bi bi-arrow-right"></i> رجوع للطلبات
                    </a>

                    <div class="d-flex gap-2 w-100 w-md-auto justify-content-center justify-content-md-end">
                        <a href="{{ route('admin.orders.pdf', $order->id) }}"
                            class="btn btn-danger flex-fill flex-md-grow-0">
                            <i class="bi bi-file-pdf"></i> PDF
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
                            $message .= "الإجمالي: " . number_format($order->total, 2) . " ج\n";
                            $message .= "الرصيد الحالي: " . number_format($order->customer->balance?->amount ?? 0, 2) . " ج\n";
                            $message .= "سيتم إرسال الـ PDF إليكم الآن.";

                            $whatsapp_url = "https://wa.me/{$whatsapp_number}?text=" . urlencode($message);
                        @endphp

                        <a href="{{ $whatsapp_url }}" target="_blank" class="btn btn-success flex-fill flex-md-grow-0">
                            <i class="bi bi-whatsapp"></i> واتساب
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection