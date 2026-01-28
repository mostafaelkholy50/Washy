<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <title>فاتورة طلب #{{ $order->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            color: #1f2937;
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-size: 14px;
            line-height: 1.4;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px 30px;
            background: #ffffff;
        }

        /* البانر - نسخة مضغوطة */
        .banner {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
            padding: 10px 0;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-radius: 12px;
        }

        .banner img {
            max-width: 180px;
            height: auto;
        }

        /* العنوان الرئيسي */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #0d6efd;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: 900;
            color: #1e40af;
            margin: 0;
        }

        /* بيانات الفاتورة */
        .invoice-details {
            background: #f8f9fc;
            padding: 12px 20px;
            border-radius: 10px;
            display: flex;
            gap: 30px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-item .label {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .detail-item .value {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
        }

        /* بيانات العميل */
        .customer-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 20px 0;
        }

        .info-card {
            background: #f8f9fc;
            padding: 15px;
            border-radius: 10px;
            border-right: 4px solid #0d6efd;
        }

        .info-card h4 {
            margin: 0 0 5px 0;
            font-size: 13px;
            color: #1e40af;
            font-weight: 700;
        }

        .info-card p {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        /* جدول المنتجات */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 0 1px #e2e8f0;
        }

        .items-table thead {
            background: #0d6efd;
            color: white;
        }

        .items-table th {
            padding: 15px;
            font-size: 14px;
            font-weight: 700;
            text-align: center;
        }

        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            text-align: center;
        }

        .item-name {
            font-weight: 700;
            text-align: right !important;
            color: #1e293b;
        }

        /* الملخص */
        .summary {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .balance-alert {
            background: #fef2f2;
            border-right: 5px solid #ef4444;
            padding: 15px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #991b1b;
        }

        .totals-box {
            width: 250px;
            background: #1e40af;
            color: white;
            padding: 15px 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
        }

        .totals-box .total-label {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .totals-box .total-value {
            font-size: 24px;
            font-weight: 900;
        }

        /* الفوتر */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px dashed #cbd5e1;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }

        .no-print {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        .btn-print {
            background: #10b981;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            transition: all 0.3s;
        }

        .btn-print:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        @media print {
            .no-print {
                display: none;
            }

            .container {
                padding: 0;
                max-width: 100%;
            }

            body {
                background: white;
            }
        }
    </style>
    <style>
        #top-banner {
            width: 100%;
            display: block;
            max-height: 150px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        #top-banner img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
        }

        #header {
            position: sticky;
            top: 0;
            z-index: 999;
            background: #fff;
        }

        /* Except top-banner which needs to be full width */
        #top-banner img {
            width: 100% !important;
        }
    </style>
</head>

<body>

    <div class="no-print" style="margin-top: 20px;">
        <button class="btn-print" onclick="window.print()">
            <i class="bi bi-printer"></i> طباعة الفاتورة
        </button>
        <button class="btn-print" style="background: #6b7280;" onclick="window.close()">
            إغلاق
        </button>
    </div>

    <div class="container">

        @if($setting && $setting->top_banner)
            <div id="top-banner" class="col-12 mb-3">
                <img src="{{ asset($setting->top_banner) }}" alt="Banner">
            </div>
        @endif

        <div class="header">
            <div>
                <h1 class="invoice-title">فاتورة طلب</h1>
                <p style="color: #64748b; margin-top: 5px; font-weight: 600;">رقم الشركة: 98892009</p>
            </div>
            <div class="invoice-details">
                <div class="detail-item">
                    <span class="label">رقم الفاتورة</span>
                    <span class="value">#{{ $order->id }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">التاريخ</span>
                    <span class="value">{{ $order->date->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <div class="customer-info">
            <div class="info-card">
                <h4>العميل</h4>
                <p>{{ $order->customer->name }}</p>
            </div>
            <div class="info-card">
                <h4>الهاتف</h4>
                <p style="direction: ltr; text-align: right;">{{ $order->customer->phone }}</p>
            </div>
            <div class="info-card">
                <h4>العنوان</h4>
                <p>{{ $order->customer->area ?? 'غير محدد' }}</p>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">المنتج</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td class="item-name">{{ $item->product->name }}</td>
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td style="font-weight: 700; color: #1e40af;">{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <div>
                @if($order->customer->balance && $order->customer->balance->amount != 0)
                    <div class="balance-alert">
                        الرصيد المتبقي: {{ number_format($order->customer->balance->amount, 2) }} {{ $order->currency }}
                    </div>
                @endif
            </div>

            <div class="totals-box">
                <div class="total-label">الإجمالي النهائي</div>
                <div class="total-value">
                    {{ number_format($order->total, 2) }} {{ $order->currency }}
                </div>
            </div>
        </div>

        <div class="footer">
            <p style="font-size: 14px; font-weight: 700; color: #334155; margin-bottom: 5px;">شكرًا لتعاملك معنا</p>
            <p>تم إصدار هذه الفاتورة إلكترونيًا بتاريخ {{ now()->format('Y-m-d H:i') }}</p>
        </div>

    </div>

    <script>
        // Auto trigger print after a short delay to ensure fonts/images load
        window.onload = function () {
            setTimeout(function () {
                // window.print();
            }, 500);
        };
    </script>
</body>

</html>