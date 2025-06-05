<!-- Footer -->
<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
    <div class="px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-col sm:flex-row items-center justify-between">
            <!-- Left side - Copyright -->
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                <span>&copy; {{ date('Y') }} MikroTik RADIUS Management.</span>
                <span class="hidden sm:inline ml-1">All rights reserved.</span>
            </div>
            
            <!-- Right side - Links and Info -->
            <div class="flex items-center space-x-4 mt-2 sm:mt-0 text-sm">
                <!-- Version Info -->
                <div class="flex items-center text-gray-500 dark:text-gray-400">
                    <i class="fas fa-code-branch text-xs mr-1"></i>
                    <span>v1.0.0</span>
                </div>
                
                <!-- Status Indicator -->
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">System Online</span>
                </div>
                
                <!-- Quick Links -->
                <div class="hidden md:flex items-center space-x-3 text-gray-500 dark:text-gray-400">
                    <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                        <i class="fas fa-question-circle text-sm mr-1"></i>
                        <span class="text-xs">Help</span>
                    </a>
                    <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                        <i class="fas fa-bug text-sm mr-1"></i>
                        <span class="text-xs">Report Issue</span>
                    </a>
                    <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                        <i class="fas fa-book text-sm mr-1"></i>
                        <span class="text-xs">Docs</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Additional Footer Info (on mobile) -->
        <div class="md:hidden mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Help</a>
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Report Issue</a>
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Documentation</a>
            </div>
        </div>
    </div>
</footer>
