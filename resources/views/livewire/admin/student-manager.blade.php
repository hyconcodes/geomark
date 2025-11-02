<?php

use Livewire\WithPagination;
use App\Models\User;
use App\Models\Department;
use Livewire\Volt\Component;
use Barryvdh\DomPDF\Facade\Pdf;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $department_id = '';
    public $showQrModal = false;
    public $selectedStudentForQr = null;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedDepartmentId()
    {
        $this->resetPage();
    }

    public function viewProfile($userId)
    {
        return redirect()->route('student.profile', $userId);
    }

    public function viewQrCode($studentId)
    {
        $student = User::with('department')->find($studentId);
        if ($student) {
            // Ensure the student has a QR code
            if (!$student->qr_code) {
                $student->getQrCode();
            }
            
            $this->selectedStudentForQr = $student;
            $this->showQrModal = true;
            
            // Force Livewire to update
            $this->dispatch('qr-modal-opened');
        } else {
            session()->flash('error', 'Student not found');
        }
    }

    public function closeQrModal()
    {
        $this->showQrModal = false;
        $this->selectedStudentForQr = null;
        $this->dispatch('qr-modal-closed');
    }

    public function generateSingleQrCard($studentId)
    {
        $student = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })
        ->with('department')
        ->find($studentId);

        if (!$student) {
            session()->flash('error', 'Student not found.');
            return;
        }

        // Ensure the student has a QR code
        if (!$student->qr_code) {
            $student->getQrCode();
        }

        // Create a collection with single student for the PDF view
        $students = collect([$student]);

        $pdf = Pdf::loadView('pdf.student-qr-cards', compact('students'));
        $pdf->setPaper('A4', 'portrait');
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'qr-card-' . $student->matric_no . '-' . now()->format('Y-m-d-H-i-s') . '.pdf');
    }

    private function getStudentsQuery()
    {
        $query = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->with(['department', 'roles']);
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('matric_no', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->department_id) {
            $query->where('department_id', $this->department_id);
        }

        return $query->orderBy('name');
    }

    public function with()
    {
        $students = $this->getStudentsQuery()->paginate(15);
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        
        return [
            'students' => $students,
            'departments' => $departments,
        ];
    }
}; ?>

<main>
<div>
    <div class="p-6 bg-white dark:bg-zinc-800 shadow-md rounded-lg">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Student Management</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">View and manage student accounts with QR code generation</p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search and Filter Controls -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search by name, email, or matric number"
                type="text"
                label="Search Students"
            />
            <flux:select 
                wire:model.live="department_id"
                label="Filter by Department"
                placeholder="All Departments"
            >
                <option value="">All Departments</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </flux:select>
        </div>

        <!-- Students Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Avatar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Student Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">QR Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-zinc-200 dark:bg-zinc-800 dark:divide-zinc-700">
                    @forelse ($students as $student)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-zinc-200 dark:bg-zinc-600">
                                        <img src="{{ $student->getAvatarUrl() }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $student->name }}</div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $student->email }}</div>
                                <div class="text-xs text-zinc-400 dark:text-zinc-500">{{ $student->matric_no }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-zinc-900 dark:text-white">
                                    {{ $student->department->name ?? 'Not Assigned' }}
                                </div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $student->department->code ?? '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                    {{ $student->getFormattedLevel() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($student->qr_code)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        Generated
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <flux:button 
                                        wire:click="viewProfile({{ $student->id }})"
                                        variant="ghost"
                                        size="sm"
                                    >
                                        <flux:icon.eye class="w-4 h-4 mr-1" />
                                        View
                                    </flux:button>
                                    
                                    {{-- <flux:button 
                                        wire:click="viewQrCode({{ $student->id }})"
                                        variant="ghost"
                                        size="sm"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 16h4.01M12 8h4.01M16 12h4.01M12 16h.01m0 0h4.01M16 20h4.01M12 20h.01m0 0h4.01M16 8h4.01M12 8h.01M16 4h4.01M12 4h.01"></path>
                                        </svg>
                                        View QR
                                    </flux:button> --}}

                                    <flux:button 
                                        wire:click="generateSingleQrCard({{ $student->id }})"
                                        variant="ghost"
                                        size="sm"
                                        class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400 text-center">
                                No students found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>

    <!-- QR Code Modal -->
    <div 
        x-data="{ show: @entangle('showQrModal') }"
        x-show="show"
        x-cloak
        @keydown.escape.window="show = false; $wire.closeQrModal()"
        class="fixed inset-0 z-50 overflow-y-auto" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
        style="display: none;"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div 
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                @click="show = false; $wire.closeQrModal()"
            ></div>

            <!-- Center trick -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div 
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                @click.stop
            >
                @if($selectedStudentForQr)
                    <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <!-- Modal Header -->
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                        Student QR Code
                                    </h3>
                                    <button 
                                        @click="show = false; $wire.closeQrModal()"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                                    >
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Student Info -->
                                <div class="mb-6 text-center">
                                    <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden bg-zinc-200 dark:bg-zinc-600">
                                        <img src="{{ $selectedStudentForQr->getAvatarUrl() }}" alt="{{ $selectedStudentForQr->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $selectedStudentForQr->name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $selectedStudentForQr->matric_no }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $selectedStudentForQr->department->name ?? 'No Department' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $selectedStudentForQr->getFormattedLevel() }}</p>
                                </div>

                                <!-- QR Code -->
                                <div class="flex justify-center mb-6">
                                    <div class="p-4 bg-white rounded-lg shadow-inner">
                                        {!! $selectedStudentForQr->getQrCode() !!}
                                    </div>
                                </div>

                                <!-- QR Code Info -->
                                <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                                    <p>This QR code contains the student's information for attendance marking.</p>
                                    <p class="mt-1">Scan this code using the QR attendance feature.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="bg-gray-50 dark:bg-zinc-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                        <flux:button 
                            wire:click="generateSingleQrCard({{ $selectedStudentForQr->id }})"
                            variant="primary"
                            class="w-full sm:w-auto bg-green-600 hover:bg-green-700"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download QR Card
                        </flux:button>
                        <flux:button 
                            @click="show = false; $wire.closeQrModal()"
                            variant="ghost"
                            class="w-full sm:w-auto"
                        >
                            Close
                        </flux:button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
</main>