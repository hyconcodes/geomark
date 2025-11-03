# GeoMark - Smart Geolocation-Based Attendance System

<div align="center">

![GeoMark Logo](public/favicon.svg)

**A secure, web-based platform that eliminates attendance fraud through real-time geolocation validation and two-factor authentication.**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-purple.svg)](https://livewire.laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.x-cyan.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

</div>

## 🎯 Project Overview

**GeoMark** is a revolutionary attendance management system designed specifically for educational institutions. Unlike traditional systems that rely on manual entry or basic biometric verification, GeoMark integrates cutting-edge geolocation technology with robust security measures to ensure authentic, location-verified attendance tracking.

The system prevents proxy attendance, location spoofing, and remote attendance fraud through real-time GPS validation, making it the perfect solution for maintaining academic integrity in the digital age.

### 🌟 Why GeoMark?

- **🛡️ Fraud Prevention**: Eliminates proxy attendance and location spoofing
- **📍 Location Accuracy**: Real-time GPS validation with configurable radius zones  
- **🔐 Enhanced Security**: Multi-factor authentication with role-based access control
- **📱 Modern Interface**: Responsive design with native mobile-style experience
- **⚡ Real-time Processing**: Instant attendance validation and reporting
- **🎓 Academic Integrity**: Maintains institutional standards through secure verification

## 🚀 Key Features

### 🔐 **Authentication & Security**
- **Multi-Role System**: Superadmin, Lecturer, and Student roles with granular permissions
- **Two-Factor Authentication**: Email OTP and authenticator app support via Laravel Fortify
- **Secure Session Management**: Advanced session handling with CSRF protection
- **Permission-Based Access**: Spatie Laravel Permission integration

### 📍 **Geolocation Management**
- **Real-time GPS Capture**: HTML5 Geolocation API integration
- **Location Validation**: Haversine formula for distance calculations
- **Radius-based Zones**: Configurable attendance zones (e.g., 30-meter radius)
- **Interactive Maps**: Visual location management and verification
- **Coordinate Security**: Encrypted GPS data storage and validation

### 👥 **User Management**
- **Role-Based Dashboards**: Customized interfaces for each user type
- **Department Integration**: Comprehensive department and level management
- **Profile Management**: Avatar generation and profile customization
- **Bulk User Operations**: Efficient user import and management tools

### 📊 **Attendance System**
- **QR Code Integration**: Seamless QR code scanning for quick attendance marking
- **Real-time GPS Marking**: Instant attendance validation with GPS verification
- **Manual Override**: Lecturer-controlled manual attendance marking capability
- **Attendance Analytics**: Comprehensive reporting and insights with interactive charts
- **Historical Records**: Tamper-proof attendance logs with audit trails
- **Export Capabilities**: PDF and Excel report generation with detailed statistics
- **Distance Validation**: Haversine formula implementation for precise location verification

### 📝 **Complaint Management**
- **Student Submissions**: Easy complaint submission with priority levels (low, medium, high, urgent)
- **Admin Response System**: Comprehensive complaint management and response interface
- **Status Tracking**: Real-time status updates (pending, in_review, resolved)
- **Priority Management**: Complaint prioritization for efficient handling
- **Analytics Dashboard**: Complaint metrics and resolution tracking
- **Notification System**: Real-time updates for complaint status changes

### 🎨 **Modern User Interface**
- **Responsive Design**: Mobile-first approach with desktop optimization
- **Dark Mode Support**: System-wide theme switching
- **Flux UI Components**: Modern, accessible UI component library
- **Interactive Animations**: Smooth transitions and micro-interactions
- **Native Mobile Feel**: App-like experience on all devices

## 🛠 Technology Stack

### **Backend Framework**
- **Laravel 12.x** - Modern PHP framework with latest features
- **PHP 8.2+** - Latest PHP version with performance improvements
- **MySQL/PostgreSQL** - Robust database management

### **Frontend Technologies**
- **Livewire 3.x** - Full-stack framework for dynamic interfaces
- **Alpine.js** - Lightweight JavaScript framework
- **Tailwind CSS 4.x** - Utility-first CSS framework
- **Flux UI 2.x** - Modern component library

### **Authentication & Security**
- **Laravel Fortify 1.30+** - Frontend agnostic authentication
- **Spatie Laravel Permission 6.21+** - Role and permission management
- **Two-Factor Authentication** - Enhanced security layer

### **Development Tools**
- **Vite 7.x** - Fast build tool and development server
- **Pest 3.x** - Modern PHP testing framework
- **Laravel Pint** - Code style fixer
- **Concurrently** - Parallel development processes

### **Additional Packages**
- **DomPDF 3.1+** - PDF generation for reports and QR cards
- **Livewire Volt** - Single-file Livewire components
- **Laravel Tinker** - Interactive REPL
- **Chart.js** - Interactive charts and data visualization
- **QR Code Libraries** - QR code generation and scanning
- **HTML5 Geolocation API** - Browser-based location services

## 📋 Current Implementation Status

### ✅ **Completed Features**

#### 🔐 **Authentication System**
- ✅ Multi-role authentication (Superadmin, Lecturer, Student)
- ✅ Laravel Fortify integration with 2FA support
- ✅ Role-based access control with granular permissions
- ✅ Secure session management and CSRF protection

#### 📍 **Location & Attendance Management**
- ✅ Real-time GPS coordinate capture using HTML5 Geolocation API
- ✅ Distance calculation using Haversine formula for radius validation
- ✅ Geolocation-based attendance marking with GPS verification
- ✅ QR code attendance system with integrated scanner
- ✅ Manual attendance marking by lecturers
- ✅ Secure location storage with metadata tracking
- ✅ Permission-based location access control
- ✅ Interactive location management dashboard
- ✅ Comprehensive error handling for geolocation failures

#### 📊 **Analytics & Reporting**
- ✅ Real-time attendance dashboard with interactive charts
- ✅ Comprehensive analytics for superadmins, lecturers, and students
- ✅ PDF attendance report generation with detailed statistics
- ✅ Class performance metrics and attendance tracking
- ✅ Historical attendance records with audit trails
- ✅ Chart.js integration for visual data representation

#### 👥 **User & Department Management**
- ✅ Complete user management system with role assignments
- ✅ Department creation and management
- ✅ Student level and department associations
- ✅ Avatar generation and profile customization
- ✅ Bulk user operations and data seeding
- ✅ Student QR card generation and PDF export

#### 🎫 **QR Code System**
- ✅ Individual student QR code generation
- ✅ Professional QR card PDF export with student details
- ✅ QR code scanner integration for attendance marking
- ✅ Secure QR code validation and verification
- ✅ Bulk QR card generation for multiple students

#### 📝 **Complaint Management System**
- ✅ Student complaint submission with priority levels
- ✅ Admin complaint management and response system
- ✅ Complaint status tracking (pending, in_review, resolved)
- ✅ Real-time complaint notifications and updates
- ✅ Comprehensive complaint analytics and reporting

#### 🎨 **User Interface**
- ✅ Modern, responsive design with mobile-first approach
- ✅ Dark mode support with system preference detection
- ✅ Flux UI component integration
- ✅ Interactive animations and micro-interactions
- ✅ Native mobile-style welcome page with green/blue theme
- ✅ Professional navigation and hero sections
- ✅ Toast notifications and real-time feedback

#### 🗄️ **Database Architecture**
- ✅ Comprehensive migration system
- ✅ Optimized database relationships and indexing
- ✅ Role and permission tables
- ✅ Location and attendance table structures
- ✅ Complaint and feedback systems
- ✅ Class management and scheduling tables

### 🚧 **In Development**
- 🔄 Advanced map visualization for locations and attendance
- 🔄 Automated attendance notifications and reminders
- 🔄 Enhanced mobile app features and offline capability

### 📅 **Planned Features**
- 📋 Mobile app development (React Native/Flutter)
- 📋 Offline attendance capability with synchronization
- 📋 Advanced analytics and machine learning insights
- 📋 LMS integration (Moodle, Canvas, Blackboard)
- 📋 Automated attendance reports and notifications
- 📋 Student self-service portal enhancements

## 🚀 Installation & Setup

### **Prerequisites**
- **PHP 8.2+** with required extensions
- **Composer 2.x** for dependency management
- **Node.js 18+** and **npm** for frontend assets
- **MySQL 8.0+** or **PostgreSQL 13+**
- **Git** for version control

### **Quick Start**

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/geomark.git
   cd geomark
   ```

2. **Install Dependencies**
   ```bash
   # Install PHP dependencies
   composer install
   
   # Install Node.js dependencies
   npm install
   ```

3. **Environment Setup**
   ```bash
   # Copy environment file
   cp .env.example .env
   
   # Generate application key
   php artisan key:generate
   ```

4. **Database Configuration**
   ```bash
   # Configure database in .env file
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=geomark
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Database Migration & Seeding**
   ```bash
   # Run migrations
   php artisan migrate
   
   # Seed roles, permissions, and sample data
   php artisan db:seed --class=RolePermissionSeeder
   php artisan db:seed --class=DepartmentSeeder
   php artisan db:seed --class=UserSeeder
   ```

6. **Build Assets**
   ```bash
   # Development build
   npm run dev
   
   # Production build
   npm run build
   ```

7. **Start Development Server**
   ```bash
   # Start all services (server, queue, vite)
   composer run dev
   
   # Or start individually
   php artisan serve
   ```

### **Production Deployment**

1. **Server Requirements**
   - PHP 8.2+ with required extensions
   - Web server (Apache/Nginx)
   - SSL certificate (required for geolocation)
   - Database server

2. **Environment Configuration**
   ```bash
   # Set production environment
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com
   
   # Configure mail settings for 2FA
   MAIL_MAILER=smtp
   MAIL_HOST=your-smtp-host
   MAIL_PORT=587
   MAIL_USERNAME=your-email
   MAIL_PASSWORD=your-password
   ```

3. **Optimization**
   ```bash
   # Cache configuration
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   
   # Optimize autoloader
   composer install --optimize-autoloader --no-dev
   ```

## 👥 User Roles & Permissions

### 🔑 **Superadmin**
- Complete system administration and oversight
- User and role management across all departments
- System-wide location and class management
- Access to all analytics, reports, and dashboards
- Department and class creation/management
- Complaint management and resolution system
- PDF report generation and bulk operations
- Student QR card generation and management

### 👨‍🏫 **Lecturer**
- Classroom location setup and management
- Class creation, scheduling, and attendance control
- Real-time attendance monitoring for assigned classes
- Manual attendance marking capabilities
- Student attendance reports and analytics
- Location verification and validation
- PDF attendance report generation
- Class-specific complaint visibility

### 🎓 **Student**
- View assigned classroom locations and schedules
- Mark attendance using QR code scanning or GPS verification
- View personal attendance history and detailed statistics
- Profile management and avatar customization
- Submit complaints with priority levels and track status
- Access to personal analytics and attendance insights
- Download personal QR cards for attendance marking

## 🔒 Security Features

- **🛡️ Multi-Layer Authentication**: Role-based access with 2FA support
- **🔐 Permission System**: Granular control over system features
- **📍 Secure Geolocation**: Encrypted coordinate storage and validation
- **✅ Input Validation**: Comprehensive server-side validation
- **🔒 CSRF Protection**: Built-in Laravel CSRF protection
- **🛡️ SQL Injection Prevention**: Eloquent ORM with prepared statements
- **🔐 Session Security**: Secure session handling and timeout management

## 📱 Browser Compatibility

| Browser | Version | Geolocation Support |
|---------|---------|-------------------|
| Chrome | 50+ | ✅ Full Support |
| Firefox | 55+ | ✅ Full Support |
| Safari | 10+ | ✅ Full Support |
| Edge | 79+ | ✅ Full Support |
| Mobile Safari | iOS 10+ | ✅ Full Support |
| Chrome Mobile | Android 5+ | ✅ Full Support |

## 🧪 Testing

```bash
# Run all tests
composer test

# Run specific test suites
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run tests with coverage
php artisan test --coverage
```

## 📊 Performance

- **⚡ Fast Loading**: Optimized assets and lazy loading
- **📱 Mobile Optimized**: 90+ Lighthouse performance score
- **🔄 Real-time Updates**: Efficient WebSocket connections
- **💾 Caching**: Redis/Memcached support for optimal performance
- **📈 Scalable**: Designed for high-traffic educational institutions

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. **Fork the Repository**
2. **Create Feature Branch** (`git checkout -b feature/amazing-feature`)
3. **Commit Changes** (`git commit -m 'Add amazing feature'`)
4. **Push to Branch** (`git push origin feature/amazing-feature`)
5. **Open Pull Request**

### **Development Guidelines**
- Follow PSR-12 coding standards
- Write comprehensive tests for new features
- Update documentation for API changes
- Use conventional commit messages

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

## 📞 Support & Contact

- **📧 Email**: support@geomark.edu
- **🐛 Issues**: [GitHub Issues](https://github.com/your-username/geomark/issues)
- **📖 Documentation**: [Wiki](https://github.com/your-username/geomark/wiki)
- **💬 Discussions**: [GitHub Discussions](https://github.com/your-username/geomark/discussions)

## 🙏 Acknowledgments

- **Laravel Team** for the amazing framework
- **Livewire Team** for the reactive components
- **Tailwind CSS** for the utility-first CSS framework
- **Flux UI** for the beautiful component library
- **Educational Institutions** for feedback and testing

---

<div align="center">

**Built with ❤️ for Educational Excellence**

*Ensuring Academic Integrity Through Technology*

</div>

---

> **Note**: This system requires HTTPS in production for geolocation features and user permission for location access. Ensure proper SSL configuration and user consent mechanisms are in place.