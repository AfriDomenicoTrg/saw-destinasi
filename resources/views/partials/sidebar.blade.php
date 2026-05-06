<aside class="sidebar fixed lg:sticky inset-y-0 left-0 z-30 w-72 bg-gradient-to-b from-blue-800 to-blue-950 shadow-2xl transform -translate-x-full lg:translate-x-0 transition-all duration-300 ease-in-out overflow-y-auto">
<div class="h-full flex flex-col">
        <!-- Logo Area -->
        <div class="p-6 border-b border-blue-500/30">
            <div class="flex items-center space-x-3">
                <!-- Logo Image -->
                <div class="w-12 h-12 rounded-2xl overflow-hidden shadow-lg flex-shrink-0 bg-white/10 backdrop-blur-sm p-1">
                    <img src="{{ asset('images/logo.jpeg') }}"
                         alt="Logo SPK Wisata"
                         class="w-full h-full object-cover rounded-xl">
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white" style="font-family: 'Playfair Display', serif;">SPK Wisata</h1>
                    <p class="text-blue-200 text-xs font-medium mt-0.5">Administrator Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 pb-6 space-y-1">
            <br>
            <p class="text-blue-200 text-xs uppercase tracking-wider font-semibold mb-3 px-3">Main Menu</p>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="nav-item flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 group text-gray-100 hover:text-white">
                <i class="fas fa-chart-pie w-5 text-blue-300 group-hover:text-white transition-colors"></i>
                <span class="font-medium text-sm">Dashboard</span>
                <i class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transition-all"></i>
            </a>

            <p class="text-blue-200 text-xs uppercase tracking-wider font-semibold mt-6 mb-3 px-3">Master Data</p>

            <!-- Data Wisata -->
            <a href="{{ route('admin.wisata.index') }}"
               class="nav-item flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 group text-gray-100 hover:text-white">
                <i class="fas fa-umbrella-beach w-5 text-blue-300 group-hover:text-white transition-colors"></i>
                <span class="text-sm">Data Wisata</span>
                <i class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transition-all"></i>
            </a>

            <!-- Data Kriteria -->
            <a href="{{ route('admin.kriteria.index') }}"
               class="nav-item flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 group text-gray-100 hover:text-white">
                <i class="fas fa-sliders-h w-5 text-blue-300 group-hover:text-white transition-colors"></i>
                <span class="text-sm">Data Kriteria</span>
                <i class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transition-all"></i>
            </a>

            <!-- Penilaian -->
            <a href="{{ route('admin.penilaian.index') }}"
               class="nav-item flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 group text-gray-100 hover:text-white">
                <i class="fas fa-star w-5 text-blue-300 group-hover:text-white transition-colors"></i>
                <span class="text-sm">Penilaian</span>
                <i class="fas fa-chevron-right ml-auto text-xs opacity-0 group-hover:opacity-100 transition-all"></i>
            </a>

        </nav>

        <!-- Logout Button -->
        <div class="p-4 border-t border-blue-500/30">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-red-200 hover:text-white hover:bg-red-500/20 transition-all duration-300 group">
                    <i class="fas fa-sign-out-alt w-5 group-hover:rotate-180 transition-transform"></i>
                    <span class="font-medium text-sm">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile Overlay -->
<div class="sidebar-overlay fixed inset-0 bg-black/50 backdrop-blur-sm z-20 lg:hidden hidden transition-all duration-300"></div>

<style>
    .sidebar {
        scrollbar-width: thin;
    }

    .sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.3);
        border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,0.5);
    }

    /* Hover effect for nav items */
    .nav-item {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .nav-item:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateX(5px);
        padding-left: 20px;
    }

    /* Shimmer effect on hover */
    .nav-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s;
    }

    .nav-item:hover::before {
        left: 100%;
    }

    /* Active nav item style */
    .nav-active {
        background: rgba(255, 255, 255, 0.2);
        border-left: 3px solid #60a5fa;
        padding-left: 13px;
    }

    .nav-active i {
        color: white !important;
    }

    /* Logo image hover effect */
    .logo-img {
        transition: transform 0.3s ease;
    }

    .logo-img:hover {
        transform: scale(1.05);
    }

    /* Decorative line */
    .nav-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        margin: 8px 0;
    }
</style>
