<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SPK Wisata Admin') - Admin Panel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f9;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }

        /* Card Styles */
        .stat-card {
            background: white;
            border-radius: 16px;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            border-color: #3b82f6;
        }

        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead th {
            background: #f8fafc;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-table tbody td {
            padding: 12px 16px;
            font-size: 14px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .data-table tbody tr:hover {
            background: #f8fafc;
        }

        /* Button Styles */
        .btn-primary {
            background: #3b82f6;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        /* Active Nav */
        .nav-active {
            background: #eff6ff;
            color: #3b82f6 !important;
            border-right: 3px solid #3b82f6;
        }
    </style>

    @stack('styles')
</head>
<body class="antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar - Fixed width -->
        @include('partials.sidebar')

        <!-- Main Content - Takes remaining space -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <!-- Header -->
            @include('partials.header')

            <!-- Page Content - Scrollable -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Breadcrumb -->
                @hasSection('breadcrumb')
                    <div class="mb-4">
                        @yield('breadcrumb')
                    </div>
                @endif

                <!-- Page Title -->
                @hasSection('page-title')
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">@yield('page-title')</h1>
                        <p class="text-gray-500 text-sm mt-1">@yield('page-description', '')</p>
                    </div>
                @endif

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-50 border-l-4 border-green-500 text-green-700">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-700">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 rounded-lg bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700">
                        <div class="flex items-start">
                            <i class="fas fa-warning mr-3 mt-0.5"></i>
                            <div>
                                <strong>Perhatikan:</strong>
                                <ul class="mt-1 list-disc list-inside text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Main Content -->
                @yield('content')
            </main>

            <!-- Footer -->
            @include('partials.footer')
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.bg-green-50, .bg-red-50, .bg-yellow-50').forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(20px)';
                    setTimeout(() => alert.remove(), 300);
                }, 3000);
            });
        }, 1000);
    </script>

    @stack('scripts')
</body>
</html>
