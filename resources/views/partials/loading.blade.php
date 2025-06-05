<!-- Loading Spinner -->
<div id="loading-spinner" class="fixed inset-0 bg-white dark:bg-gray-900 flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="flex flex-col items-center">
        <!-- Spinner -->
        <div class="relative">
            <div class="w-16 h-16 border-4 border-blue-200 border-solid rounded-full animate-spin"></div>
            <div class="absolute top-0 left-0 w-16 h-16 border-4 border-transparent border-t-blue-600 border-solid rounded-full animate-spin"></div>
        </div>
        
        <!-- Loading Text -->
        <div class="mt-4 text-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">MikroTik RADIUS</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Loading...</p>
        </div>
        
        <!-- Progress Dots -->
        <div class="flex space-x-1 mt-4">
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
        </div>
    </div>
</div>

<script>
    // Hide loading spinner when page is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const spinner = document.getElementById('loading-spinner');
            if (spinner) {
                spinner.style.opacity = '0';
                setTimeout(function() {
                    spinner.style.display = 'none';
                }, 300);
            }
        }, 1000); // Show spinner for at least 1 second
    });
</script> 