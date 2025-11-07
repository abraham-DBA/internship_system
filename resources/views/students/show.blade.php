<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <div class="mb-4 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-gray-700 hover:text-indigo-600">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                <span>Back to Students</span>
            </a>
            <div>
                @php $st = strtolower($student->status ?? 'pending'); @endphp
                <span class="inline-flex items-center rounded px-2 py-1 text-xs {{ $st==='approved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    Status: {{ ucfirst($st) }}
                </span>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-md border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-md border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm">
                <div class="font-semibold mb-1">There were some problems with your input:</div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Details Card -->
            <div class="lg:col-span-2 border rounded-lg bg-white">
                <div class="p-5 border-b flex items-center justify-between">
                    <h1 class="text-xl font-semibold">Student Details</h1>
                    <div class="text-sm text-gray-500">Reg #: {{ $student->reg_number }}</div>
                </div>
                <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <div class="text-gray-500">Full Name</div>
                        <div class="font-medium">{{ $student->full_name }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500">Program</div>
                        <div class="font-medium">{{ $student->course }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500">Organisation</div>
                        <div class="font-medium">{{ $student->organization_name ?: '—' }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500">Student Contact</div>
                        <div class="font-medium">{{ $student->student_contact ?: '—' }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500">Student Email</div>
                        <div class="font-medium">{{ $student->student_email ?: '—' }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500">Supervisor</div>
                        <div class="font-medium">{{ $student->supervisor_name ? $student->supervisor_name.' ('.$student->supervisor_email.')' : '—' }}</div>
                    </div>
                    <div class="md:col-span-2">
                        <div class="text-gray-500">Notes</div>
                        <div class="font-medium whitespace-pre-line">{{ $student->notes ?: '—' }}</div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="border rounded-lg bg-white">
                <div class="p-5 border-b">
                    <h2 class="text-lg font-semibold">Actions</h2>
                </div>
                <div class="p-5 space-y-4">
                    @if(($student->status ?? 'pending') === 'pending')
                        <div>
                            <div class="text-sm font-medium mb-2">Approve & Assign Supervisor</div>
                            <form method="POST" action="{{ route('students.approve', $student) }}" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="text-xs text-gray-600">Select Supervisor</label>
                                    <select name="supervisor_key" class="mt-1 w-full border rounded h-9 text-sm px-2" required>
                                        @foreach(($supervisors ?? []) as $key => $sup)
                                            <option value="{{ $key }}">{{ $sup['name'] }} — {{ $sup['email'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="w-full h-9 inline-flex items-center justify-center rounded-md border bg-green-600 text-white hover:bg-green-700">
                                    <i data-lucide="check" class="h-4 w-4 mr-2"></i>
                                    Approve Student
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="rounded-md border border-green-200 bg-green-50 text-green-800 px-3 py-2 text-sm">
                            This student has been approved.
                        </div>
                    @endif

                    <div class="border-t pt-4">
                        <div class="text-sm font-medium mb-2">Quick Edit</div>
                        <form method="POST" action="{{ route('students.update', $student) }}" class="space-y-3">
                            @csrf
                            @method('PATCH')
                            <input name="full_name" value="{{ old('full_name', $student->full_name) }}" class="w-full border rounded-md h-9 px-3 text-sm" placeholder="Full Name" required />
                            <input name="reg_number" value="{{ old('reg_number', $student->reg_number) }}" class="w-full border rounded-md h-9 px-3 text-sm" placeholder="Reg Number" required />
                            <input name="course" value="{{ old('course', $student->course) }}" class="w-full border rounded-md h-9 px-3 text-sm" placeholder="Program" required />
                            <input name="organization_name" value="{{ old('organization_name', $student->organization_name) }}" class="w-full border rounded-md h-9 px-3 text-sm" placeholder="Organisation" />
                            <input name="student_contact" value="{{ old('student_contact', $student->student_contact) }}" class="w-full border rounded-md h-9 px-3 text-sm" placeholder="Contact" />
                            <input name="student_email" type="email" value="{{ old('student_email', $student->student_email) }}" class="w-full border rounded-md h-9 px-3 text-sm" placeholder="Email" />
                            <textarea name="notes" rows="3" class="w-full border rounded-md px-3 py-2 text-sm" placeholder="Notes">{{ old('notes', $student->notes) }}</textarea>
                            <div class="flex items-center justify-between">
                                <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete this student? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="h-9 px-3 inline-flex items-center justify-center rounded-md border bg-white text-red-600 hover:bg-red-50">
                                        <i data-lucide="trash-2" class="h-4 w-4 mr-2"></i> Delete
                                    </button>
                                </form>
                                <button type="submit" class="h-9 px-3 inline-flex items-center justify-center rounded-md border bg-indigo-600 text-white hover:bg-indigo-700">
                                    <i data-lucide="save" class="h-4 w-4 mr-2"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script src="https://unpkg.com/lucide@latest"></script>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    if (window.lucide && typeof window.lucide.createIcons === 'function') {
                        window.lucide.createIcons();
                    }
                });
            </script>
        @endpush
    </div>
</x-app-layout>
