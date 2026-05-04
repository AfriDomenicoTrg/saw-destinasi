<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Wisata - Perbaikan Sidebar</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ========================================
           RESET TOTAL - DESAIN CLEAN & MODERN
           Sidebar yang rapi, tidak berantakan
        ======================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed: 88px;
            --header-height: 70px;

            /* Color System Modern */
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --primary-soft: #eef2ff;
            --secondary: #8b5cf6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #0ea5e9;

            /* Neutral Light Mode */
            --bg-body: #f1f5f9;
            --bg-surface: #ffffff;
            --bg-sidebar: #0f172a;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --text-sidebar: #e2e8f0;
            --text-sidebar-muted: #94a3b8;
            --border-light: #e2e8f0;
            --border-sidebar: #1e293b;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        /* Dark Mode */
        body.dark-mode {
            --bg-body: #0f172a;
            --bg-surface: #1e293b;
            --bg-sidebar: #020617;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-light: #334155;
            --border-sidebar: #1e293b;
            --text-sidebar: #e2e8f0;
            --text-sidebar-muted: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            transition: background 0.2s, color 0.2s;
            overflow-x: hidden;
        }

        /* Layout Wrapper */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* ========================================
           SIDEBAR SUPER CLEAN - TIDAK BERANTAKAN
        ======================================== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-sidebar);
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

        /* Custom scrollbar sidebar */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        /* Collapsed state */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar.collapsed .sidebar-brand-text,
        .sidebar.collapsed .sidebar-link-text,
        .sidebar.collapsed .sidebar-title span,
        .sidebar.collapsed .sidebar-badge,
        .sidebar.collapsed .sidebar-footer-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
            display: none;
        }

        .sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding: 12px 0;
            margin: 6px 12px;
        }

        .sidebar.collapsed .sidebar-link-icon {
            margin: 0;
            font-size: 1.3rem;
        }

        .sidebar.collapsed .sidebar-brand {
            justify-content: center;
            padding: 20px 0;
        }

        .sidebar.collapsed .sidebar-brand-icon {
            margin: 0 auto;
        }

        /* Sidebar Brand */
        .sidebar-brand {
            padding: 24px 24px;
            border-bottom: 1px solid var(--border-sidebar);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.2s;
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
            box-shadow: 0 8px 16px -4px rgba(99, 102, 241, 0.3);
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            flex: 1;
        }

        .sidebar-brand-text h4 {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0;
            color: white;
            letter-spacing: -0.3px;
        }

        .sidebar-brand-text small {
            font-size: 0.7rem;
            color: var(--text-sidebar-muted);
            font-weight: 500;
        }

        /* Menu Sections */
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
            color: var(--text-sidebar-muted);
        }

        /* Sidebar Links */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 20px;
            margin: 4px 12px;
            color: var(--text-sidebar);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            position: relative;
        }

        .sidebar-link:hover {
            background: rgba(99, 102, 241, 0.12);
            color: white;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: linear-gradient(95deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 6px 14px rgba(99, 102, 241, 0.35);
        }

        .sidebar-link.active .sidebar-link-icon {
            color: white;
        }

        .sidebar-link-icon {
            width: 24px;
            font-size: 1.2rem;
            text-align: center;
            flex-shrink: 0;
            color: var(--text-sidebar-muted);
            transition: color 0.2s;
        }

        .sidebar-link:hover .sidebar-link-icon {
            color: var(--primary-light);
        }

        .sidebar-link-text {
            font-size: 0.9rem;
            font-weight: 500;
            flex: 1;
            white-space: nowrap;
        }

        /* Badge */
        .sidebar-badge {
            background: var(--danger);
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 30px;
            line-height: 1.4;
            flex-shrink: 0;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--border-sidebar);
            font-size: 0.75rem;
            color: var(--text-sidebar-muted);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-footer i {
            font-size: 0.9rem;
            color: var(--primary-light);
        }

        /* ========================================
           MAIN CONTENT - RESPONSIF
        ======================================== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        /* Header Area */
        .top-header {
            background: var(--bg-surface);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-light);
            padding: 0 28px;
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* Toggle Button Sidebar */
        .toggle-sidebar-btn {
            background: transparent;
            border: none;
            font-size: 1.4rem;
            color: var(--text-secondary);
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-sidebar-btn:hover {
            background: var(--border-light);
            color: var(--primary);
        }

        /* Content Area */
        .content-area {
            padding: 30px 32px;
            flex: 1;
        }

        /* Cards & UI Elements */
        .card-dashboard {
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.25s;
            padding: 1.5rem;
        }

        .card-dashboard:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        /* Tombol Theme Toggle */
        .theme-toggle {
            background: var(--border-light);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            color: var(--text-primary);
            transition: all 0.2s;
        }

        .theme-toggle:hover {
            background: var(--primary);
            color: white;
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
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        /* Alert Clean */
        .alert-modern {
            border: none;
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            background: var(--bg-surface);
            border-left: 4px solid var(--primary);
            box-shadow: var(--shadow-sm);
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <!-- SIDEBAR - SEMUA BERANTAKAN SUDAH DIPERBAIKI -->
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
                <div class="sidebar-title">
                    <span>MENU UTAMA</span>
                </div>

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

                <div class="sidebar-title">
                    <span>REKOMENDASI</span>
                </div>

                <a href="#" class="sidebar-link">
                    <i class="fas fa-star sidebar-link-icon"></i>
                    <span class="sidebar-link-text">Hasil Perangkingan</span>
                    <span class="sidebar-badge">New</span>
                </a>

                <a href="#" class="sidebar-link">
                    <i class="fas fa-history sidebar-link-icon"></i>
                    <span class="sidebar-link-text">Riwayat Perhitungan</span>
                </a>

                <div class="sidebar-title">
                    <span>PENGATURAN</span>
                </div>

                <a href="#" class="sidebar-link">
                    <i class="fas fa-users sidebar-link-icon"></i>
                    <span class="sidebar-link-text">Manajemen Pengguna</span>
                </a>

                <a href="#" class="sidebar-link">
                    <i class="fas fa-cog sidebar-link-icon"></i>
                    <span class="sidebar-link-text">Konfigurasi Sistem</span>
                </a>
            </div>

            <div class="sidebar-footer">
                <i class="fas fa-shield-alt"></i>
                <span class="sidebar-footer-text">SPK Wisata Sumut v2.0</span>
            </div>
        </aside>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function() {
            // Sidebar Toggle dengan LocalStorage agar state tersimpan
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('sidebarToggleBtn');

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

            // Load state dari localStorage
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                setSidebarState(true);
            } else {
                setSidebarState(false);
            }

            // Event toggle
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    setSidebarState(!isCollapsed);
                });
            }

            // Dark Mode Toggle
            const themeBtn = document.getElementById('themeToggleBtn');
            function setTheme(theme) {
                if (theme === 'dark') {
                    document.body.classList.add('dark-mode');
                    localStorage.setItem('theme', 'dark');
                    if (themeBtn) themeBtn.innerHTML = '<i class="fas fa-sun"></i>';
                } else {
                    document.body.classList.remove('dark-mode');
                    localStorage.setItem('theme', 'light');
                    if (themeBtn) themeBtn.innerHTML = '<i class="fas fa-moon"></i>';
                }
            }

            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                setTheme('dark');
            } else {
                setTheme('light');
            }

            if (themeBtn) {
                themeBtn.addEventListener('click', () => {
                    const isDark = document.body.classList.contains('dark-mode');
                    setTheme(isDark ? 'light' : 'dark');
                });
            }

            // Responsive mobile: jika layar kecil, klik link sidebar bisa menutup otomatis
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            if (window.innerWidth <= 992) {
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        if (sidebar.classList.contains('mobile-open')) {
                            sidebar.classList.remove('mobile-open');
                        }
                    });
                });
            }

            // Untuk mobile, tambahkan overlay jika diperlukan - opsional
            function handleMobile() {
                if (window.innerWidth <= 992) {
                    if (!document.querySelector('.sidebar-overlay')) {
                        const overlay = document.createElement('div');
                        overlay.className = 'sidebar-overlay';
                        overlay.style.position = 'fixed';
                        overlay.style.top = 0;
                        overlay.style.left = 0;
                        overlay.style.width = '100%';
                        overlay.style.height = '100%';
                        overlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
                        overlay.style.zIndex = '1030';
                        overlay.style.display = 'none';
                        overlay.style.backdropFilter = 'blur(2px)';
                        document.body.appendChild(overlay);

                        overlay.addEventListener('click', () => {
                            sidebar.classList.remove('mobile-open');
                            overlay.style.display = 'none';
                        });
                    }

                    const overlay = document.querySelector('.sidebar-overlay');
                    if (toggleBtn) {
                        toggleBtn.addEventListener('click', () => {
                            if (sidebar.classList.contains('mobile-open')) {
                                sidebar.classList.remove('mobile-open');
                                overlay.style.display = 'none';
                            } else {
                                sidebar.classList.add('mobile-open');
                                overlay.style.display = 'block';
                            }
                        });
                    }
                } else {
                    const overlay = document.querySelector('.sidebar-overlay');
                    if (overlay) overlay.style.display = 'none';
                }
            }

            window.addEventListener('resize', handleMobile);
            handleMobile();
        })();
    </script>
</body>
</html>
