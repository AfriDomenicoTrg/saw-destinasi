<!DOCTYPE html>
<html lang="id" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SPK Wisata Sumatera Utara')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @stack('styles')

    <style>
        /* ========================================
           RESET & VARIABLES (CLEAN & MODERN)
        ======================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4361ee;
            --primary-rgb: 67, 97, 238;
            --primary-dark: #3a56d4;
            --primary-light: #eef2ff;
            --secondary: #7209b7;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #0ea5e9;
            --dark: #0f172a;
            --light: #f8fafc;

            --sidebar-width: 270px;
            --sidebar-collapsed: 88px;
            --header-height: 70px;

            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        /* Light mode (default) */
        body {
            --bg-body: #f1f5f9;
            --bg-surface: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
            --card-bg: #ffffff;
            --header-bg: #ffffff;
            --sidebar-bg: #0f172a;
            --sidebar-border: #1e293b;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
        }

        /* Dark mode */
        body.dark-mode {
            --bg-body: #0f172a;
            --bg-surface: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-light: #334155;
            --card-bg: #1e293b;
            --header-bg: #1e293b;
            --sidebar-bg: #020617;
            --sidebar-border: #1e293b;
            --gray-100: #1f2937;
            --gray-200: #374151;
            --gray-300: #4b5563;
            --gray-400: #6b7280;
            --gray-500: #9ca3af;
            --gray-600: #d1d5db;
            --gray-700: #e5e7eb;
            --gray-800: #f3f4f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-primary);
            transition: background-color 0.2s ease, color 0.2s ease;
            line-height: 1.5;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--border-light);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        /* Layout Wrapper */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* ========================================
           SIDEBAR STYLES
        ======================================== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 1040;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar.collapsed .sidebar-brand-text,
        .sidebar.collapsed .sidebar-link-text,
        .sidebar.collapsed .sidebar-title span,
        .sidebar.collapsed .sidebar-badge {
            opacity: 0;
            visibility: hidden;
            display: none;
        }

        .sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .sidebar-brand {
            justify-content: center;
            padding: 20px 0;
        }

        .sidebar-brand {
            padding: 24px 24px;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .sidebar-brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
        }

        .sidebar-brand-text h4 {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0;
            color: white;
        }

        .sidebar-brand-text small {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .sidebar-menu {
            flex: 1;
            padding: 20px 0 30px;
        }

        .sidebar-title {
            padding: 16px 24px 8px 24px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 20px;
            margin: 4px 12px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            background: rgba(var(--primary-rgb), 0.12);
            color: var(--primary);
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: linear-gradient(95deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .sidebar-link-icon {
            width: 24px;
            font-size: 1.2rem;
            text-align: center;
        }

        .sidebar-link-text {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar-badge {
            background: var(--danger);
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 30px;
            margin-left: auto;
        }

        .sidebar-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--sidebar-border);
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ========================================
           HEADER - CLEAN & MODERN
        ======================================== */
        .app-header {
            height: var(--header-height);
            background: var(--header-bg);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-light);
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .header-action {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-header {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid var(--border-light);
            background: var(--bg-surface);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .btn-header:hover {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
        }

        /* Search Wrapper */
        .search-wrapper {
            position: relative;
            width: 320px;
            transition: all 0.3s ease;
        }

        .search-wrapper:focus-within {
            width: 380px;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.9rem;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            background: var(--gray-100);
            border: 1px solid var(--border-light);
            border-radius: 40px;
            padding: 10px 18px 10px 44px;
            font-size: 0.875rem;
            color: var(--text-primary);
            transition: all 0.25s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.15);
            background: var(--bg-surface);
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background: linear-gradient(135deg, var(--danger), #dc2626);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 16px 6px 8px;
            border-radius: 50px;
            background: var(--gray-100);
            border: 1px solid var(--border-light);
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .user-menu:hover {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-color: transparent;
        }

        .user-menu:hover .user-name,
        .user-menu:hover .user-role,
        .user-menu:hover i {
            color: white !important;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .user-info {
            line-height: 1.3;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-primary);
        }

        .user-role {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        /* Dropdown Custom */
        .dropdown-custom {
            border: none;
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
            background: var(--bg-surface);
            margin-top: 12px;
            min-width: 220px;
        }

        .dropdown-custom .dropdown-item {
            border-radius: 0.75rem;
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
            color: var(--text-primary);
            transition: all 0.2s;
        }

        .dropdown-custom .dropdown-item i {
            width: 20px;
            color: var(--primary);
        }

        .dropdown-custom .dropdown-item:hover {
            background: rgba(var(--primary-rgb), 0.1);
            color: var(--primary);
        }

        .dropdown-custom .dropdown-divider {
            margin: 0.5rem 0;
            border-color: var(--border-light);
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        /* Content Area */
        .content-area {
            padding: 28px 32px;
            flex: 1;
        }

        /* Cards modern */
        .card-modern {
            background: var(--card-bg);
            border: 1px solid var(--border-light);
            border-radius: 1.25rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
            overflow: hidden;
        }

        .card-modern:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        /* Alert styling clean */
        .alert-custom {
            border: none;
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            font-weight: 500;
        }

        /* Footer */
        .app-footer {
            background: var(--bg-surface);
            border-top: 1px solid var(--border-light);
            padding: 1rem 2rem;
            text-align: center;
            font-size: 0.8125rem;
            color: var(--text-muted);
        }

        /* Animations */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-slide-up {
            animation: fadeSlideUp 0.4s ease-out forwards;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0 !important;
            }
            .content-area {
                padding: 20px;
            }
            .search-wrapper {
                width: 240px;
            }
            .search-wrapper:focus-within {
                width: 280px;
            }
        }

        @media (max-width: 768px) {
            .app-header {
                padding: 0 16px;
            }
            .search-wrapper {
                width: 180px;
            }
            .search-wrapper:focus-within {
                width: 220px;
            }
            .user-info {
                display: none;
            }
            .user-menu {
                padding: 6px 10px;
            }
            .content-area {
                padding: 16px;
            }
        }

        @media (max-width: 480px) {
            .search-wrapper {
                display: none;
            }
            .btn-header {
                width: 38px;
                height: 38px;
            }
        }

        /* Utility */
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Table styles */
        .content-area .table {
            background-color: var(--bg-surface);
            border-radius: 1rem;
            overflow: hidden;
        }

        .content-area .table thead th {
            background-color: var(--bg-surface);
            border-bottom: 2px solid var(--border-light);
            color: var(--text-primary);
            font-weight: 600;
        }

        .content-area .table tbody tr:hover {
            background-color: rgba(var(--primary-rgb), 0.05);
        }

        /* Form styles */
        .form-control, .form-select {
            background-color: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: 0.75rem;
            padding: 0.6rem 1rem;
            color: var(--text-primary);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.2);
        }

        .btn-primary {
            background: linear-gradient(95deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 0.75rem;
            padding: 0.6rem 1.4rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Stat card */
        .stat-card {
            background: var(--card-bg);
            border-radius: 1.25rem;
            padding: 1.25rem;
            transition: all 0.2s;
            border: 1px solid var(--border-light);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-mountain-city"></i>
                </div>
                <div class="sidebar-brand-text">
                    <h4>Sumut Wisata</h4>
                    <small>SPK Rekomendasi</small>
                </div>
            </div>

            <div class="sidebar-menu">
                <div class="sidebar-title">MENU UTAMA</div>

                <a href="#" class="sidebar-link active">
                    <i class="fas fa-chart-pie sidebar-link-icon"></i>
                    <span class="sidebar-link-text">Dashboard</span>
                </a>

                <a href="#" class="sidebar-link">
                    <i class="fas fa-map-location-dot sidebar-link-icon"></i>
                    <span class="sidebar-link-text">Destinasi Wisata</span>
                </a>

                <a href="#" class="sidebar-link">
                    <i class="fas fa-sliders-h sidebar-link-icon"></i>
                    <span class="sidebar-link-text">Kriteria & Bobot</span>
                </a>

                <div class="sidebar-title">REKOMENDASI</div>

                <a href="#" class="sidebar-link">
                    <i class="fas fa-star sidebar-link-icon"></i>
                    <span class="sidebar-link-text">Hasil Perangkingan</span>
                    <span class="sidebar-badge">New</span>
                </a>

                <a href="#" class="sidebar-link">
                    <i class="fas fa-history sidebar-link-icon"></i>
                    <span class="sidebar-link-text">Riwayat</span>
                </a>

                <div class="sidebar-title">PENGATURAN</div>

                <a href="#" class="sidebar-link">
                    <i class="fas fa-users sidebar-link-icon"></i>
                    <span class="sidebar-link-text">Pengguna</span>
                </a>

                <a href="#" class="sidebar-link">
                    <i class="fas fa-cog sidebar-link-icon"></i>
                    <span class="sidebar-link-text">Konfigurasi</span>
                </a>
            </div>

            <div class="sidebar-footer">
                <i class="fas fa-shield-alt"></i>
                <span>SPK Wisata v2.0</span>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main-content" id="mainContent">
            <!-- HEADER - CLEAN & MODERN -->
            <header class="app-header">
                <div class="d-flex align-items-center gap-3">
                    <!-- Mobile menu toggle -->
                    <button class="btn-header d-lg-none" id="mobileToggle">
                        <i class="fas fa-bars"></i>
                    </button>

                    <!-- Search Component -->
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Cari destinasi atau kriteria...">
                    </div>
                </div>

                <div class="header-action">
                    <!-- Notifications -->
                    <div class="position-relative">
                        <button class="btn-header" id="notificationsBtn">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                    </div>

                    <!-- Theme Toggle -->
                    <button class="btn-header" id="themeToggle">
                        <i class="fas fa-moon"></i>
                    </button>

                    <!-- User Menu Dropdown -->
                    <div class="dropdown">
                        <div class="user-menu" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-info d-none d-md-block">
                                <div class="user-name">Administrator</div>
                                <div class="user-role">Super Admin</div>
                            </div>
                            <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-custom dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                                    <i class="fas fa-user-circle"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                                    <i class="fas fa-gear"></i> Pengaturan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="#">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                        <i class="fas fa-right-from-bracket"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            <!-- END HEADER -->

            <main class="content-area">
                <!-- Alert Notifications -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert" data-aos="fade-down">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle fs-5"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert" data-aos="fade-down">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation-triangle fs-5"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        (function() {
            // Initialize AOS
            AOS.init({
                duration: 600,
                once: true,
                offset: 20,
                easing: 'ease-out-cubic'
            });

            // Sidebar elements
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const mobileToggle = document.getElementById('mobileToggle');
            const themeToggle = document.getElementById('themeToggle');
            const notifBtn = document.getElementById('notificationsBtn');

            // Sidebar state for desktop
            function setSidebarState(collapsed) {
                if (collapsed) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                }
                localStorage.setItem('sidebarCollapsed', collapsed);
            }

            const savedSidebarState = localStorage.getItem('sidebarCollapsed');
            if (savedSidebarState === 'true') {
                setSidebarState(true);
            } else {
                setSidebarState(false);
            }

            // Mobile sidebar toggle
            function handleMobileSidebar() {
                if (window.innerWidth <= 992) {
                    if (mobileToggle) {
                        mobileToggle.addEventListener('click', function(e) {
                            e.preventDefault();
                            sidebar.classList.toggle('mobile-open');
                        });
                    }
                } else {
                    sidebar.classList.remove('mobile-open');
                }
            }

            // Theme management
            function setTheme(theme) {
                if (theme === 'dark') {
                    document.body.classList.add('dark-mode');
                    localStorage.setItem('theme', 'dark');
                    if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                } else {
                    document.body.classList.remove('dark-mode');
                    localStorage.setItem('theme', 'light');
                    if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                }
                document.documentElement.setAttribute('data-theme', theme);
            }

            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const initialTheme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
            setTheme(initialTheme);

            if (themeToggle) {
                themeToggle.addEventListener('click', () => {
                    const isDark = document.body.classList.contains('dark-mode');
                    setTheme(isDark ? 'light' : 'dark');
                });
            }

            // Notification demo
            if (notifBtn) {
                notifBtn.addEventListener('click', () => {
                    alert('📢 Notifikasi: Anda memiliki 3 pesan baru dan 1 update sistem');
                });
            }

            // Resize handler
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    sidebar.classList.remove('mobile-open');
                }
            });

            handleMobileSidebar();

            // Create overlay for mobile
            function createOverlay() {
                if (!document.querySelector('.sidebar-overlay') && window.innerWidth <= 992) {
                    const overlay = document.createElement('div');
                    overlay.className = 'sidebar-overlay';
                    overlay.style.cssText = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0,0,0,0.5);
                        z-index: 1035;
                        display: none;
                        backdrop-filter: blur(2px);
                    `;
                    document.body.appendChild(overlay);

                    overlay.addEventListener('click', () => {
                        sidebar.classList.remove('mobile-open');
                        overlay.style.display = 'none';
                    });

                    if (mobileToggle) {
                        mobileToggle.addEventListener('click', () => {
                            if (sidebar.classList.contains('mobile-open')) {
                                overlay.style.display = 'block';
                            } else {
                                overlay.style.display = 'none';
                            }
                        });
                    }
                }
            }
            createOverlay();

            // Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>
