<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'MikroTik RADIUS Management')</title>
    
    <!-- Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'MikroTik RADIUS Management System for Network Access Control')">
    <meta name="keywords" content="mikrotik, radius, nas, network, management, authentication">
    <meta name="author" content="MikroTik RADIUS Team">
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Layout Styles -->
    <style>
        /* Base Layout */
        .app-layout {
            min-height: 100vh;
            background-color: rgb(249 250 251);
        }
        
        .dark .app-layout {
            background-color: rgb(17 24 39);
        }
        
        /* Fixed Sidebar */
        .fixed-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 16rem; /* w-64 */
            z-index: 40;
            background-color: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .dark .fixed-sidebar {
            background-color: rgb(31 41 55);
        }
        
        /* Show sidebar on desktop */
        @media (min-width: 1024px) {
            .fixed-sidebar {
                transform: translateX(0);
            }
        }
        
        .fixed-sidebar.open {
            transform: translateX(0);
        }
        
        /* Fixed Navbar */
        .fixed-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 4rem; /* h-16 */
            z-index: 30;
            background-color: white;
            border-bottom: 1px solid rgb(229 231 235);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
        
        @media (min-width: 1024px) {
            .fixed-navbar {
                left: 16rem; /* Start after sidebar on desktop */
            }
        }
        
        .dark .fixed-navbar {
            background-color: rgb(31 41 55);
            border-bottom-color: rgb(75 85 99);
        }
        
        /* Main content with proper spacing */
        .main-content {
            padding-top: 4rem; /* Top padding for fixed navbar */
            min-height: 100vh;
        }
        
        @media (min-width: 1024px) {
            .main-content {
                margin-left: 16rem; /* Left margin for fixed sidebar */
            }
        }
        
        /* Content area */
        .content-area {
            padding: 1.5rem;
            min-height: calc(100vh - 4rem);
        }
        
        @media (min-width: 640px) {
            .content-area {
                padding: 2rem;
            }
        }
        
        @media (min-width: 1024px) {
            .content-area {
                padding: 2rem 3rem;
            }
        }
        
        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 35;
            display: none;
        }
        
        .mobile-overlay.active {
            display: block;
        }
        
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        /* Ensure dropdowns are on top */
        .dropdown-menu {
            z-index: 9999;
        }
        
        /* Page header spacing */
        .page-header {
            background-color: white;
            border-bottom: 1px solid rgb(229 231 235);
            padding: 1rem 0;
        }
        
        .dark .page-header {
            background-color: rgb(31 41 55);
            border-bottom-color: rgb(75 85 99);
        }
        
        /* Breadcrumb spacing */
        .breadcrumb-nav {
            background-color: rgb(249 250 251);
            border-bottom: 1px solid rgb(229 231 235);
            padding: 0.75rem 0;
        }
        
        .dark .breadcrumb-nav {
            background-color: rgb(17 24 39);
            border-bottom-color: rgb(75 85 99);
        }
        
        /* Content container */
        .content-container {
            /* max-width: 80rem; max-w-6xl */
            margin: 0 auto;
            width: 100%;
        }
        
        /* Cards and sections */
        .content-section {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }
        
        .dark .content-section {
            background-color: rgb(31 41 55);
        }
        
        /* Hero section */
        .hero-section {
            background: linear-gradient(135deg, rgb(37 99 235) 0%, rgb(29 78 216) 100%);
            border-radius: 0.75rem;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            text-align: center;
            color: white;
        }
        
        /* Stats grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        /* Features grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        /* Button Utilities - Ensure proper contrast */
        .btn-primary {
            background-color: rgb(37 99 235);
            color: white;
            border: 1px solid rgb(37 99 235);
        }
        
        .btn-primary:hover {
            background-color: rgb(29 78 216);
            border-color: rgb(29 78 216);
        }
        
        .btn-secondary {
            background-color: white;
            color: rgb(55 65 81);
            border: 1px solid rgb(209 213 219);
        }
        
        .btn-secondary:hover {
            background-color: rgb(249 250 251);
            color: rgb(17 24 39);
        }
        
        .dark .btn-secondary {
            background-color: rgb(31 41 55);
            color: rgb(209 213 219);
            border-color: rgb(75 85 99);
        }
        
        .dark .btn-secondary:hover {
            background-color: rgb(55 65 81);
            color: rgb(243 244 246);
        }
        
        .btn-success {
            background-color: rgb(34 197 94);
            color: white;
            border: 1px solid rgb(34 197 94);
        }
        
        .btn-success:hover {
            background-color: rgb(22 163 74);
            border-color: rgb(22 163 74);
        }
        
        .btn-warning {
            background-color: rgb(245 158 11);
            color: white;
            border: 1px solid rgb(245 158 11);
        }
        
        .btn-warning:hover {
            background-color: rgb(217 119 6);
            border-color: rgb(217 119 6);
        }
        
        .btn-danger {
            background-color: rgb(239 68 68);
            color: white;
            border: 1px solid rgb(239 68 68);
        }
        
        .btn-danger:hover {
            background-color: rgb(220 38 38);
            border-color: rgb(220 38 38);
        }
        
        /* Ensure all buttons have proper contrast */
        button, .btn, a.btn {
            transition: all 0.2s ease-in-out;
        }
        
        /* Fix any white text on white background issues */
        .bg-white button,
        .bg-white .btn {
            color: rgb(55 65 81) !important;
        }
        
        .bg-white button:hover,
        .bg-white .btn:hover {
            color: rgb(17 24 39) !important;
        }
        
        /* Ensure dark mode buttons are readable */
        .dark .bg-gray-800 button,
        .dark .bg-gray-800 .btn {
            color: rgb(209 213 219) !important;
        }
        
        .dark .bg-gray-800 button:hover,
        .dark .bg-gray-800 .btn:hover {
            color: rgb(243 244 246) !important;
        }
    </style>
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased app-layout">
    <!-- Loading Spinner -->
    @include('partials.loading')
    
    <!-- Fixed Sidebar -->
    <div class="fixed-sidebar" id="sidebar">
        @include('partials.sidebar')
    </div>
    
    <!-- Fixed Top Navigation -->
    <div class="fixed-navbar">
        @include('partials.navbar')
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Breadcrumb -->
        @if(View::hasSection('breadcrumb'))
            <nav class="breadcrumb-nav">
                <div class="px-4 sm:px-6 lg:px-8">
                    @yield('breadcrumb')
                </div>
            </nav>
        @endif
        
        <!-- Alerts -->
        @include('partials.alerts')
        
        <!-- Main Content Area -->
        <main class="content-area custom-scrollbar">
            <div class="content-container">
                @yield('content')
            </div>
        </main>
        
        <!-- Footer -->
        @include('partials.footer')
    </div>
    
    <!-- Mobile Menu Overlay -->
    <div class="mobile-overlay" id="mobile-overlay"></div>
    
    <!-- Additional Scripts -->
    @stack('scripts')
    
    <!-- Layout Scripts -->
    <script>
        // Theme Toggle Functionality
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = localStorage.getItem('theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.classList.remove(currentTheme);
            html.classList.add(newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Update theme toggle button
            const themeToggle = document.getElementById('theme-toggle');
            if (themeToggle) {
                const icon = themeToggle.querySelector('i');
                if (newTheme === 'dark') {
                    icon.className = 'fas fa-sun text-lg';
                } else {
                    icon.className = 'fas fa-moon text-lg';
                }
            }
        }
        
        // Mobile menu toggle
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            if (sidebar && overlay) {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
                
                // Prevent body scroll when menu is open
                if (sidebar.classList.contains('open')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
        }
        
        // Close mobile menu when clicking overlay
        document.getElementById('mobile-overlay')?.addEventListener('click', function() {
            toggleMobileMenu();
        });
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize theme
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.classList.add(savedTheme);
            
            // Update theme toggle button
            const themeToggle = document.getElementById('theme-toggle');
            if (themeToggle) {
                const icon = themeToggle.querySelector('i');
                if (savedTheme === 'dark') {
                    icon.className = 'fas fa-sun text-lg';
                } else {
                    icon.className = 'fas fa-moon text-lg';
                }
            }
            
            // Handle window resize
            function handleResize() {
                if (window.innerWidth >= 1024) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('mobile-overlay');
                    if (sidebar && overlay) {
                        sidebar.classList.remove('open');
                        overlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }
            }
            
            window.addEventListener('resize', handleResize);
            handleResize(); // Initial check
            
            // Add smooth scrolling
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
        });
        
        // Error handling
        window.addEventListener('error', function(e) {
            console.warn('Layout error:', e.error);
        });
    </script>
</body>
</html>
