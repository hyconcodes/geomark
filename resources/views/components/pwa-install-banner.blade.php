<!-- PWA Install Banner -->
<div id="pwa-install-banner" class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-lg transform -translate-y-full transition-transform duration-300 ease-in-out" style="display: none;">
    <div class="max-w-7xl mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-semibold">Install GeoMark App</h3>
                    <p class="text-xs opacity-90">Get the full app experience with offline access and push notifications</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <button id="pwa-install-banner-btn" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Install</span>
                </button>
                
                <button id="pwa-banner-close" class="text-white hover:text-gray-200 p-1 rounded transition-colors duration-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- PWA Install Modal -->
<div id="pwa-install-modal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-blue-500 to-green-500 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Install GeoMark</h3>
                <p class="text-gray-600 text-center mb-6">Install our app for a better experience with offline access, push notifications, and faster loading.</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">Works offline</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">Faster loading</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">Push notifications</span>
                    </div>
                </div>
                
                <div class="flex space-x-3">
                    <button id="pwa-modal-install" class="flex-1 bg-gradient-to-r from-blue-600 to-green-600 text-white py-3 px-4 rounded-lg font-medium hover:from-blue-700 hover:to-green-700 transition-colors duration-200">
                        Install App
                    </button>
                    <button id="pwa-modal-close" class="px-4 py-3 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        Not now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const banner = document.getElementById('pwa-install-banner');
    const modal = document.getElementById('pwa-install-modal');
    const bannerBtn = document.getElementById('pwa-install-banner-btn');
    const bannerClose = document.getElementById('pwa-banner-close');
    const modalInstall = document.getElementById('pwa-modal-install');
    const modalClose = document.getElementById('pwa-modal-close');
    
    let deferredPrompt;
    let isInstallable = false;
    
    // Check if already dismissed
    const isDismissed = localStorage.getItem('pwa-banner-dismissed');
    const isInstalled = localStorage.getItem('pwa-installed') === 'true';
    
    // Listen for beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        isInstallable = true;
        
        // Show banner if not dismissed and not installed
        if (!isDismissed && !isInstalled) {
            showBanner();
        }
    });
    
    // Listen for app installed event
    window.addEventListener('appinstalled', () => {
        localStorage.setItem('pwa-installed', 'true');
        hideBanner();
        hideModal();
    });
    
    function showBanner() {
        if (banner) {
            banner.style.display = 'block';
            setTimeout(() => {
                banner.classList.remove('-translate-y-full');
            }, 100);
        }
    }
    
    function hideBanner() {
        if (banner) {
            banner.classList.add('-translate-y-full');
            setTimeout(() => {
                banner.style.display = 'none';
            }, 300);
        }
    }
    
    function showModal() {
        if (modal) {
            modal.classList.remove('hidden');
        }
    }
    
    function hideModal() {
        if (modal) {
            modal.classList.add('hidden');
        }
    }
    
    async function installApp() {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            
            if (outcome === 'accepted') {
                localStorage.setItem('pwa-installed', 'true');
            }
            
            deferredPrompt = null;
            hideBanner();
            hideModal();
        }
    }
    
    // Event listeners
    if (bannerBtn) {
        bannerBtn.addEventListener('click', showModal);
    }
    
    if (bannerClose) {
        bannerClose.addEventListener('click', () => {
            localStorage.setItem('pwa-banner-dismissed', Date.now());
            hideBanner();
        });
    }
    
    if (modalInstall) {
        modalInstall.addEventListener('click', installApp);
    }
    
    if (modalClose) {
        modalClose.addEventListener('click', hideModal);
    }
    
    // Close modal when clicking outside
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                hideModal();
            }
        });
    }
    
    // Show banner again after 7 days if dismissed
    if (isDismissed) {
        const dismissedTime = parseInt(isDismissed);
        const sevenDays = 7 * 24 * 60 * 60 * 1000;
        
        if (Date.now() - dismissedTime > sevenDays && !isInstalled && isInstallable) {
            localStorage.removeItem('pwa-banner-dismissed');
            showBanner();
        }
    }
});
</script>