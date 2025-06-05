<!-- Top Navigation Bar -->
<header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
        <!-- Left side - Mobile menu button and breadcrumb -->
        <div class="flex items-center">
            <!-- Mobile menu button -->
            <button onclick="toggleMobileMenu()" class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md p-2">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <!-- Page Title -->
            <div class="ml-4 lg:ml-0">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                    @yield('page_title', 'Dashboard')
                </h1>
                @if(View::hasSection('page_subtitle'))
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        @yield('page_subtitle')
                    </p>
                @endif
            </div>
        </div>

        <!-- Right side - Search, notifications, theme toggle, user menu -->
        <div class="flex items-center space-x-4">
            <!-- Search Bar -->
            <div class="hidden md:block">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           placeholder="Search..."
                           id="global-search">
                </div>
            </div>

            <!-- Notifications -->
            <div class="relative">
                <button onclick="toggleDropdown('notifications-dropdown')" class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md">
                    <i class="fas fa-bell text-lg"></i>
                    <!-- Notification badge -->
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-gray-800"></span>
                </button>
                
                <!-- Notifications dropdown -->
                <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700">
                    <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        <!-- Sample notifications -->
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-600">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-info text-white text-xs"></i>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">New NAS device connected</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">192.168.1.1 connected successfully</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">5 minutes ago</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-600">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-exclamation text-white text-xs"></i>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Authentication failed</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">User 'testuser' authentication failed</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">10 minutes ago</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                        <a href="#" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">View all notifications</a>
                    </div>
                </div>
            </div>

            <!-- Theme Toggle -->
            <button id="theme-toggle" onclick="toggleTheme()" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md">
                <i class="fas fa-moon text-lg"></i>
            </button>

            <!-- Quick Actions -->
            <div class="relative">
                <button onclick="toggleDropdown('quick-actions-dropdown')" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md">
                    <i class="fas fa-plus text-lg"></i>
                </button>
                
                <!-- Quick actions dropdown -->
                <div id="quick-actions-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700">
                    <a href="{{ route('nas.create') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-server mr-2"></i>Add NAS Device
                    </a>
                    <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-user-plus mr-2"></i>Add User
                    </a>
                    <a href="{{ route('groups.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-layer-group mr-2"></i>Add Group
                    </a>
                </div>
            </div>

            <!-- User Profile -->
            <div class="relative">
                <button onclick="toggleDropdown('user-dropdown')" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <span class="hidden md:block ml-2 text-gray-700 dark:text-gray-300 font-medium">Admin</span>
                    <i class="hidden md:block fas fa-chevron-down ml-1 text-xs text-gray-500 dark:text-gray-400"></i>
                </button>
                
                <!-- User dropdown -->
                <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700">
                    <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Admin User</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">admin@mikrotik.local</p>
                    </div>
                    <a href="{{ route('account.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-user-edit mr-2"></i>Edit Profile
                    </a>
                    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-cog mr-2"></i>Settings
                    </a>
                    <a href="{{ route('documentation') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-question-circle mr-2"></i>Help
                    </a>
                    <div class="border-t border-gray-200 dark:border-gray-700"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-sign-out-alt mr-2"></i>Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleDropdown(dropdownId) {
        // Close all other dropdowns first
        const allDropdowns = ['notifications-dropdown', 'quick-actions-dropdown', 'user-dropdown'];
        allDropdowns.forEach(id => {
            if (id !== dropdownId) {
                document.getElementById(id)?.classList.add('hidden');
            }
        });
        
        // Toggle the requested dropdown
        const dropdown = document.getElementById(dropdownId);
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = ['notifications-dropdown', 'quick-actions-dropdown', 'user-dropdown'];
        
        dropdowns.forEach(dropdownId => {
            const dropdown = document.getElementById(dropdownId);
            const button = event.target.closest(`button[onclick*="${dropdownId}"]`);
            
            if (dropdown && !button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // Search functionality
    document.getElementById('global-search')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value;
        // Implement search functionality here
        console.log('Searching for:', searchTerm);
    });
</script>