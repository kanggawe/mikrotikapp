@extends('layouts.app')

@section('title', 'Welcome - MikroTik RADIUS Management')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Welcome to MikroTik RADIUS Management System')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="mb-6">
        <i class="fas fa-network-wired text-6xl md:text-8xl opacity-90"></i>
    </div>
    <h1 class="text-3xl md:text-5xl font-bold mb-4">
        Welcome to MikroTik RADIUS
    </h1>
    <p class="text-lg md:text-xl opacity-90 mb-8 max-w-2xl mx-auto">
        Powerful Network Access Server management system for your MikroTik infrastructure. 
        Manage authentication, authorization, and accounting with ease.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('nas.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors duration-200 shadow-md">
            <i class="fas fa-server mr-2"></i>
            Manage NAS Devices
        </a>
        <a href="#features" class="inline-flex items-center px-6 py-3 bg-blue-800 text-white font-semibold rounded-lg hover:bg-blue-900 transition-colors duration-200 shadow-md">
            <i class="fas fa-info-circle mr-2"></i>
            Learn More
        </a>
    </div>
</div>

<!-- Quick Stats -->
<div class="stats-grid">
    <!-- Total NAS Devices -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-500 rounded-full">
                <i class="fas fa-server text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">NAS Devices</h3>
                <p class="text-2xl font-bold text-blue-600">0</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Active devices</p>
            </div>
        </div>
    </div>

    <!-- Active Users -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-500 rounded-full">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Active Users</h3>
                <p class="text-2xl font-bold text-green-600">0</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Currently online</p>
            </div>
        </div>
    </div>

    <!-- User Groups -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-500 rounded-full">
                <i class="fas fa-layer-group text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Groups</h3>
                <p class="text-2xl font-bold text-purple-600">0</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Configured groups</p>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-500 rounded-full">
                <i class="fas fa-heart text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">System Status</h3>
                <p class="text-xl font-bold text-green-600">Online</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">All systems operational</p>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div id="features" class="features-grid">
    <!-- NAS Management -->
    <div class="content-section p-6">
        <div class="flex items-start">
            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg flex-shrink-0">
                <i class="fas fa-server text-blue-600 dark:text-blue-400 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                    NAS Device Management
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                    Configure and monitor your Network Access Server devices. Manage IP addresses, 
                    shared secrets, and device types with an intuitive interface.
                </p>
                <a href="{{ route('nas.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                    Manage NAS Devices
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- User Authentication -->
    <div class="content-section p-6">
        <div class="flex items-start">
            <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg flex-shrink-0">
                <i class="fas fa-user-shield text-green-600 dark:text-green-400 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                    User Authentication
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                    Set up user authentication rules, manage user credentials, and configure 
                    authentication responses for your RADIUS clients.
                </p>
                <a href="{{ route('users.index') }}" class="inline-flex items-center text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 font-medium">
                    Manage Users
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Group Management -->
    <div class="content-section p-6">
        <div class="flex items-start">
            <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg flex-shrink-0">
                <i class="fas fa-layer-group text-purple-600 dark:text-purple-400 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                    Group Management
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                    Organize users into groups with shared policies. Define group-based 
                    authentication checks and replies for efficient user management.
                </p>
                <a href="{{ route('groups.index') }}" class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-medium">
                    Manage Groups
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Accounting & Logs -->
    <div class="content-section p-6">
        <div class="flex items-start">
            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex-shrink-0">
                <i class="fas fa-chart-line text-yellow-600 dark:text-yellow-400 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                    Accounting & Monitoring
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                    Track user sessions, monitor network usage, and analyze authentication 
                    logs. Get insights into your network access patterns.
                </p>
                <a href="{{ route('accounting') }}" class="inline-flex items-center text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-300 font-medium">
                    View Reports
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Getting Started -->
<div class="content-section p-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
            Getting Started
        </h2>
        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
            Follow these simple steps to set up your MikroTik RADIUS management system
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Step 1 -->
        <div class="text-center">
            <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                1
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                Add NAS Devices
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                Configure your MikroTik routers and access points as NAS devices with proper 
                IP addresses and shared secrets.
            </p>
            <a href="{{ route('nas.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-200 font-medium">
                <i class="fas fa-server mr-2"></i>
                Add Device
            </a>
        </div>

        <!-- Step 2 -->
        <div class="text-center">
            <div class="w-16 h-16 bg-green-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                2
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                Create User Groups
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                Set up user groups with specific authentication policies and access 
                levels for different types of users.
            </p>
            <a href="{{ route('groups.index') }}" class="inline-flex items-center px-4 py-2 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-200 dark:hover:bg-green-800 transition-colors duration-200 font-medium">
                <i class="fas fa-layer-group mr-2"></i>
                Create Groups
            </a>
        </div>

        <!-- Step 3 -->
        <div class="text-center">
            <div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                3
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                Add Users
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                Create user accounts with credentials and assign them to appropriate 
                groups for proper access control.
            </p>
            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded-lg hover:bg-purple-200 dark:hover:bg-purple-800 transition-colors duration-200 font-medium">
                <i class="fas fa-user-plus mr-2"></i>
                Add Users
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="content-section p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Common tasks</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('nas.create') }}" class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200">
            <i class="fas fa-plus-circle text-2xl text-gray-400 dark:text-gray-500 mb-2"></i>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Add NAS</span>
        </a>
        <a href="{{ route('users.index') }}" class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-green-500 dark:hover:border-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200">
            <i class="fas fa-user-plus text-2xl text-gray-400 dark:text-gray-500 mb-2"></i>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Add User</span>
        </a>
        <a href="{{ route('groups.index') }}" class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-purple-500 dark:hover:border-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors duration-200">
            <i class="fas fa-layer-group text-2xl text-gray-400 dark:text-gray-500 mb-2"></i>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Add Group</span>
        </a>
        <a href="{{ route('settings') }}" class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-gray-500 dark:hover:border-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors duration-200">
            <i class="fas fa-cog text-2xl text-gray-400 dark:text-gray-500 mb-2"></i>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Settings</span>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush
