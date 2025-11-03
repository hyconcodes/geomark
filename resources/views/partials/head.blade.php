<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<!-- PWA Meta Tags -->
<meta name="theme-color" content="#059669">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="GeoMark">
<meta name="description" content="Smart geolocation-based attendance system for educational institutions">
<meta name="format-detection" content="telephone=no">
<meta name="msapplication-TileColor" content="#059669">
<meta name="msapplication-tap-highlight" content="no">

<!-- PWA Icons and Manifest -->
<link rel="manifest" href="/manifest.webmanifest">
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="152x152" href="/pwa-icons/icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="167x167" href="/pwa-icons/icon-152x152.png">

<!-- Splash Screen Meta Tags for iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="apple-touch-startup-image" href="/pwa-icons/icon-512x512.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="/pwa-icons/icon-512x512.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="/pwa-icons/icon-512x512.png" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

<!-- PWA Service Worker Registration -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    
                    // Check for updates
                    registration.addEventListener('updatefound', () => {
                        const newWorker = registration.installing;
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                // New content is available, show update notification
                                if (confirm('New version available! Click OK to update.')) {
                                    window.location.reload();
                                }
                            }
                        });
                    });
                })
                .catch(function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
        });
    }

    // PWA Install Prompt with Enhanced User Preferences
    let deferredPrompt;
    let installButton = null;
    const PWA_STORAGE_KEY = 'geomark_pwa_preferences';

    // Get PWA preferences from localStorage
    function getPWAPreferences() {
        const stored = localStorage.getItem(PWA_STORAGE_KEY);
        return stored ? JSON.parse(stored) : {
            dismissed: false,
            dismissedAt: null,
            installPromptShown: false,
            userDismissedCount: 0
        };
    }

    // Save PWA preferences to localStorage
    function savePWAPreferences(preferences) {
        localStorage.setItem(PWA_STORAGE_KEY, JSON.stringify(preferences));
    }

    // Check if we should show install prompt based on user preferences
    function shouldShowInstallPrompt() {
        const prefs = getPWAPreferences();
        const now = Date.now();
        const daysSinceDismissal = prefs.dismissedAt ? (now - prefs.dismissedAt) / (1000 * 60 * 60 * 24) : 999;
        
        // Don't show if user dismissed recently (less than 7 days) or dismissed more than 3 times
        return !prefs.dismissed || (daysSinceDismissal > 7 && prefs.userDismissedCount < 3);
    }

    window.addEventListener('beforeinstallprompt', (e) => {
        console.log('PWA install prompt triggered');
        e.preventDefault();
        deferredPrompt = e;
        
        if (!shouldShowInstallPrompt()) {
            console.log('Install prompt suppressed due to user preferences');
            return;
        }
        
        // Show install button if it exists
        installButton = document.getElementById('pwa-install-btn');
        if (installButton) {
            installButton.style.display = 'block';
            installButton.addEventListener('click', installPWA);
        }

        // Trigger banner display event
        const bannerEvent = new CustomEvent('pwa-installable', { 
            detail: { deferredPrompt: deferredPrompt } 
        });
        window.dispatchEvent(bannerEvent);

        // Update preferences
        const prefs = getPWAPreferences();
        prefs.installPromptShown = true;
        savePWAPreferences(prefs);
    });

    function installPWA() {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                const prefs = getPWAPreferences();
                
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the PWA install prompt');
                    prefs.dismissed = false;
                    prefs.userDismissedCount = 0;
                } else {
                    console.log('User dismissed the PWA install prompt');
                    prefs.dismissed = true;
                    prefs.dismissedAt = Date.now();
                    prefs.userDismissedCount += 1;
                }
                
                savePWAPreferences(prefs);
                deferredPrompt = null;
                
                if (installButton) {
                    installButton.style.display = 'none';
                }

                // Hide banner
                const bannerHideEvent = new CustomEvent('pwa-install-completed');
                window.dispatchEvent(bannerHideEvent);
            });
        }
    }

    // Function to dismiss install prompt permanently
    function dismissInstallPrompt() {
        const prefs = getPWAPreferences();
        prefs.dismissed = true;
        prefs.dismissedAt = Date.now();
        prefs.userDismissedCount += 1;
        savePWAPreferences(prefs);
        
        if (installButton) {
            installButton.style.display = 'none';
        }

        // Hide banner
        const bannerHideEvent = new CustomEvent('pwa-install-dismissed');
        window.dispatchEvent(bannerHideEvent);
    }

    // Handle app installed
    window.addEventListener('appinstalled', (evt) => {
        console.log('PWA was installed');
        
        // Reset preferences since app is now installed
        const prefs = getPWAPreferences();
        prefs.dismissed = false;
        prefs.userDismissedCount = 0;
        savePWAPreferences(prefs);
        
        if (installButton) {
            installButton.style.display = 'none';
        }

        // Hide banner and show success message
        const bannerHideEvent = new CustomEvent('pwa-installed');
        window.dispatchEvent(bannerHideEvent);
    });

    // Make functions globally available
    window.installPWA = installPWA;
    window.dismissInstallPrompt = dismissInstallPrompt;
    window.getPWAPreferences = getPWAPreferences;

    // Offline attendance queue using IndexedDB
    function queueOfflineAttendance(attendanceData) {
        if (!('indexedDB' in window)) {
            console.log('IndexedDB not supported');
            return;
        }

        const request = indexedDB.open('GeoMarkOffline', 1);
        
        request.onerror = function() {
            console.error('IndexedDB error:', request.error);
        };
        
        request.onupgradeneeded = function() {
            const db = request.result;
            if (!db.objectStoreNames.contains('attendance')) {
                db.createObjectStore('attendance', { keyPath: 'id', autoIncrement: true });
            }
        };
        
        request.onsuccess = function() {
            const db = request.result;
            const transaction = db.transaction(['attendance'], 'readwrite');
            const store = transaction.objectStore('attendance');
            
            const data = {
                attendanceData: attendanceData,
                timestamp: Date.now(),
                csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            };
            
            store.add(data);
            
            transaction.oncomplete = function() {
                console.log('Attendance queued for sync');
                
                // Register for background sync if available
                if ('serviceWorker' in navigator && 'sync' in window.ServiceWorkerRegistration.prototype) {
                    navigator.serviceWorker.ready.then(function(registration) {
                        return registration.sync.register('attendance-sync');
                    });
                }
            };
        };
    }

    // Make function globally available
    window.queueOfflineAttendance = queueOfflineAttendance;
</script>
