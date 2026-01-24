<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>فاتورة طلب #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'sans-serif';
            direction: rtl;
            text-align: right;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .company-info {
            float: left;
            text-align: left;
        }

        .order-info {
            float: right;
            text-align: right;
        }

        .clearfix {
            clear: both;
        }

        .customer-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 20px;
        }

        .customer-card h3 {
            margin-top: 0;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }

        .total-row {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        .balance-info {
            font-weight: bold;
            color: #d9534f;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>فاتورة طلب</h1>
        <p>رقم الشركة: 98892009</p>
    </div>

    <div class="clearfix">
        <div class="order-info">
            <p><strong>رقم الطلب:</strong> #{{ $order->id }}</p>
            <p><strong>التاريخ:</strong> {{ $order->date->format('Y-m-d') }}</p>
        </div>
    </div>

    <div class="customer-card">
        <h3>بيانات العميل</h3>
        <p><strong>اسم العميل:</strong> {{ $order->customer->name }}</p>
        <p><strong>رقم الهاتف:</strong><div style="direction: ltr;">{{ $order->customer->phone }}</div> </p>
        <p><strong>العنوان:</strong> {{ $order->customer->area }}، {{ $order->customer->street }}، قطعة
            {{ $order->customer->piece }}، منزل {{ $order->customer->house_number }}
        </p>
        <p class="balance-info"><strong>الرصيد الحالي:</strong>
            {{ number_format($order->customer->balance?->amount ?? 0, 2) }} ج</p>
    </div>

    <table>
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
            <tr class="total-row">
                <td colspan="3" style="text-align: left;">إجمالي الطلب:</td>
                <td>{{ number_format($order->total, 2) }} جنيه</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>شكراً لتعاملكم معنا</p>
    </div>
</body>

</html>