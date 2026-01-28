<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <title>فاتورة طلب #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Cairo', 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
            color: #1f2937;
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-size: 12px;
            /* تصغير الخط العام */
            line-height: 1.4;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 15px 25px;
            /* تقليل padding الحواف */
            background: #ffffff;
        }

        /* البانر - نسخة مضغوطة */
        .banner {
            width: 100%;
            text-align: center;
            margin-bottom: 15px;
            padding: 8px 0;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border-radius: 8px;
        }

        .banner img {
            max-width: 150px;
            /* صغرنا اللوجو أكتر */
            height: auto;
        }

        /* العنوان الرئيسي */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0d6efd;
        }

        .invoice-title {
            font-size: 22px;
            /* صغرنا العنوان */
            font-weight: 900;
            color: #1e40af;
            margin: 0;
        }

        /* بيانات الفاتورة جنب بعض */
        .invoice-details {
            display: flex;
            justify-content: space-around;
            /* توزيع البيانات جنب بعض */
            background: #f8f9fc;
            padding: 8px;
            border-radius: 6px;
            margin-bottom: 5px;
        }

        .invoice-details .label {
            font-size: 10px;
            color: #64748b;
        }

        .invoice-details .value {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
        }

        /* بيانات العميل - Compact */
        .customer-info {
            display: flex;
            gap: 10px;
            margin: 15px 0;
        }

        .info-card {
            flex: 1;
            background: #f8f9fc;
            padding: 10px 12px;
            border-radius: 8px;
            border-right: 3px solid #0d6efd;
        }

        .info-card h4 {
            margin: 0 0 4px 0;
            font-size: 12px;
            color: #1e40af;
        }

        .info-card p {
            margin: 0;
            font-size: 12px;
            font-weight: 600;
        }

        /* جدول المنتجات - Compact */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-radius: 8px;
            overflow: hidden;
        }

        .items-table thead {
            background: #0d6efd;
            color: white;
        }

        .items-table th {
            padding: 10px;
            font-size: 13px;
            text-align: center;
        }

        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
            text-align: center;
        }

        .item-name {
            font-weight: 700;
            text-align: right !important;
        }

        /* الملخص */
        .summary {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .balance-alert {
            flex: 1;
            background: #fef2f2;
            border-right: 4px solid #ef4444;
            padding: 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            color: #991b1b;
        }

        .totals-box {
            width: 200px;
            /* تقليل عرض صندوق الإجمالي */
            background: #1e40af;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-align: center;
        }

        .totals-box .total-label {
            font-size: 12px;
            opacity: 0.9;
        }

        .totals-box .total-value {
            font-size: 20px;
            font-weight: 900;
        }

        /* الفوتر */
        .footer {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px dashed #cbd5e1;
            text-align: center;
            color: #64748b;
            font-size: 11px;
        }
    </style>
</head>

<body>

    <div class="container">

        @if($setting && $setting->top_banner)
            <div class="banner">
                <img src="{{ public_path($setting->top_banner) }}" alt="شعار الشركة">
            </div>
        @endif

        <div class="header">
            <div style="text-align: center; ">
                <h1 class="invoice-title">فاتورة طلب</h1>
                <p style="color: #64748b; margin-top: 2px;">رقم الشركة: 98892009</p>
            </div>
            <div class="invoice-details">
                <div class="label">رقم الفاتورة</div>
                <div class="value">#{{ $order->id }}</div>
                <div class="label" style="margin-top: 5px;">التاريخ</div>
                <div class="value">{{ $order->date->format('d/m/Y') }}</div>
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
                <p>{{ $order->customer->area }}</p>
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
                        <td style="text-align: center;">{{ number_format($item->unit_price, 2) }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ number_format($item->subtotal, 2) }}</td>
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
            <p>شكرًا لتعاملك معنا</p>
            <p style="font-size: 9px; color: #94a3b8; margin-top: 2px;">هذه الفاتورة صدرت آليًا</p>
        </div>

    </div>

</body>

</html>
