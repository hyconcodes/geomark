<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#16A34A">
    
    <title>GeoMark - Smart Geolocation-Based Attendance System</title>
    
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        :root {
            --primary-green: #16A34A;
            --primary-gold: #D4AF37;
            --light-gray: #F8FAFC;
            --medium-gray: #E2E8F0;
            --text-dark: #1E293B;
        }
        
        .mobile-container {
            max-width: 428px;
            margin: 0 auto;
            min-height: 100vh;
            background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
            opacity: 0;
        }
        
        .slide-up {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        
        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .btn-primary {
            background: var(--primary-gold);
            color: white;
            border-radius: 16px;
            padding: 16px 32px;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            border-radius: 16px;
            padding: 14px 32px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-secondary:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.3);
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(226, 232, 240, 0.5);
        }
        
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
        }
        
        .icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        
        .icon-green {
            background: linear-gradient(135deg, var(--primary-green) 0%, #22C55E 100%);
        }
        
        .icon-gold {
            background: linear-gradient(135deg, var(--primary-gold) 0%, #F59E0B 100%);
        }
        
        .hero-illustration {
            background: linear-gradient(135deg, rgba(22, 163, 74, 0.1) 0%, rgba(212, 175, 55, 0.1) 100%);
            border-radius: 24px;
            padding: 32px;
            margin: 32px 0;
        }
        
        .ripple {
            position: relative;
            overflow: hidden;
        }
        
        .ripple::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .ripple:active::before {
            width: 300px;
            height: 300px;
        }
        
        @media (min-width: 768px) {
            .mobile-container {
                max-width: 100%;
                padding: 0 24px;
            }
        }
    </style>
</head>
<body class="bg-white">
    <div class="mobile-container">
        <!-- Header Section -->
        <header class="px-6 py-8 text-center fade-in">
            <div class="flex flex-col items-center space-y-4">
                <!-- App Logo -->
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                
                <!-- App Name -->
                <h1 class="text-2xl font-bold text-gray-900 leading-tight">
                    Smart Geolocation-Based<br>
                    <span class="text-yellow-600">Attendance System</span>
                </h1>
                
                <!-- Tagline -->
                <p class="text-green-600 font-semibold text-lg">
                    Smart. Secure. Verified Attendance.
                </p>
            </div>
        </header>

        <!-- Hero Illustration Area -->
        <section class="px-6 slide-up" style="animation-delay: 0.2s;">
            <div class="hero-illustration">
                <svg class="w-full h-64" viewBox="0 0 400 250" fill="none">
                    <!-- Background Map Pattern -->
                    <defs>
                        <pattern id="map-dots" x="0" y="0" width="30" height="30" patternUnits="userSpaceOnUse">
                            <circle cx="15" cy="15" r="1.5" fill="#E2E8F0" opacity="0.6"/>
                        </pattern>
                        <linearGradient id="phoneGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#D4AF37"/>
                            <stop offset="100%" style="stop-color:#F59E0B"/>
                        </linearGradient>
                        <linearGradient id="shieldGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#16A34A"/>
                            <stop offset="100%" style="stop-color:#22C55E"/>
                        </linearGradient>
                    </defs>
                    
                    <rect width="400" height="250" fill="url(#map-dots)"/>
                    
                    <!-- Geolocation Circles -->
                    <circle cx="200" cy="125" r="80" fill="none" stroke="#16A34A" stroke-width="2" opacity="0.3"/>
                    <circle cx="200" cy="125" r="60" fill="none" stroke="#16A34A" stroke-width="2" opacity="0.5"/>
                    <circle cx="200" cy="125" r="40" fill="none" stroke="#16A34A" stroke-width="2" opacity="0.7"/>
                    
                    <!-- Student with Phone -->
                    <g transform="translate(170, 100)">
                        <!-- Person -->
                        <circle cx="15" cy="15" r="12" fill="#F1F5F9"/>
                        <rect x="3" y="27" width="24" height="30" rx="12" fill="#F1F5F9"/>
                        
                        <!-- Phone -->
                        <rect x="25" y="15" width="18" height="32" rx="4" fill="url(#phoneGradient)"/>
                        <rect x="27" y="17" width="14" height="22" rx="2" fill="#60A5FA"/>
                        <circle cx="34" cy="43" r="2" fill="white"/>
                        
                        <!-- QR Code on Phone -->
                        <g transform="translate(29, 19)">
                            <rect x="0" y="0" width="2" height="2" fill="white"/>
                            <rect x="3" y="0" width="2" height="2" fill="white"/>
                            <rect x="8" y="0" width="2" height="2" fill="white"/>
                            <rect x="0" y="3" width="2" height="2" fill="white"/>
                            <rect x="8" y="3" width="2" height="2" fill="white"/>
                            <rect x="0" y="8" width="2" height="2" fill="white"/>
                            <rect x="3" y="8" width="2" height="2" fill="white"/>
                            <rect x="8" y="8" width="2" height="2" fill="white"/>
                        </g>
                    </g>
                    
                    <!-- Location Pin -->
                    <g transform="translate(190, 105)">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 17.5 10 30 10 30S20 17.5 20 10C20 4.48 15.52 0 10 0Z" fill="#EF4444"/>
                        <circle cx="10" cy="10" r="4" fill="white"/>
                    </g>
                    
                    <!-- Security Shield -->
                    <g transform="translate(220, 80)">
                        <path d="M12 0L22 5V15C22 20 17 25 12 25C7 25 2 20 2 15V5L12 0Z" fill="url(#shieldGradient)"/>
                        <path d="M8 12L11 15L16 10" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    
                    <!-- Floating Icons -->
                    <g transform="translate(120, 60)" opacity="0.7">
                        <circle cx="0" cy="0" r="8" fill="#D4AF37"/>
                        <text x="0" y="4" text-anchor="middle" fill="white" font-size="10">2FA</text>
                    </g>
                    
                    <g transform="translate(280, 140)" opacity="0.7">
                        <circle cx="0" cy="0" r="8" fill="#16A34A"/>
                        <text x="0" y="4" text-anchor="middle" fill="white" font-size="12">✓</text>
                    </g>
                </svg>
            </div>
        </section>

        <!-- Action Buttons -->
        <section class="px-6 py-8 slide-up" style="animation-delay: 0.4s;">
            <div class="space-y-4">
                @guest
                    <button onclick="window.location.href='{{ route('login') }}'" class="btn-primary ripple w-full">
                        Login / Continue →
                    </button>
                    <button onclick="window.location.href='{{ route('register') }}'" class="btn-secondary w-full">
                        Register / Create Account
                    </button>
                @else
                    <button onclick="window.location.href='{{ route('dashboard') }}'" class="btn-primary ripple w-full">
                        Go to Dashboard →
                    </button>
                @endguest
            </div>
        </section>

        <!-- Feature Highlights Section -->
        <section class="px-6 py-8 slide-up" style="animation-delay: 0.6s;">
            <h2 class="text-xl font-bold text-gray-900 text-center mb-6">Why Choose GeoMark?</h2>
            
            <div class="space-y-6">
                <!-- Feature 1 -->
                <div class="feature-card">
                    <div class="icon-circle icon-green">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">🌍 Geo-Verified Attendance</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Ensures students are physically present using precise GPS coordinates and geofencing technology.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card">
                    <div class="icon-circle icon-gold">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">🔐 Secure 2FA Login</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Two-factor authentication prevents unauthorized access and ensures identity verification.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card">
                    <div class="icon-circle icon-green">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">📱 QR Code Scanning Made Easy</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Quick and seamless attendance marking through integrated QR code scanning technology.
                    </p>
                </div>
            </div>
        </section>

        <!-- Footer Section -->
        <footer class="px-6 py-8 text-center slide-up" style="animation-delay: 0.8s;">
            <div class="border-t border-gray-200 pt-6">
                <p class="text-sm text-gray-500 mb-4">
                    © 2025 Brenode Technologies — All Rights Reserved.
                </p>
                
                <!-- Social/Contact Icons -->
                <div class="flex justify-center space-x-6">
                    <a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Mobile Interactions Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add ripple effect to buttons
            const rippleButtons = document.querySelectorAll('.ripple');
            
            rippleButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple-effect');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
            
            // Smooth scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);
            
            // Observe animated elements
            document.querySelectorAll('.slide-up, .fade-in').forEach(el => {
                observer.observe(el);
            });
            
            // Add touch feedback for mobile
            const touchElements = document.querySelectorAll('button, .feature-card');
            
            touchElements.forEach(element => {
                element.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.98)';
                });
                
                element.addEventListener('touchend', function() {
                    this.style.transform = '';
                });
            });
        });
    </script>

    <style>
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</body>
</html>
