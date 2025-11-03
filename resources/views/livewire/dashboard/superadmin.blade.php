<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Complaint;
use App\Models\ClassAttendance;
use Carbon\Carbon;

new #[Layout('components.layouts.app')] class extends Component {
    public function with(): array
    {
        $totalUsers = User::count();
        $totalStudents = User::role('student')->count();
        $totalLecturers = User::role('lecturer')->count();
        $totalClasses = ClassModel::count();
        $activeClasses = ClassModel::where('status', 'active')->count();
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $totalAttendances = ClassAttendance::count();
        
        // Get recent users (last 5)
        $recentUsers = User::with('roles')->latest()->take(5)->get();
        
        // Get recent complaints (last 3)
        $recentComplaints = Complaint::with('student')->latest()->take(3)->get();
        
        // Get class statistics for the last 7 days for the chart
        $classStats = [];
        $attendanceStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $classStats[] = [
                'date' => $date->format('M j'),
                'count' => ClassModel::whereDate('created_at', $date)->count()
            ];
            $attendanceStats[] = [
                'date' => $date->format('M j'),
                'count' => ClassAttendance::whereDate('marked_at', $date)->count()
            ];
        }

        return [
            'totalUsers' => $totalUsers,
            'totalStudents' => $totalStudents,
            'totalLecturers' => $totalLecturers,
            'totalClasses' => $totalClasses,
            'activeClasses' => $activeClasses,
            'totalComplaints' => $totalComplaints,
            'pendingComplaints' => $pendingComplaints,
            'totalAttendances' => $totalAttendances,
            'recentUsers' => $recentUsers,
            'recentComplaints' => $recentComplaints,
            'classStats' => $classStats,
            'attendanceStats' => $attendanceStats,
        ];
    }
}; ?>

