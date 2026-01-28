@extends('layouts.admin')

@section('title', 'تفاصيل الدفعة')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center" id="modal-content-area">
            <div class="col-md-8 mx-auto">
                <div class="card card-success card-outline shadow-sm border-0">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 text-center">
                        <div class="payment-icon bg-success-subtle text-success d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 80px; height: 80px; border-radius: 50%;">
                            <i class="bi bi-cash-stack display-6"></i>
                        </div>
                        <h3 class="card-title fw-bold text-success float-none">إيصال استلام مبلغ</h3>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-4 mt-2">
                            <div class="col-sm-6 text-end">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">العميل</label>
                                <p class="fw-bold fs-5 mb-0 text-dark">{{ $payment->customer->name ?? '—' }}</p>
                            </div>
                            <div class="col-sm-6 text-end">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">التاريخ</label>
                                <p class="fw-bold mb-0 text-dark"><i class="bi bi-calendar3 me-1 text-success"></i>
                                    {{ $payment->date->format('Y-m-d') }}</p>
                            </div>
                            <div class="col-sm-6 text-end">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">المبلغ المحصل</label>
                                <p class="fw-bold fs-4 mb-0 text-success">{{ number_format($payment->amount, 2) }}
                                    <small>{{ $payment->currency }}</small></p>
                            </div>
                            <div class="col-sm-6 text-end">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">طريقة الدفع</label>
                                <div>
                                    <span
                                        class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold">{{ $payment->payment_method }}</span>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">ملاحظات إضافية</label>
                                <div class="bg-light p-3 rounded-3 border-start border-success border-4 text-muted">
                                    {{ $payment->note ?? 'لا يوجد ملاحظات مسجلة' }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('admin.payments.index') }}"
                                class="btn btn-light rounded-pill px-4 shadow-sm fw-bold">
                                <i class="bi bi-arrow-right me-1"></i> رجوع
                            </a>
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold"
                                    onclick="return confirm('هل أنت متأكد من حذف هذه الدفعة؟')">
                                    <i class="bi bi-trash me-1"></i> حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection