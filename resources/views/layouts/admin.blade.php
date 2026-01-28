<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>لوحة التحكم | @yield('title', 'AdminLTE 4')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <!-- Third Party Plugin(OverlayScrollbars) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />

    <!-- Third Party Plugin(Bootstrap Icons) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.rtl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('adminlte/css/custom_fixes.css') }}" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f6f9;
        }

        /* Modern Modal Styling */
        .modal-content-premium {
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
        }

        .modal-header-premium {
            background-color: #1e293b;
            color: white;
            border-bottom: none;
            padding: 1.5rem 2rem;
        }

        .modal-header-premium .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .modal-header-premium .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-title-premium {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .modal-body-premium {
            padding: 2rem;
            max-height: 85vh;
            overflow-y: auto;
        }

        /* Loading Spinner */
        .loading-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem;
        }

        .modern-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #0d6efd;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Mobile Responsiveness Enhancements */
        @media (max-width: 768px) {
            .app-content {
                padding: 0.5rem;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-body-premium {
                padding: 1.5rem 1rem;
            }

            .modal-header-premium {
                padding: 1rem 1.5rem;
            }

            .table-responsive {
                border: 0;
            }

            .project-actions {
                white-space: nowrap;
            }
        }

        /* Custom Scrollbar for Modal */
        .modal-body-premium::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body-premium::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .modal-body-premium::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .modal-body-premium::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }

        /* Ensure content inside modal looks good */
        .modal-body-premium .card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .modal-body-premium .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
        }

        .modal-content-fade {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <style>
        #top-banner {
            width: 100%;
            display: block;
            max-height: 150px;
            overflow: hidden;
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

    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            <span class="d-none d-md-inline">المسؤول</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat float-end">تسجيل الخروج</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="{{ url('/admin') }}" class="brand-link">
                    <span class="brand-text fw-light">لوحة التحكم</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                        data-accordion="true">

                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>الرئيسية</p>
                            </a>
                        </li>

                        <li class="nav-header">القائمة الرئيسية</li>

                        <li
                            class="nav-item {{ request()->routeIs('admin.orders.*', 'admin.payments.*', 'admin.customers.*', 'admin.products.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi- briefcase-fill text-info"></i>
                                <p>
                                    طلبات
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-cart-check"></i>
                                        <p>ادارة الطلبات (Orders)</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.payments.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-cash-stack"></i>
                                        <p>سداد المبالغ (Payments)</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.customers.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-people-fill"></i>
                                        <p>دليل العملاء</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.products.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-box-seam"></i>
                                        <p>أنواع الملابس/المنتجات</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="nav-item {{ request()->routeIs('admin.settings.*', 'admin.slides.*', 'admin.services.*', 'admin.portfolios.*', 'admin.posts.*', 'admin.members.*', 'admin.users.*', 'admin.categories.*', 'admin.skills.*', 'admin.timelines.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-gear-fill text-warning"></i>
                                <p>
                                    إعدادات الموقع
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.settings.edit') }}"
                                        class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-sliders"></i>
                                        <p>الإعدادات العامة</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.slides.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-images"></i>
                                        <p>الشرائح (السلايدر)</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.services.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-gear-wide-connected"></i>
                                        <p>الخدمات</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.portfolios.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.portfolios.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-briefcase"></i>
                                        <p>أعمالنا</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.posts.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-journal-text"></i>
                                        <p>المقالات</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.members.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-people"></i>
                                        <p>أعضاء الفريق</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-person-badge"></i>
                                        <p>المستخدمين</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-tags"></i>
                                        <p>الأقسام</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.skills.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-lightning"></i>
                                        <p>المهارات</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.timelines.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.timelines.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-calendar-event"></i>
                                        <p>التايم لاين</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item mt-3">
                            <hr class="text-secondary">
                            <a href="{{ url('/') }}" class="nav-link" target="_blank">
                                <i class="nav-icon bi bi-globe text-success"></i>
                                <p>عرض الموقع</p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">

                        @if($setting && $setting->top_banner)
                            <div id="top-banner" class="col-12 mb-3">
                                <img src="{{ asset($setting->top_banner) }}" alt="Banner">
                            </div>
                        @endif
                        <div class="col-sm-6">

                            <h3 class="mb-0">@yield('title')</h3>
                        </div>
                    </div>
                </div>
            </div>


            <div class="app-content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </main>

        <footer class="app-footer">
            <strong>جميع الحقوق محفوظة &copy; {{ date('Y') }} .</strong>
        </footer>
    </div>

    <!-- Global Modal for Quick View -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content modal-content-premium">
                <div class="modal-header modal-header-premium">
                    <h5 class="modal-title modal-title-premium" id="quickViewModalLabel">التفاصيل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-body-premium" id="quickViewModalBody">
                    <div class="loading-container">
                        <div class="modern-spinner"></div>
                        <p class="mt-3 text-muted">جاري تحميل البيانات...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>

    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }

            // Quick View Modal Logic
            const quickViewModalElement = document.getElementById('quickViewModal');
            const quickViewModalBody = document.getElementById('quickViewModalBody');
            const quickViewModalLabel = document.getElementById('quickViewModalLabel');
            let bootstrapModal = null;

            document.querySelectorAll('.view-trigger').forEach(trigger => {
                trigger.addEventListener('click', function (e) {
                    // Don't trigger if clicked on a button or link inside
                    if (e.target.closest('button') || e.target.closest('a') || e.target.closest('form')) {
                        return;
                    }

                    const url = this.getAttribute('data-view-url');
                    const title = this.getAttribute('data-view-title') || 'التفاصيل';
                    
                    if (!url) return;

                    quickViewModalLabel.innerText = title;
                    quickViewModalBody.innerHTML = `
                        <div class="loading-container">
                            <div class="modern-spinner"></div>
                            <p class="mt-3 text-muted">جاري تحميل البيانات...</p>
                        </div>
                    `;
                    
                    if (!bootstrapModal) {
                        bootstrapModal = new bootstrap.Modal(quickViewModalElement);
                    }
                    bootstrapModal.show();

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const content = doc.querySelector('#modal-content-area') || doc.querySelector('.app-content') || doc.body;
                        
                        // Clean up content for modal display
                        content.querySelectorAll('.btn-secondary, .btn-link, .btn-default').forEach(btn => {
                            const btnText = btn.innerText.trim();
                            if (btnText.includes('رجوع') || btnText.includes('Back') || btnText.includes('قائمة')) {
                                btn.remove();
                            }
                        });

                        // Make images responsive
                        content.querySelectorAll('img').forEach(img => {
                            img.classList.add('img-fluid', 'rounded-3', 'shadow-sm');
                        });

                        // Set content with a fade-in effect
                        quickViewModalBody.innerHTML = `<div class="modal-content-fade">${content.innerHTML}</div>`;
                        
                        // Re-initialize any components if needed (e.g., tabs)
                        const tabs = quickViewModalBody.querySelectorAll('[data-bs-toggle="tab"]');
                        tabs.forEach(tabEl => {
                            tabEl.addEventListener('click', (e) => {
                                e.preventDefault();
                                const tab = new bootstrap.Tab(tabEl);
                                tab.show();
                            });
                        });
                    })
                    .catch(error => {
                        quickViewModalBody.innerHTML = `
                            <div class="alert alert-danger d-flex align-items-center m-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>حدث خطأ أثناء تحميل البيانات. يرجى المحاولة مرة أخرى.</div>
                            </div>
                        `;
                        console.error('Error fetching modal content:', error);
                    });
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>