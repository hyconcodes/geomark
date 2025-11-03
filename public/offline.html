<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - GeoMark</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #059669 0%, #0284C7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .offline-container {
            text-align: center;
            max-width: 500px;
            padding: 2rem;
        }
        
        .offline-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }
        
        .offline-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .offline-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .offline-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        .connection-status {
            margin-top: 2rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            font-size: 0.9rem;
        }
        
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }
        
        .status-offline {
            background: #ef4444;
        }
        
        .status-online {
            background: #10b981;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @media (max-width: 640px) {
            .offline-container {
                padding: 1rem;
            }
            
            .offline-title {
                font-size: 2rem;
            }
            
            .offline-message {
                font-size: 1rem;
            }
            
            .offline-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="offline-container">
        <div class="offline-icon pulse">
            📡
        </div>
        
        <h1 class="offline-title">You're Offline</h1>
        
        <p class="offline-message">
            It looks like you've lost your internet connection. Don't worry - some features of GeoMark are still available offline.
        </p>
        
        <div class="offline-actions">
            <button onclick="window.location.reload()" class="btn btn-primary">
                Try Again
            </button>
            <a href="/dashboard" class="btn">
                Go to Dashboard
            </a>
        </div>
        
        <div class="connection-status">
            <span class="status-indicator status-offline" id="statusIndicator"></span>
            <span id="statusText">Offline - Checking connection...</span>
        </div>
    </div>

    <script>
        // Check connection status
        function updateConnectionStatus() {
            const indicator = document.getElementById('statusIndicator');
            const text = document.getElementById('statusText');
            
            if (navigator.onLine) {
                indicator.className = 'status-indicator status-online';
                text.textContent = 'Back online! You can refresh the page.';
                
                // Auto-refresh after 2 seconds when back online
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                indicator.className = 'status-indicator status-offline';
                text.textContent = 'Offline - Checking connection...';
            }
        }
        
        // Listen for connection changes
        window.addEventListener('online', updateConnectionStatus);
        window.addEventListener('offline', updateConnectionStatus);
        
        // Check connection status every 5 seconds
        setInterval(updateConnectionStatus, 5000);
        
        // Initial check
        updateConnectionStatus();
        
        // Service worker registration check
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.ready.then(registration => {
                console.log('Service Worker is ready');
            });
        }
    </script>
</body>
</html>