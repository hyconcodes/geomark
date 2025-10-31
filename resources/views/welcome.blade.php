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
        
        body {
            background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.3);
            position: sticky;
            top: 0;
            z-index: 50;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .hero-section {
            min-height: 90vh;
            background: linear-gradient(135deg, rgba(22, 163, 74, 0.05) 0%, rgba(212, 175, 55, 0.05) 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.1;
            background-image: radial-gradient(circle at 25% 25%, var(--primary-green) 2px, transparent 2px),
                              radial-gradient(circle at 75% 75%, var(--primary-gold) 1px, transparent 1px);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
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
        
        .slide-in-left {
            animation: slideInLeft 0.8s ease-out forwards;
            opacity: 0;
            transform: translateX(-50px);
        }
        
        .slide-in-right {
            animation: slideInRight 0.8s ease-out forwards;
            opacity: 0;
            transform: translateX(50px);
        }
        
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-gold) 0%, #F59E0B 100%);
            color: white;
            border-radius: 12px;
            padding: 14px 28px;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
        }
        
        .btn-secondary {
            background: transparent;
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            border-radius: 12px;
            padding: 12px 28px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-secondary:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(22, 163, 74, 0.3);
        }
        
        .btn-outline {
            background: transparent;
            color: var(--text-dark);
            border: 1px solid var(--medium-gray);
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-outline:hover {
            background: var(--light-gray);
            border-color: var(--primary-green);
            color: var(--primary-green);
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(226, 232, 240, 0.5);
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }
        
        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
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
            padding: 40px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .mobile-menu.open {
            transform: translateX(0);
        }
        
        @media (max-width: 768px) {
            .hero-section {
                min-height: 80vh;
            }
            
            .feature-card {
                padding: 24px;
            }
            
            .icon-circle {
                width: 64px;
                height: 64px;
                margin-bottom: 16px;
            }
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">GeoMark</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-green-600 font-medium transition-colors">Home</a>
                    <a href="#features" class="text-gray-700 hover:text-green-600 font-medium transition-colors">Features</a>
                    <a href="#how-it-works" class="text-gray-700 hover:text-green-600 font-medium transition-colors">How It Works</a>
                    <a href="#about" class="text-gray-700 hover:text-green-600 font-medium transition-colors">About</a>
                    
                    @guest
                        <a href="{{ route('login') }}" class="btn-outline">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-primary">Dashboard</a>
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-green-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu md:hidden fixed inset-y-0 right-0 w-64 bg-white shadow-xl z-50">
            <div class="p-6">
                <div class="flex justify-between items-center mb-8">
                    <span class="text-lg font-bold text-gray-900">Menu</span>
                    <button id="close-menu-btn" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <a href="#home" class="block text-gray-700 hover:text-green-600 font-medium py-2">Home</a>
                    <a href="#features" class="block text-gray-700 hover:text-green-600 font-medium py-2">Features</a>
                    <a href="#how-it-works" class="block text-gray-700 hover:text-green-600 font-medium py-2">How It Works</a>
                    <a href="#about" class="block text-gray-700 hover:text-green-600 font-medium py-2">About</a>
                    
                    <div class="pt-4 border-t border-gray-200">
                        @guest
                            <a href="{{ route('login') }}" class="block btn-outline w-full text-center mb-3">Login</a>
                            <a href="{{ route('register') }}" class="block btn-primary w-full text-center">Get Started</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="block btn-primary w-full text-center">Dashboard</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section flex items-center">
        <div class="hero-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="slide-in-left" style="animation-delay: 0.2s;">
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        Smart <span class="text-yellow-600">Geolocation</span><br>
                        Attendance System
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-lg">
                        Revolutionize attendance tracking with GPS verification, 2FA security, and real-time monitoring. 
                        Say goodbye to proxy attendance forever.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        @guest
                            <a href="{{ route('register') }}" class="btn-primary text-center">
                                Get Started Free →
                            </a>
                            <a href="{{ route('login') }}" class="btn-secondary text-center">
                                Login to Account
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn-primary text-center">
                                Go to Dashboard →
                            </a>
                        @endguest
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 pt-8 border-t border-gray-200">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">99.9%</div>
                            <div class="text-sm text-gray-600">Accuracy</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">24/7</div>
                            <div class="text-sm text-gray-600">Monitoring</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">100%</div>
                            <div class="text-sm text-gray-600">Secure</div>
                        </div>
                    </div>
                </div>

                <!-- Hero Illustration -->
                <div class="slide-in-right" style="animation-delay: 0.4s;">
                    <div class="hero-illustration">
                        <svg class="w-full h-96" viewBox="0 0 500 400" fill="none">
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
                            
                            <rect width="500" height="400" fill="url(#map-dots)"/>
                            
                            <!-- Geolocation Circles -->
                            <circle cx="250" cy="200" r="120" fill="none" stroke="#16A34A" stroke-width="2" opacity="0.3"/>
                            <circle cx="250" cy="200" r="90" fill="none" stroke="#16A34A" stroke-width="2" opacity="0.5"/>
                            <circle cx="250" cy="200" r="60" fill="none" stroke="#16A34A" stroke-width="2" opacity="0.7"/>
                            
                            <!-- Student with Phone -->
                            <g transform="translate(220, 160)">
                                <!-- Person -->
                                <circle cx="15" cy="15" r="15" fill="#F1F5F9"/>
                                <rect x="0" y="30" width="30" height="40" rx="15" fill="#F1F5F9"/>
                                
                                <!-- Phone -->
                                <rect x="35" y="15" width="22" height="40" rx="6" fill="url(#phoneGradient)"/>
                                <rect x="37" y="17" width="18" height="30" rx="3" fill="#60A5FA"/>
                                <circle cx="46" cy="50" r="3" fill="white"/>
                                
                                <!-- QR Code on Phone -->
                                <g transform="translate(39, 20)">
                                    <rect x="0" y="0" width="3" height="3" fill="white"/>
                                    <rect x="4" y="0" width="3" height="3" fill="white"/>
                                    <rect x="11" y="0" width="3" height="3" fill="white"/>
                                    <rect x="0" y="4" width="3" height="3" fill="white"/>
                                    <rect x="11" y="4" width="3" height="3" fill="white"/>
                                    <rect x="0" y="11" width="3" height="3" fill="white"/>
                                    <rect x="4" y="11" width="3" height="3" fill="white"/>
                                    <rect x="11" y="11" width="3" height="3" fill="white"/>
                                </g>
                            </g>
                            
                            <!-- Location Pin -->
                            <g transform="translate(235, 175)">
                                <path d="M15 0C6.72 0 0 6.72 0 15C0 26.25 15 45 15 45S30 26.25 30 15C30 6.72 23.28 0 15 0Z" fill="#EF4444"/>
                                <circle cx="15" cy="15" r="6" fill="white"/>
                            </g>
                            
                            <!-- Security Shield -->
                            <g transform="translate(280, 140)">
                                <path d="M18 0L33 7.5V22.5C33 30 25.5 37.5 18 37.5C10.5 37.5 3 30 3 22.5V7.5L18 0Z" fill="url(#shieldGradient)"/>
                                <path d="M12 18L16.5 22.5L24 15" stroke="white" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            
                            <!-- Floating Icons -->
                            <g transform="translate(150, 100)" opacity="0.8">
                                <circle cx="0" cy="0" r="12" fill="#D4AF37"/>
                                <text x="0" y="5" text-anchor="middle" fill="white" font-size="12" font-weight="bold">2FA</text>
                            </g>
                            
                            <g transform="translate(350, 220)" opacity="0.8">
                                <circle cx="0" cy="0" r="12" fill="#16A34A"/>
                                <text x="0" y="6" text-anchor="middle" fill="white" font-size="16" font-weight="bold">✓</text>
                            </g>
                            
                            <!-- GPS Satellites -->
                            <g transform="translate(100, 50)" opacity="0.6">
                                <rect x="-4" y="-2" width="8" height="4" fill="#D4AF37"/>
                                <rect x="-6" y="-1" width="2" height="2" fill="#D4AF37"/>
                                <rect x="4" y="-1" width="2" height="2" fill="#D4AF37"/>
                            </g>
                            
                            <g transform="translate(400, 80)" opacity="0.6">
                                <rect x="-4" y="-2" width="8" height="4" fill="#D4AF37"/>
                                <rect x="-6" y="-1" width="2" height="2" fill="#D4AF37"/>
                                <rect x="4" y="-1" width="2" height="2" fill="#D4AF37"/>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 slide-up" style="animation-delay: 0.1s;">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Why Choose <span class="text-yellow-600">GeoMark</span>?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Advanced technology meets academic integrity with our comprehensive attendance verification system.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card slide-up" style="animation-delay: 0.2s;">
                    <div class="icon-circle icon-green">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">🌍 Geo-Verified Attendance</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Ensures students are physically present using precise GPS coordinates and geofencing technology. 
                        No more proxy attendance or location spoofing.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card slide-up" style="animation-delay: 0.3s;">
                    <div class="icon-circle icon-gold">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">🔐 Secure 2FA Login</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Two-factor authentication prevents unauthorized access and ensures identity verification. 
                        Multiple authentication methods for maximum security.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card slide-up" style="animation-delay: 0.4s;">
                    <div class="icon-circle icon-green">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">📱 QR Code Scanning</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Quick and seamless attendance marking through integrated QR code scanning technology. 
                        Fast, reliable, and user-friendly interface.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 slide-up">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    How It <span class="text-yellow-600">Works</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Simple, secure, and reliable attendance marking in just three easy steps.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center slide-up" style="animation-delay: 0.1s;">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">🔑 Login Securely</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Access your account with secure authentication and two-factor verification enabled for maximum security.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center slide-up" style="animation-delay: 0.2s;">
                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">📍 Verify Location</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Allow GPS location access to verify your presence within the designated classroom or campus area.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center slide-up" style="animation-delay: 0.3s;">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">✅ Confirm Attendance</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Complete attendance marking via QR code scanning or OTP verification for final confirmation.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="slide-in-left">
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">
                        Preventing <span class="text-yellow-600">Proxy Attendance</span>
                    </h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Our platform revolutionizes academic integrity by combining cutting-edge geolocation technology 
                        with robust security measures. We eliminate proxy attendance and remote spoofing through 
                        multi-layered verification systems.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        With real-time GPS tracking, two-factor authentication, and intelligent fraud detection, 
                        GeoMark ensures that only physically present students can mark their attendance.
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">99.9% Accuracy Rate</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Real-time Verification</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Fraud Detection</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">24/7 Monitoring</span>
                        </div>
                    </div>
                </div>
                
                <!-- Illustration -->
                <div class="slide-in-right">
                    <div class="bg-gradient-to-br from-green-50 to-yellow-50 rounded-3xl p-8 relative overflow-hidden">
                        <svg class="w-full h-80" viewBox="0 0 400 300" fill="none">
                            <!-- Classroom Background -->
                            <rect width="400" height="300" fill="#F8FAFC"/>
                            
                            <!-- Desks -->
                            <rect x="50" y="180" width="60" height="40" rx="4" fill="#E2E8F0"/>
                            <rect x="130" y="180" width="60" height="40" rx="4" fill="#E2E8F0"/>
                            <rect x="210" y="180" width="60" height="40" rx="4" fill="#E2E8F0"/>
                            <rect x="290" y="180" width="60" height="40" rx="4" fill="#E2E8F0"/>
                            
                            <!-- Students -->
                            <g transform="translate(70, 160)">
                                <circle cx="10" cy="10" r="8" fill="#F3F4F6"/>
                                <rect x="2" y="18" width="16" height="20" rx="8" fill="#F3F4F6"/>
                            </g>
                            <g transform="translate(150, 160)">
                                <circle cx="10" cy="10" r="8" fill="#F3F4F6"/>
                                <rect x="2" y="18" width="16" height="20" rx="8" fill="#F3F4F6"/>
                            </g>
                            <g transform="translate(230, 160)">
                                <circle cx="10" cy="10" r="8" fill="#F3F4F6"/>
                                <rect x="2" y="18" width="16" height="20" rx="8" fill="#F3F4F6"/>
                            </g>
                            <g transform="translate(310, 160)">
                                <circle cx="10" cy="10" r="8" fill="#F3F4F6"/>
                                <rect x="2" y="18" width="16" height="20" rx="8" fill="#F3F4F6"/>
                            </g>
                            
                            <!-- Location Overlay -->
                            <circle cx="200" cy="150" r="120" fill="none" stroke="#16A34A" stroke-width="3" opacity="0.3" stroke-dasharray="10,5"/>
                            
                            <!-- Location Pin -->
                            <g transform="translate(190, 130)">
                                <path d="M10 0C4.48 0 0 4.48 0 10C0 17.5 10 30 10 30S20 17.5 20 10C20 4.48 15.52 0 10 0Z" fill="#16A34A"/>
                                <circle cx="10" cy="10" r="4" fill="white"/>
                            </g>
                            
                            <!-- Checkmarks -->
                            <g transform="translate(85, 145)">
                                <circle cx="0" cy="0" r="8" fill="#16A34A"/>
                                <path d="M-3 0L-1 2L3 -2" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <g transform="translate(165, 145)">
                                <circle cx="0" cy="0" r="8" fill="#16A34A"/>
                                <path d="M-3 0L-1 2L3 -2" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <g transform="translate(245, 145)">
                                <circle cx="0" cy="0" r="8" fill="#16A34A"/>
                                <path d="M-3 0L-1 2L3 -2" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <g transform="translate(325, 145)">
                                <circle cx="0" cy="0" r="8" fill="#16A34A"/>
                                <path d="M-3 0L-1 2L3 -2" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Logo and Description -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold">GeoMark</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed max-w-md">
                        Smart Geolocation Attendance System - Revolutionizing academic integrity through advanced 
                        technology and secure verification methods.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">Features</a></li>
                        <li><a href="#how-it-works" class="text-gray-400 hover:text-white transition-colors">How It Works</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">About</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h3 class="font-semibold mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Use</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    Built with ❤️ © {{ date('Y') }} — All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu functionality
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const closeMenuBtn = document.getElementById('close-menu-btn');
            
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.add('open');
            });
            
            closeMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.remove('open');
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                    mobileMenu.classList.remove('open');
                }
            });
            
            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
            
            // Smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const offsetTop = target.offsetTop - 80; // Account for navbar height
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                        // Close mobile menu if open
                        mobileMenu.classList.remove('open');
                    }
                });
            });
            
            // Animation on scroll
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
            document.querySelectorAll('.slide-up, .slide-in-left, .slide-in-right, .fade-in').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
