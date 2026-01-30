<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طباعة تقرير المدفوعات</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.rtl.min.css') }}" />

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #fff;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #ddd !important;
                padding: 8px;
            }

            thead {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body class="p-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h2 class="fw-bold text-primary">تقرير المدفوعات</h2>
            <div>
                <button onclick="window.print()" class="btn btn-primary btn-lg rounded-pill px-4">
                    <i class="bi bi-printer me-2"></i> طباعة
                </button>
                <a href="{{ route('admin.payments.index') }}"
                    class="btn btn-outline-secondary btn-lg rounded-pill px-4 ms-2">
                    <i class="bi bi-arrow-right me-2"></i> عودة
                </a>
            </div>
        </div>

        <div class="text-center mb-4 d-none d-print-block">
            <h2>تقرير شامل للمدفوعات</h2>
            <p>تاريخ الطباعة: {{ date('Y-m-d H:i') }}</p>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 10%">الرقم</th>
                            <th style="width: 25%">العميل</th>
                            <th style="width: 15%">التاريخ</th>
                            <th style="width: 15%">المبلغ</th>
                            <th style="width: 15%">طريقة الدفع</th>
                            <th style="width: 15%">رصيد العميل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center"><span
                                        class="badge bg-light text-dark border">#{{ $payment->id }}</span></td>
                                <td class="fw-bold">{{ $payment->customer->name ?? '—' }}</td>
                                <td class="text-center">{{ $payment->date->format('Y-m-d') }}</td>
                                <td class="text-center fw-bold text-success">
                                    {{ number_format($payment->amount, 2) }}
                                    <small>{{ $payment->currency_rel->code ?? $payment->currency }}</small>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                        {{ $payment->payment_method }}
                                    </span>
                                </td>
                                <td
                                    class="text-center {{ ($payment->customer->balance?->amount ?? 0) < 0 ? 'text-danger' : 'text-success' }} fw-bold">
                                    {{ number_format($payment->customer->balance?->amount ?? 0, 2) }}
                                    {{ $payment->currency_rel->code ?? $payment->currency }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">لا توجد بيانات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