<div class="min-h-screen bg-gradient-to-br from-green-50 to-indigo-100 p-3 sm:p-6 rounded-xl">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Super Admin Dashboard</h1>
            <p class="text-sm sm:text-base text-gray-600">Welcome back! Here's what's happening with your system today.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Total Users Card -->
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 uppercase tracking-wide">Total Users</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 truncate">{{ number_format($totalUsers) }}</p>
                        <div class="flex flex-col sm:flex-row sm:items-center mt-2 space-y-1 sm:space-y-0">
                            <span class="text-xs sm:text-sm text-gray-500">Students: {{ number_format($totalStudents) }}</span>
                            <span class="hidden sm:inline mx-2 text-gray-300">•</span>
                            <span class="text-xs sm:text-sm text-gray-500">Lecturers: {{ number_format($totalLecturers) }}</span>
                        </div>
                    </div>
                    <div class="p-2 sm:p-3 bg-blue-100 rounded-full flex-shrink-0 ml-2">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Classes Card -->
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 uppercase tracking-wide">Total Classes</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 truncate">{{ number_format($totalClasses) }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs sm:text-sm text-green-600 font-medium">{{ number_format($activeClasses) }} Active</span>
                        </div>
                    </div>
                    <div class="p-2 sm:p-3 bg-green-100 rounded-full flex-shrink-0 ml-2">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Attendances Card -->
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 uppercase tracking-wide">Total Attendances</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 truncate">{{ number_format($totalAttendances) }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs sm:text-sm text-purple-600 font-medium">All Time</span>
                        </div>
                    </div>
                    <div class="p-2 sm:p-3 bg-purple-100 rounded-full flex-shrink-0 ml-2">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Complaints Card -->
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 border-l-4 border-red-500 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600 uppercase tracking-wide">Complaints</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 truncate">{{ number_format($totalComplaints) }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs sm:text-sm text-red-600 font-medium">{{ number_format($pendingComplaints) }} Pending</span>
                        </div>
                    </div>
                    <div class="p-2 sm:p-3 bg-red-100 rounded-full flex-shrink-0 ml-2">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Classes Chart -->
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2 sm:mb-0">Classes Created (Last 7 Days)</h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-xs sm:text-sm text-gray-600">Classes</span>
                    </div>
                </div>
                <div class="h-48 sm:h-64">
                    <canvas id="classesChart"></canvas>
                </div>
            </div>

            <!-- Attendance Chart -->
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2 sm:mb-0">Attendance Records (Last 7 Days)</h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-xs sm:text-sm text-gray-600">Attendances</span>
                    </div>
                </div>
                <div class="h-48 sm:h-64">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Management Sections -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- System Management -->
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4 sm:mb-6">System Management</h3>
                <div class="space-y-3 sm:space-y-4">
                    <a href="{{ route('superadmin.account-manager') }}" class="flex items-center justify-between p-3 sm:p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                        <div class="flex items-center min-w-0 flex-1">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-medium text-gray-900 text-sm sm:text-base">User Management</h4>
                                <p class="text-xs sm:text-sm text-gray-500 truncate">Manage users, roles, and permissions</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <a href="{{ route('superadmin.class-manager') }}" class="flex items-center justify-between p-3 sm:p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                        <div class="flex items-center min-w-0 flex-1">
                            <div class="p-2 bg-green-100 rounded-lg mr-3 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-medium text-gray-900 text-sm sm:text-base">Class Management</h4>
                                <p class="text-xs sm:text-sm text-gray-500 truncate">Manage classes and schedules</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <a href="{{ route('superadmin.complaints') }}" class="flex items-center justify-between p-3 sm:p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                        <div class="flex items-center min-w-0 flex-1">
                            <div class="p-2 bg-red-100 rounded-lg mr-3 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-medium text-gray-900 text-sm sm:text-base">Complaint Management</h4>
                                <p class="text-xs sm:text-sm text-gray-500 truncate">Handle user complaints and issues</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4 sm:mb-6">Recent Activity</h3>
                
                <!-- Recent Users -->
                <div class="mb-4 sm:mb-6">
                    <h4 class="text-xs sm:text-sm font-medium text-gray-700 mb-3">Latest Users</h4>
                    <div class="space-y-2 sm:space-y-3">
                        @forelse($recentUsers as $user)
                            <div class="flex items-center justify-between p-2 sm:p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center min-w-0 flex-1">
                                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                                        <span class="text-xs sm:text-sm font-medium text-blue-600">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0 ml-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($user->roles->first()?->name === 'student') bg-green-100 text-green-800
                                        @elseif($user->roles->first()?->name === 'lecturer') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($user->roles->first()?->name ?? 'No Role') }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs sm:text-sm text-gray-500 text-center py-4">No recent users</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Complaints -->
                <div>
                    <h4 class="text-xs sm:text-sm font-medium text-gray-700 mb-3">Recent Complaints</h4>
                    <div class="space-y-2 sm:space-y-3">
                        @forelse($recentComplaints as $complaint)
                            <div class="flex items-center justify-between p-2 sm:p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center min-w-0 flex-1">
                                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-red-100 rounded-full flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ Str::limit($complaint->subject, 25) }}</p>
                                        <p class="text-xs text-gray-500 truncate">by {{ $complaint->student->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0 ml-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($complaint->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($complaint->status === 'resolved') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($complaint->status) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">{{ $complaint->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs sm:text-sm text-gray-500 text-center py-4">No recent complaints</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Classes Chart
            const classesCtx = document.getElementById('classesChart').getContext('2d');
            const classesData = @json($classStats);
            
            new Chart(classesCtx, {
                type: 'line',
                data: {
                    labels: classesData.map(item => item.date),
                    datasets: [{
                        label: 'Classes Created',
                        data: classesData.map(item => item.count),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        }
                    }
                }
            });

            // Attendance Chart
            const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
            const attendanceData = @json($attendanceStats);
            
            new Chart(attendanceCtx, {
                type: 'line',
                data: {
                    labels: attendanceData.map(item => item.date),
                    datasets: [{
                        label: 'Attendance Records',
                        data: attendanceData.map(item => item.count),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgb(34, 197, 94)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        }
                    }
                }
            });
        });
    </script>
</div>