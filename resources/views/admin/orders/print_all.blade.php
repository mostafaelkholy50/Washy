<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طباعة تقرير الطلبات</title>
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
            <h2 class="fw-bold text-primary">تقرير الطلبات</h2>
            <div>
                <button onclick="window.print()" class="btn btn-primary btn-lg rounded-pill px-4">
                    <i class="bi bi-printer me-2"></i> طباعة 
                </button>
                <a href="{{ route('admin.orders.index') }}"
                    class="btn btn-outline-secondary btn-lg rounded-pill px-4 ms-2">
                    <i class="bi bi-arrow-right me-2"></i> عودة
                </a>
            </div>
        </div>

        <div class="text-center mb-4 d-none d-print-block">
            <h2>تقرير شامل للطلبات</h2>
            <p>تاريخ الطباعة: {{ date('Y-m-d H:i') }}</p>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 10%">رقم الطلب</th>
                            <th style="width: 15%">التاريخ</th>
                            <th style="width: 25%">العميل</th>
                            <th style="width: 15%">الإجمالي</th>
                            <th style="width: 15%">النوع</th>
                            <th style="width: 15%">رصيد العميل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center fw-bold">#{{ $order->id }}</td>
                                <td class="text-center">{{ $order->date->format('Y-m-d') }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td class="text-center fw-bold">
                                    {{ number_format($order->total, 2) }}
                                    <small>{{ $order->currency_rel->code ?? $order->currency }}</small>
                                </td>
                                <td class="text-center">{{ $order->type ?? 'عادي' }}</td>
                                <td
                                    class="text-center {{ ($order->customer->balance?->amount ?? 0) < 0 ? 'text-danger' : 'text-success' }} fw-bold">
                                    {{ number_format($order->customer->balance?->amount ?? 0, 2) }}
                                    {{ $order->currency_rel->code ?? $order->currency }}
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
