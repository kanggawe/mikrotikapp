<!-- Left Sidebar Navigation -->
<aside class="h-full bg-white dark:bg-gray-800 shadow-lg overflow-y-auto custom-scrollbar">
    <!-- Logo/Brand -->
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-network-wired text-white text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">MikroTik</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">RADIUS Management</p>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-2">
        <!-- Dashboard Section -->
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Dashboard</h3>
            
            <!-- Home -->
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <i class="fas fa-home mr-3 text-lg {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400' }}"></i>
                Home
            </a>

            <!-- Account -->
            <a href="{{ route('account.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-user-circle mr-3 text-lg text-gray-400"></i>
                Account
            </a>

            <!-- FTTH -->
            <a href="{{ route('ftth.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-ethernet mr-3 text-lg text-gray-400"></i>
                FTTH
            </a>
        </div>

        <!-- Radius Section -->
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Radius</h3>
            
            <!-- NAS Devices -->
            <a href="{{ route('nas.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('nas.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <i class="fas fa-server mr-3 text-lg {{ request()->routeIs('nas.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400' }}"></i>
                NAS Devices
            </a>

            <!-- PPP-DHCP Dropdown -->
            <div class="relative">
                <button onclick="toggleSubmenu('ppp-dhcp-menu')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center">
                        <i class="fas fa-network-wired mr-3 text-lg text-gray-400"></i>
                        PPP-DHCP
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="ppp-dhcp-chevron"></i>
                </button>
                <div id="ppp-dhcp-menu" class="hidden ml-6 mt-1 space-y-1">
                    <a href="{{ route('ppp.users') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-users mr-2 text-xs"></i>
                        Users
                    </a>
                    <a href="{{ route('ppp.groups') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-layer-group mr-2 text-xs"></i>
                        Groups
                    </a>
                    <a href="{{ route('ppp.accounting') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-chart-line mr-2 text-xs"></i>
                        Accounting
                    </a>
                </div>
            </div>

            <!-- Hotspot Dropdown -->
            <div class="relative">
                <button onclick="toggleSubmenu('hotspot-menu')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center">
                        <i class="fas fa-wifi mr-3 text-lg text-gray-400"></i>
                        Hotspot
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="hotspot-chevron"></i>
                </button>
                <div id="hotspot-menu" class="hidden ml-6 mt-1 space-y-1">
                    <a href="{{ route('hotspot.users') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-users mr-2 text-xs"></i>
                        Users & Vouchers
                    </a>
                    <a href="{{ route('hotspot.profiles') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-layer-group mr-2 text-xs"></i>
                        Profiles
                    </a>
                    <a href="{{ route('hotspot.sessions') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-chart-bar mr-2 text-xs"></i>
                        Sessions
                    </a>
                </div>
            </div>

            <!-- RADIUS Setting Dropdown -->
            <div class="relative">
                <button onclick="toggleSubmenu('radius-setting-menu')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center">
                        <i class="fas fa-cog mr-3 text-lg text-gray-400"></i>
                        RADIUS Setting
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="radius-setting-chevron"></i>
                </button>
                <div id="radius-setting-menu" class="hidden ml-6 mt-1 space-y-1">
                    <a href="{{ route('settings') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-server mr-2 text-xs"></i>
                        Server Config
                    </a>
                    <a href="{{ route('auth-logs') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-history mr-2 text-xs"></i>
                        Auth Logs
                    </a>
                </div>
            </div>
        </div>

        <!-- Billing Section -->
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Billing</h3>
            
            <!-- Member -->
            <a href="{{ route('billing.member') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-id-card mr-3 text-lg text-gray-400"></i>
                Member
            </a>

            <!-- Invoice -->
            <a href="{{ route('billing.invoice') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-file-invoice mr-3 text-lg text-gray-400"></i>
                Invoice
            </a>

            <!-- Transaction -->
            <a href="{{ route('billing.transaction') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-credit-card mr-3 text-lg text-gray-400"></i>
                Transaction
            </a>

            <!-- Referral -->
            <a href="{{ route('billing.referral') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-users-cog mr-3 text-lg text-gray-400"></i>
                Referral
            </a>

            <!-- Report Dropdown -->
            <div class="relative">
                <button onclick="toggleSubmenu('report-menu')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center">
                        <i class="fas fa-chart-pie mr-3 text-lg text-gray-400"></i>
                        Report
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="report-chevron"></i>
                </button>
                <div id="report-menu" class="hidden ml-6 mt-1 space-y-1">
                    <a href="{{ route('report.usage') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-chart-line mr-2 text-xs"></i>
                        Usage
                    </a>
                    <a href="{{ route('report.financial') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-file-alt mr-2 text-xs"></i>
                        Financial
                    </a>
                    <a href="{{ route('report.export') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-download mr-2 text-xs"></i>
                        Export
                    </a>
                </div>
            </div>

            <!-- Payment Channel Dropdown -->
            <div class="relative">
                <button onclick="toggleSubmenu('payment-menu')" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center">
                        <i class="fas fa-university mr-3 text-lg text-gray-400"></i>
                        Payment Channel
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="payment-chevron"></i>
                </button>
                <div id="payment-menu" class="hidden ml-6 mt-1 space-y-1">
                    <a href="{{ route('payment.ewallet') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-mobile-alt mr-2 text-xs"></i>
                        E-Wallet
                    </a>
                    <a href="{{ route('payment.bank') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-credit-card mr-2 text-xs"></i>
                        Bank
                    </a>
                    <a href="{{ route('payment.retail') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-store mr-2 text-xs"></i>
                        Retail
                    </a>
                </div>
            </div>

            <!-- Billing Setting -->
            <a href="{{ route('billing.settings') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-cog mr-3 text-lg text-gray-400"></i>
                Billing Setting
            </a>
        </div>

        <!-- Utility Section -->
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Utility</h3>
            
            <!-- Admin -->
            <a href="{{ route('utility.admin') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-user-shield mr-3 text-lg text-gray-400"></i>
                Admin
            </a>

            <!-- WhatsApp -->
            <a href="{{ route('utility.whatsapp') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fab fa-whatsapp mr-3 text-lg text-gray-400"></i>
                WhatsApp
            </a>

            <!-- Service -->
            <a href="{{ route('utility.service') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-tools mr-3 text-lg text-gray-400"></i>
                Service
            </a>

            <!-- Backup -->
            <a href="{{ route('utility.backup') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-cloud-download-alt mr-3 text-lg text-gray-400"></i>
                Backup
            </a>

            <!-- Map -->
            <a href="{{ route('utility.map') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-map-marked-alt mr-3 text-lg text-gray-400"></i>
                Map
            </a>

            <!-- Syslog -->
            <a href="{{ route('utility.syslog') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-file-alt mr-3 text-lg text-gray-400"></i>
                Syslog
            </a>

            <!-- Documentation -->
            <a href="{{ route('documentation') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-book mr-3 text-lg text-gray-400"></i>
                Documentation
            </a>

            <!-- Changelog -->
            <a href="{{ route('utility.changelog') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-list-alt mr-3 text-lg text-gray-400"></i>
                Changelog
            </a>
        </div>
    </nav>

    <!-- Bottom Section -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-700 mt-auto">
        <!-- Technical Support Button -->
        <a href="https://wa.me/6282126577254" target="_blank" rel="noopener noreferrer" class="w-full mb-4 inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
            <i class="fab fa-whatsapp mr-2"></i>
            Technical Support
        </a>
        
        <!-- Version Info -->
        <div class="text-center">
            <span class="inline-block px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 rounded">
                v1.0.0
            </span>
        </div>
    </div>
</aside>

<!-- Submenu Toggle Script -->
<script>
function toggleSubmenu(menuId) {
    const menu = document.getElementById(menuId);
    const chevron = document.getElementById(menuId.replace('-menu', '-chevron'));
    
    if (menu && chevron) {
        menu.classList.toggle('hidden');
        chevron.classList.toggle('rotate-180');
    }
}

// Close all submenus on mobile when sidebar is closed
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.getElementById('mobile-overlay');
    if (overlay) {
        overlay.addEventListener('click', function() {
            // Close all submenus
            const submenus = ['ppp-dhcp-menu', 'hotspot-menu', 'radius-setting-menu', 'report-menu', 'payment-menu'];
            submenus.forEach(menuId => {
                const menu = document.getElementById(menuId);
                const chevron = document.getElementById(menuId.replace('-menu', '-chevron'));
                if (menu && chevron) {
                    menu.classList.add('hidden');
                    chevron.classList.remove('rotate-180');
                }
            });
        });
    }
});
</script>
