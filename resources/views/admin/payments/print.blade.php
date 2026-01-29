<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <title>إيصال دفعة #{{ $payment->id }}</title>
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
            line-height: 1.5;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px 30px;
            background: white;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #10b981;
        }

        .title {
            font-size: 28px;
            font-weight: 900;
            color: #065f46;
            margin: 0;
        }

        .receipt-number {
            font-size: 18px;
            color: #374151;
            font-weight: 700;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px 30px;
            margin: 25px 0;
            background: #f0fdf4;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #86efac;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-item .label {
            font-size: 12px;
            color: #065f46;
            font-weight: 700;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .detail-item .value {
            font-size: 17px;
            font-weight: 700;
            color: #111827;
        }

        .amount-box {
            background: #065f46;
            color: white;
            padding: 25px 20px;
            border-radius: 12px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 4px 14px rgba(6, 95, 70, 0.25);
        }

        .amount-box .label {
            font-size: 15px;
            opacity: 0.9;
            margin-bottom: 8px;
        }

        .amount-box .value {
            font-size: 36px;
            font-weight: 900;
            letter-spacing: 1px;
        }

        .customer-card {
            background: #f3f4f6;
            padding: 18px;
            border-radius: 10px;
            margin: 25px 0;
            border-right: 5px solid #10b981;
        }

        .customer-card h4 {
            margin: 0 0 10px 0;
            color: #065f46;
            font-size: 15px;
            font-weight: 700;
        }

        .note-section {
            background: #fefce8;
            border-right: 5px solid #ca8a04;
            padding: 18px;
            border-radius: 10px;
            margin-top: 30px;
            font-size: 14px;
            color: #713f12;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px dashed #9ca3af;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
        }

        .no-print {
            text-align: center;
            margin: 20px 0;
        }

        .btn-print {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            margin: 0 10px;
        }

        .btn-close {
            background: #6b7280;
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
</head>

<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">
            <i class="bi bi-printer-fill"></i> طباعة الإيصال
        </button>
        <button class="btn-print btn-close" onclick="window.close()">
            إغلاق
        </button>
    </div>

    <div class="container">

        <div class="header">
            <h1 class="title">إيصال استلام مبلغ</h1>
            <div class="receipt-number">رقم الإيصال #{{ $payment->id }}</div>
        </div>

        <div class="details-grid">
            <div class="detail-item">
                <span class="label">العميل</span>
                <span class="value">{{ $payment->customer->name ?? 'غير محدد' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">التاريخ</span>
                <span class="value">{{ $payment->date->format('d/m/Y') }}</span>
            </div>
            <div class="detail-item">
                <span class="label">طريقة الدفع</span>
                <span class="value">{{ $payment->payment_method ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">رقم الهاتف</span>
                <span class="value" style="direction: ltr;">{{ $payment->customer->phone ?? '—' }}</span>
            </div>
        </div>

        <div class="amount-box">
            <div class="label">المبلغ المحصل</div>
            <div class="value">
                {{ number_format($payment->amount, 2) }}
                <span
                    style="font-size: 24px; opacity: 0.9;">{{ $payment->currency ?? $payment->currency_rel->code ?? 'جنيه' }}</span>
            </div>
        </div>

        <div class="customer-card">
            <h4>بيانات العميل</h4>
            <p style="margin: 8px 0; font-size: 15px;">
                <strong>الاسم:</strong> {{ $payment->customer->name }}<br>
                @if($payment->customer->phone)
                    <strong>الهاتف:</strong> {{ $payment->customer->phone }}<br>
                @endif
                @if($payment->customer->phone_whatsapp)
                    <strong>واتساب:</strong> {{ $payment->customer->phone_whatsapp }}<br>
                @endif
            </p>
        </div>

        @if($payment->note)
            <div class="note-section">
                <strong>ملاحظات:</strong><br>
                {{ $payment->note }}
            </div>
        @endif

        <div class="footer">
            <p style="font-size: 15px; font-weight: 700; color: #374151; margin-bottom: 8px;">
                تم استلام المبلغ بنجاح – شكراً لثقتكم
            </p>
            <p>تم إصدار هذا الإيصال إلكترونياً بتاريخ {{ now()->format('Y-m-d H:i') }}</p>
        </div>

    </div>

    <script>
        window.onload = function () {
            setTimeout(() => {
                // window.print();
            }, 800);
        };
    </script>
</body>

</html>
