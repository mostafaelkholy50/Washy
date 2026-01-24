@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
    <div class="row">
        <!-- بطاقات الإحصائيات -->
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>{{ $counts['orders'] }}</h3>
                    <p>إجمالي الطلبات</p>
                </div>
                <div class="small-box-icon">
                    <i class="bi bi-cart"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                   class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    مزيد من المعلومات <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>${{ number_format($totalRevenue, 2) }}</h3>
                    <p>إجمالي الإيرادات</p>
                </div>
                <div class="small-box-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                   class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    مزيد من المعلومات <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ $counts['products'] }}</h3>
                    <p>المنتجات</p>
                </div>
                <div class="small-box-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <a href="{{ route('admin.products.index') }}"
                   class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    مزيد من المعلومات <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-danger">
                <div class="inner">
                    <h3>{{ $counts['customers'] }}</h3>
                    <p>العملاء</p>
                </div>
                <div class="small-box-icon">
                    <i class="bi bi-people"></i>
                </div>
                <a href="{{ route('admin.customers.index') }}"
                   class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    مزيد من المعلومات <i class="bi bi-link-45deg"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- مخطط المبيعات -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">تحليل المبيعات (آخر 6 أشهر)</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="position-relative mb-4">
                        <canvas id="salesChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- مخطط توزيع الطلبات -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title">توزيع الطلبات</h3>
                </div>
                <div class="card-body">
                    <canvas id="orderTypeChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- جدول الطلبات الأخيرة -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title">الطلبات الأخيرة</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>العميل</th>
                                    <th>النوع</th>
                                    <th>الإجمالي</th>
                                    <th>التاريخ</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->customer->name ?? 'غير متوفر' }}</td>
                                        <td>{{ $order->type }}</td>
                                        <td>${{ number_format((float) $order->total, 2) }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-muted">
                                                <i class="bi bi-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .small-box {
                border-radius: 10px;
                overflow: hidden;
                position: relative;
            }

            .small-box>.inner {
                padding: 20px;
            }

            .small-box h3 {
                font-size: 2.2rem;
                font-weight: 700;
                margin: 0 0 10px 0;
                white-space: nowrap;
                padding: 0;
            }

            .small-box p {
                font-size: 1rem;
            }

            .small-box .small-box-icon {
                position: absolute;
                right: 15px;
                top: 15px;
                font-size: 3.5rem;
                color: rgba(0, 0, 0, 0.15);
            }

            .small-box .small-box-footer {
                background: rgba(0, 0, 0, 0.1);
                color: #fff;
                display: block;
                padding: 3px 0;
                position: relative;
                text-align: center;
                text-decoration: none;
                z-index: 10;
            }

            .small-box .small-box-footer:hover {
                background: rgba(0, 0, 0, 0.15);
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // مخطط المبيعات
                const salesCtx = document.getElementById('salesChart').getContext('2d');
                const salesData = {
                    labels: {!! json_encode($monthlySales->pluck('month')) !!},
                    datasets: [{
                        label: 'المبيعات الشهرية ($)',
                        data: {!! json_encode($monthlySales->pluck('total')) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                };
                new Chart(salesCtx, {
                    type: 'line',
                    data: salesData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        plugins: {
                            legend: { labels: { font: { size: 14 } } }
                        }
                    }
                });

                // مخطط أنواع الطلبات
                const typeCtx = document.getElementById('orderTypeChart').getContext('2d');
                const typeData = {
                    labels: {!! json_encode($orderTypes->pluck('type')) !!},
                    datasets: [{
                        data: {!! json_encode($orderTypes->pluck('count')) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                };
                new Chart(typeCtx, {
                    type: 'doughnut',
                    data: typeData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { font: { size: 14 } }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection