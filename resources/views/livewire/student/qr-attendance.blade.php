<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\ClassModel;
use App\Models\ClassAttendance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\AttendanceLogService;

new #[Layout('components.layouts.app', ['title' => 'QR Attendance'])] class extends Component {
    
    public ClassModel $class;
    public ?float $latitude = null;
    public ?float $longitude = null;
    public bool $locationCaptured = false;
    public string $locationError = '';
    public bool $isSubmitting = false;
    public ?float $distance = null;
    public bool $withinRadius = false;
    
    // QR Scanner properties
    public bool $scannerActive = false;
    public array $scannedStudent = [];
    public bool $studentConfirmed = false;
    public string $scannerError = '';
    
    // Toast notification properties
    public bool $showToast = false;
    public string $toastMessage = '';
    public string $toastType = 'success';
    
    public function showToast(string $message, string $type = 'success'): void
    {
        $this->toastMessage = $message;
        $this->toastType = $type;
        $this->showToast = true;
        
        // Auto-hide toast after 5 seconds
        $this->dispatch('hide-toast-after-delay');
    }
    
    public function hideToast(): void
    {
        $this->showToast = false;
        $this->toastMessage = '';
    }
    
    public function mount($classId): void
    {
        $this->class = ClassModel::with(['lecturer', 'department'])
            ->findOrFail($classId);
            
        // Check if class is active and attendance is open
        if (!$this->class->isActive() || !$this->class->attendance_open) {
            session()->flash('error', 'This class is not accepting attendance at the moment.');
            $this->redirect(route('student.classes'));
        }
        
        // Check if student already marked attendance
        if (ClassAttendance::where('class_id', $this->class->id)
            ->where('student_id', Auth::id())
            ->exists()) {
            session()->flash('error', 'You have already marked attendance for this class.');
            $this->redirect(route('student.classes'));
        }
    }
    
    public function startQRScanner(): void
    {
        $this->scannerActive = true;
        $this->scannerError = '';
        $this->scannedStudent = [];
        $this->studentConfirmed = false;
        $this->dispatch('start-qr-scanner');
    }
    
    public function stopQRScanner(): void
    {
        $this->scannerActive = false;
        $this->dispatch('stop-qr-scanner');
    }
    
    public function handleQRResult($studentData): void
    {
        if (isset($studentData['error'])) {
            $this->scannerError = $studentData['error'];
            $this->showToast($studentData['error'], 'error');
            return;
        }
        
        // Validate student exists and belongs to correct department
        $student = User::role('student')
            ->where('matric_no', $studentData['matric_no'])
            ->where('department_id', $this->class->department_id)
            ->where('level', $this->class->level)
            ->first();
            
        if (!$student) {
            $this->scannerError = 'Student not found in this department and level, or QR code is invalid.';
            $this->showToast($this->scannerError, 'error');
            $this->dispatch('restart-qr-scanner');
            return;
        }
        
        // Ensure the scanned QR code belongs to the currently logged-in student
        if ($student->id !== Auth::id()) {
            $this->scannerError = 'You can only scan your own QR code to mark attendance.';
            $this->showToast($this->scannerError, 'error');
            $this->dispatch('restart-qr-scanner');
            return;
        }
        
        // Check if student already marked attendance
        $existingAttendance = ClassAttendance::where('class_id', $this->class->id)
            ->where('student_id', $student->id)
            ->first();
            
        if ($existingAttendance) {
            $this->scannerError = 'You have already marked attendance for this class.';
            $this->showToast($this->scannerError, 'error');
            $this->dispatch('restart-qr-scanner');
            return;
        }
        
        // Store scanned student data for confirmation
        $this->scannedStudent = [
            'id' => $student->id,
            'name' => $student->name,
            'matric_no' => $student->matric_no,
            'email' => $student->email,
            'department' => $student->department->name,
            'level' => $student->level,
        ];
        
        $this->scannerActive = false;
        $this->studentConfirmed = true;
        $this->scannerError = '';
        
        $this->showToast('Student QR code scanned successfully! Please confirm the details.', 'success');
    }
    
    public function confirmStudent(): void
    {
        if (empty($this->scannedStudent)) {
            $this->showToast('No student data found. Please scan QR code again.', 'error');
            return;
        }
        
        // Student confirmed, ready for submission if location is already captured
        $this->showToast('Student details confirmed!', 'success');
    }
    
    public function resetScanner(): void
    {
        $this->scannedStudent = [];
        $this->studentConfirmed = false;
        $this->scannerError = '';
        $this->locationCaptured = false;
        $this->locationError = '';
        $this->latitude = null;
        $this->longitude = null;
        $this->distance = null;
        $this->withinRadius = false;
        
        // Reset to step 1: location capture
        $this->showToast('Scanner reset. Please start with location capture.', 'info');
    }
    
    public function captureLocation(): void
    {
        $this->dispatch('capture-location');
    }
    
    public function setLocation($latitude, $longitude): void
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->locationCaptured = true;
        $this->locationError = '';
        
        // Calculate distance from class location
        $this->distance = $this->class->calculateDistance(
            $this->class->latitude,
            $this->class->longitude,
            $latitude,
            $longitude
        );
        $this->withinRadius = $this->class->isWithinRadius($latitude, $longitude);
        
        if (!$this->withinRadius) {
            $this->locationError = "You are {$this->distance}m away from the class location. You must be within {$this->class->radius}m to mark attendance.";
        } else {
            $this->showToast('Location verified! You can now proceed to scan QR code.', 'success');
        }
    }
    
    public function startQRScannerAfterLocation(): void
    {
        if (!$this->locationCaptured || !$this->withinRadius) {
            $this->showToast('Please verify your location first before scanning QR code.', 'error');
            return;
        }
        
        $this->startQRScanner();
    }
    
    public function submitAttendance(): void
    {
        if (empty($this->scannedStudent)) {
            $this->showToast('No student data found. Please scan QR code again.', 'error');
            return;
        }
        
        if (!$this->locationCaptured) {
            $this->showToast('Please capture your location first.', 'error');
            return;
        }
        
        if (!$this->withinRadius) {
            $this->showToast('You must be within the class location radius to mark attendance.', 'error');
            return;
        }
        
        $this->isSubmitting = true;
        
        try {
            // Create attendance record
            $attendance = ClassAttendance::create([
                'class_id' => $this->class->id,
                'student_id' => $this->scannedStudent['id'],
                'full_name' => $this->scannedStudent['name'],
                'matric_number' => $this->scannedStudent['matric_no'],
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'distance' => $this->distance,
                'marked_at' => now(),
                'marked_by_lecturer' => false,
            ]);
            
            // Log the attendance
            app(AttendanceLogService::class)->logSuccess(
                $this->class,
                [
                    'student_id' => $this->scannedStudent['id'],
                    'student_name' => $this->scannedStudent['name'],
                    'student_matric' => $this->scannedStudent['matric_no'],
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'distance' => $this->distance,
                    'method' => 'qr_code_scan'
                ]
            );
            
            session()->flash('success', 'Attendance marked successfully via QR code scan!');
            $this->redirect(route('student.classes'));
            
        } catch (\Exception $e) {
            $this->showToast('Failed to mark attendance. Please try again.', 'error');
            \Log::error('QR Attendance Error: ' . $e->getMessage());
        } finally {
            $this->isSubmitting = false;
        }
    }
    
    public function goBack(): void
    {
        $this->redirect(route('student.classes'));
    }
}; ?>

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900">
    <!-- Toast Notification -->
    @if($showToast)
        <div x-data="{ show: @entangle('showToast') }" 
             x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             class="fixed top-4 right-4 z-50 max-w-sm">
            <div class="bg-white dark:bg-zinc-800 border-l-4 {{ $toastType === 'success' ? 'border-green-500' : 'border-red-500' }} rounded-lg shadow-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if($toastType === 'success')
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium {{ $toastType === 'success' ? 'text-green-800' : 'text-red-800' }} dark:{{ $toastType === 'success' ? 'text-green-200' : 'text-red-200' }}">
                            {{ $toastMessage }}
                        </p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button wire:click="hideToast" class="inline-flex {{ $toastType === 'success' ? 'text-green-400 hover:text-green-600' : 'text-red-400 hover:text-red-600' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="max-w-4xl mx-auto p-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">QR Code Attendance</h1>
                    <p class="text-zinc-600 dark:text-zinc-400 mt-2">{{ $class->class_name }} - {{ $class->department->name }} (Level {{ $class->level }})</p>
                </div>
                <button wire:click="goBack" 
                    class="inline-flex items-center px-4 py-2 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Classes
                </button>
            </div>
        </div>

        <!-- Location Capture Section (First Step) -->
        @if(!$locationCaptured || !$withinRadius)
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 mb-6">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Step 1: Location Verification</h2>
                    <p class="text-zinc-600 dark:text-zinc-400 mt-1">Verify your location before scanning QR codes</p>
                </div>

                <div class="p-6">
                    @if(!$locationCaptured)
                        <div class="text-center">
                            <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-2">Location Required</h3>
                            <p class="text-zinc-600 dark:text-zinc-400 mb-6">Click to capture your current location for attendance verification</p>
                            <button wire:click="captureLocation" 
                                class="inline-flex items-center px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Capture Location
                            </button>
                        </div>
                    @else
                        <div class="space-y-4">
                            @if($withinRadius)
                                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-green-800 dark:text-green-200 font-medium">Location verified! You are {{ number_format($distance, 1) }}m from the class location.</span>
                                    </div>
                                </div>
                            @else
                                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-red-800 dark:text-red-200 font-medium">{{ $locationError }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($locationError)
                                <div class="text-center">
                                    <button wire:click="captureLocation" 
                                        class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Try Again
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- QR Scanner Section (Second Step) -->
        @if($locationCaptured && $withinRadius && !$studentConfirmed)
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 mb-6">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Step 2: Scan Your QR Code</h2>
                    <p class="text-zinc-600 dark:text-zinc-400 mt-1">Position your personal QR code within the camera frame</p>
                </div>

                <div class="p-6">
                    @if(!$scannerActive)
                        <div class="text-center">
                            <div class="w-24 h-24 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-2">Ready to Scan Your QR Code</h3>
                            <p class="text-zinc-600 dark:text-zinc-400 mb-6">Click the button below to start scanning your personal QR code</p>
                            <button wire:click="startQRScannerAfterLocation" 
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Start Camera
                            </button>
                        </div>
                    @else
                        <div class="space-y-4">
                            <!-- Camera Preview -->
                            <div class="relative bg-black rounded-lg overflow-hidden">
                                <video id="qr-video" class="w-full h-64 object-cover" autoplay muted playsinline></video>
                                <canvas id="qr-canvas" class="hidden"></canvas>
                                
                                <!-- Scanner Overlay -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-48 h-48 border-2 border-white border-dashed rounded-lg flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">Position QR Code Here</span>
                                    </div>
                                </div>
                            </div>
                            
                            @if($scannerError)
                                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                    <p class="text-red-800 dark:text-red-200 text-sm">{{ $scannerError }}</p>
                                </div>
                            @endif
                            
                            <div class="flex justify-center space-x-4">
                                <button wire:click="stopQRScanner" 
                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                                    </svg>
                                    Stop Scanner
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Student Confirmation Section (Third Step) -->
        @if($studentConfirmed && !empty($scannedStudent))
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 mb-6">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Step 3: Confirm Student Details</h2>
                    <p class="text-zinc-600 dark:text-zinc-400 mt-1">Please verify your scanned information</p>
                </div>

                <div class="p-6">
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-lg font-medium text-green-800 dark:text-green-200">QR Code Scanned Successfully</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-green-700 dark:text-green-300">Name:</span>
                                <span class="text-green-800 dark:text-green-200 ml-2">{{ $scannedStudent['name'] }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-green-700 dark:text-green-300">Matric No:</span>
                                <span class="text-green-800 dark:text-green-200 ml-2">{{ $scannedStudent['matric_no'] }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-green-700 dark:text-green-300">Department:</span>
                                <span class="text-green-800 dark:text-green-200 ml-2">{{ $scannedStudent['department'] }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-green-700 dark:text-green-300">Level:</span>
                                <span class="text-green-800 dark:text-green-200 ml-2">{{ $scannedStudent['level'] }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-center space-x-4">
                        <button wire:click="confirmStudent" 
                            class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Confirm & Continue
                        </button>
                        <button wire:click="resetScanner" 
                            class="inline-flex items-center px-4 py-2 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Scan Again
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Step 4: Submit Section -->
        @if($studentConfirmed && $locationCaptured && $withinRadius)
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-3">
                            <span class="text-green-600 dark:text-green-400 font-semibold text-sm">4</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Mark Attendance</h2>
                            <p class="text-zinc-600 dark:text-zinc-400 mt-1">Ready to submit attendance record</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-2">Ready to Submit</h3>
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6">All requirements met. Click below to mark attendance.</p>
                        
                        <button wire:click="submitAttendance" 
                            wire:loading.attr="disabled"
                            class="inline-flex items-center px-8 py-3 bg-green-600 hover:bg-green-700 disabled:bg-zinc-400 disabled:cursor-not-allowed text-white rounded-lg transition-colors duration-200">
                            <span wire:loading.remove wire:target="submitAttendance">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Mark Attendance
                            </span>
                            <span wire:loading wire:target="submitAttendance" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Submitting...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
<script src="{{ asset('js/qr-scanner.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let qrScanner = null;
    let librariesLoaded = false;
    
    // Check if libraries are loaded
    function checkLibraries() {
        return new Promise((resolve) => {
            const checkInterval = setInterval(() => {
                if (window.jsQR && window.QRScanner) {
                    clearInterval(checkInterval);
                    librariesLoaded = true;
                    resolve(true);
                }
            }, 100);
            
            // Timeout after 5 seconds
            setTimeout(() => {
                clearInterval(checkInterval);
                if (!librariesLoaded) {
                    console.error('QR libraries failed to load');
                    resolve(false);
                }
            }, 5000);
        });
    }
    
    // Initialize QR Scanner
    async function initQRScanner() {
        // Wait for libraries to load
        const loaded = await checkLibraries();
        if (!loaded) {
            @this.call('handleQRResult', { error: 'QR scanner libraries failed to load. Please refresh the page.' });
            return;
        }
        
        const video = document.getElementById('qr-video');
        const canvas = document.getElementById('qr-canvas');
        
        if (!video || !canvas) {
            @this.call('handleQRResult', { error: 'Camera elements not found. Please refresh the page.' });
            return;
        }
        
        if (window.QRScanner) {
            qrScanner = new QRScanner(video, canvas, function(result) {
                @this.call('handleQRResult', result);
            });
        }
    }
    
    // Livewire event listeners
    Livewire.on('start-qr-scanner', async () => {
        try {
            await initQRScanner();
            if (qrScanner) {
                await qrScanner.startScanning();
            }
        } catch (error) {
            console.error('QR Scanner Error:', error);
            @this.call('handleQRResult', { error: error.message || 'Failed to start camera. Please check permissions and try again.' });
        }
    });
    
    Livewire.on('stop-qr-scanner', () => {
        try {
            if (qrScanner) {
                qrScanner.stopScanning();
            }
        } catch (error) {
            console.error('Error stopping scanner:', error);
        }
    });
    
    Livewire.on('restart-qr-scanner', () => {
        try {
            if (qrScanner) {
                qrScanner.restartScanning();
            }
        } catch (error) {
            console.error('Error restarting scanner:', error);
            @this.call('handleQRResult', { error: 'Failed to restart scanner. Please try again.' });
        }
    });
    
    // Location capture
    Livewire.on('capture-location', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    @this.call('setLocation', position.coords.latitude, position.coords.longitude);
                },
                function(error) {
                    let errorMessage = 'Location access denied or unavailable.';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Location access denied. Please enable location services.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Location information unavailable.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Location request timed out.';
                            break;
                    }
                    @this.call('showToast', errorMessage, 'error');
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 60000
                }
            );
        } else {
            @this.call('showToast', 'Geolocation is not supported by this browser.', 'error');
        }
    });
    
    // Auto-hide toast
    Livewire.on('hide-toast-after-delay', () => {
        setTimeout(() => {
            @this.call('hideToast');
        }, 5000);
    });
});
</script>
