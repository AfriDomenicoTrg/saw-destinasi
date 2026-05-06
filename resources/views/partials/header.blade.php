<header class="bg-white shadow-sm sticky top-0 z-20">
    <div class="px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between">
            <!-- Left side -->
            <div class="flex items-center space-x-4">
                <button onclick="toggleSidebar()" class="sidebar-toggle lg:hidden w-10 h-10 rounded-lg bg-gray-100 hover:bg-blue-50 transition-colors">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>

                <div class="hidden md:block">
                    <h2 class="text-gray-700 text-sm">
                        Selamat datang,
                        <span class="font-semibold text-blue-600"></span>
                    </h2>
                    <p class="text-xs text-gray-400 mt-0.5" id="currentDateTime"></p>
                </div>
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-3">
                <!-- Search -->
                <div class="hidden lg:block relative">
                    <input type="text"
                           id="searchInput"
                           placeholder="Cari data..."
                           class="w-80 pl-10 pr-4 py-2 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-all outline-none text-sm">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                </div>

                <!-- Notifications -->
                <div class="relative group">
                    <button class="relative w-9 h-9 rounded-lg bg-gray-100 hover:bg-blue-50 transition-colors">
                        <i class="fas fa-bell text-gray-600"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                </div>

                <!-- User Menu -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                    </button>

                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-100">
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-t-xl">
                            <i class="fas fa-user-circle w-4 mr-2"></i>
                            Profile
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-cog w-4 mr-2"></i>
                            Settings
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="#">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-b-xl">
                                <i class="fas fa-sign-out-alt w-4 mr-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        const dateTimeElement = document.getElementById('currentDateTime');
        if (dateTimeElement) {
            dateTimeElement.textContent = now.toLocaleDateString('id-ID', options);
        }
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>
