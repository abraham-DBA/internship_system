<x-app-layout>
    @php
        // Helper to get initials from a full name
        if (!function_exists('blade_get_initials')) {
            function blade_get_initials(?string $name): string {
                if (!$name) return 'CN';
                $parts = preg_split('/\s+/', trim($name));
                $initials = array_map(fn($p) => strtoupper(mb_substr($p, 0, 1)), $parts);
                return implode('', $initials);
            }
        }

        // Sidebar links
        $sidebarLinks = [
            [ 'title' => 'Dashboard', 'href' => url('/dashboard'), 'icon' => 'home' ],
            [ 'title' => 'Student Inquiries', 'href' => url('/inquiries'), 'icon' => 'inbox' ],
        ];

        // Analytics is provided by the controller with live counts
        // $analytics variable expected here

        $status = 'APPROVED';
        $currentUrl = url()->current();
    @endphp

    {{-- We intentionally do not use the default header slot; this screen has its own header and sidebar layout. --}}

    <div class="grid min-h-screen w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr]">
        <!-- Desktop Sidebar -->
        <aside class="hidden border-r bg-gray-50 dark:bg-gray-800/40 md:block">
            <div class="flex h-full max-h-screen flex-col gap-2">
                <div class="flex h-14 items-center border-b px-4 lg:h-[60px] lg:px-6">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 font-semibold text-gray-900 dark:text-gray-100">
                        <i data-lucide="package-2" class="h-6 w-6"></i>
                        <span>STUDENT INTERNSHIP PORTAL</span>
                    </a>

                </div>
                <div class="flex-1 overflow-y-auto">
                    <nav class="grid items-start px-2 text-sm font-medium lg:px-4">
                        @foreach ($sidebarLinks as $item)
                            @php
                                $isActive = $item['href'] === $currentUrl;
                            @endphp
                            <a href="{{ $item['href'] }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-500 hover:text-indigo-600 transition-all {{ $isActive ? 'bg-gray-100 dark:bg-gray-900 text-indigo-600' : '' }}">
                                <i data-lucide="{{ $item['icon'] }}" class="h-4 w-4"></i>
                                <span>{{ $item['title'] }}</span>
                                @if (!empty($item['count']))
                                    <span class="ml-auto flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-white text-xs">{{ $item['count'] }}</span>
                                @endif
                            </a>
                        @endforeach

                    </nav>
                </div>
                </div>
        </aside>

        <!-- Main Column -->
        <div class="flex flex-col">
            <!-- Topbar -->
            <header class="flex h-14 items-center gap-4 border-b bg-gray-50 dark:bg-gray-800/40 px-4 lg:h-[60px] lg:px-6" x-data="{ open:false, userMenu:false }">
                <!-- Mobile menu button -->
                <button @click="open=true" class="shrink-0 md:hidden inline-flex items-center justify-center rounded-md border bg-white dark:bg-gray-900 h-9 w-9" type="button">
                    <i data-lucide="menu" class="h-5 w-5"></i>
                    <span class="sr-only">Toggle navigation menu</span>
                </button>

                <!-- Mobile Sheet -->
                <div x-show="open" x-transition.opacity x-cloak class="fixed inset-0 z-40 bg-black/40 md:hidden" @click="open=false"></div>
                <aside x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed z-50 top-0 left-0 h-full w-72 bg-white dark:bg-gray-900 shadow-md md:hidden p-6">
                    <div class="flex items-center justify-between mb-6">
                        <a href="#" class="flex items-center gap-2 font-semibold">
                            <i data-lucide="package-2" class="h-6 w-6"></i>
                            <span class="sr-only">MUBS INTERNSHIP PORTAL</span>
                        </a>
                        <button class="h-9 w-9 inline-flex items-center justify-center rounded-md border" @click="open=false">
                            <i data-lucide="x" class="h-5 w-5"></i>
                        </button>
                    </div>
                    <nav class="grid gap-2 text-base font-medium">
                        @foreach ($sidebarLinks as $item)
                            <a href="{{ $item['href'] }}" class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 {{ $item['href'] === $currentUrl ? 'bg-gray-100 dark:bg-gray-800 text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                                <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i>
                                <span>{{ $item['title'] }}</span>
                                @if (!empty($item['count']))
                                    <span class="ml-auto flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-white text-xs">{{ $item['count'] }}</span>
                                @endif
                            </a>
                        @endforeach
                    </nav>



                </aside>

                <!-- Search -->
                <div class="w-full flex-1">
                    <form onsubmit="return false;">
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400"></i>
                            <input type="search" placeholder="Search Students..." class="w-full appearance-none bg-white dark:bg-gray-900 border rounded-md h-9 pl-8 pr-3 text-sm shadow-none md:w-2/3 lg:w-1/3 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        </div>
                    </form>
                </div>

                <!-- User dropdown -->
                <div class="relative" @click.outside="userMenu=false">
                    <button @click="userMenu=!userMenu" class="flex items-center justify-center rounded-full h-9 w-9 overflow-hidden border">
                        <img src="https://github.com/shadcn.png" alt="avatar" class="h-full w-full object-cover" />
                    </button>
                    <div x-show="userMenu" x-cloak x-transition class="absolute right-0 mt-2 w-56 rounded-md border bg-white dark:bg-gray-900 shadow-lg overflow-hidden z-10">
                        <div class="px-3 py-2 text-center text-sm font-semibold">Welcome, {{ auth()->user()?->name ?? 'User' }}</div>
                        <div class="px-3 pb-2 text-center text-xs text-gray-500">jbwebdeveloper@gmail.com</div>

                </div>
            </header>

            <!-- Page Content -->
            <div class="flex min-h-screen w-full flex-col">
                <div class="px-4 sm:px-6 lg:px-8 py-4" x-data="{ showCreate:false }">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-extrabold tracking-tight mb-3">Welcome, {{ auth()->user()?->name ?? 'User' }}</h1>
                        <div class="flex items-center gap-2">
                            @php
                                $statusClasses = $status === 'APPROVED' ? 'bg-green-500 text-white' : ($status === 'PENDING' ? 'bg-orange-400 text-white' : 'bg-red-500 text-white');
                                $statusIcon = $status === 'APPROVED' ? 'check' : ($status === 'PENDING' ? 'refresh-ccw' : 'x');
                            @endphp
                            <button class="py-2 px-3 rounded-md text-xs inline-flex items-center gap-2 {{ $statusClasses }}">
                                <i data-lucide="{{ $statusIcon }}" class="h-4 w-4"></i>
                                <span>{{ $status }}</span>
                            </button>
                            <button @click="showCreate=true" class="py-2 px-3 rounded-md text-xs inline-flex items-center gap-2 border bg-indigo-600 text-white hover:bg-indigo-700">
                                <i data-lucide="plus" class="h-4 w-4"></i>
                                <span>Add Student</span>
                            </button>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mt-4 rounded-md border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-4 rounded-md border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm">
                            <div class="font-semibold mb-1">There were some problems with your input:</div>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Analytics cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 py-6">
                        @foreach ($analytics as $item)
                            <div class="border rounded-lg bg-white dark:bg-gray-900">
                                <div class="p-4 flex items-center justify-between">
                                    <div class="text-sm font-medium">{{ $item['title'] }}</div>
                                    <i data-lucide="{{ $item['icon'] }}" class="h-4 w-4 text-gray-400"></i>
                                </div>
                                <div class="px-4 pb-4">
                                    <div class="text-2xl font-bold">{{ $item['unit'] }}{{ str_pad((string)$item['count'], 2, '0', STR_PAD_LEFT) }}</div>
                                    <a href="{{ $item['detailLink'] }}" class="text-xs text-gray-500 hover:text-indigo-600">View Details</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Table for Isaac --}}
                    <div class="overflow-x-auto rounded border border-gray-300 shadow-sm">
                        <table class="min-w-full divide-y-2 divide-gray-200">
                            <thead class="ltr:text-left rtl:text-right">
                            <tr class="*:font-medium *:text-gray-900">
                                <th class="px-3 py-2 whitespace-nowrap">Full Name</th>
                                <th class="px-3 py-2 whitespace-nowrap">Reg Number</th>
                                <th class="px-3 py-2 whitespace-nowrap">Program</th>
                                <th class="px-3 py-2 whitespace-nowrap hidden md:table-cell">Organisation</th>
                                <th class="px-3 py-2 whitespace-nowrap">Status</th>
                                <th class="px-3 py-2 whitespace-nowrap text-right">Actions</th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                            @forelse($students as $student)
                            <tr class=":text-gray-900 hover:bg-gray-50 transition-colors *:first:font-medium">
                                <td class="px-3 py-2 whitespace-nowrap">{{ $student->full_name }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $student->reg_number }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $student->course }}</td>
                                <td class="px-3 py-2 whitespace-nowrap hidden md:table-cell">{{ $student->organization_name }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    @php $st = strtolower($student->status ?? 'pending'); @endphp
                                    <span class="inline-flex items-center rounded px-2 py-0.5 text-xs {{ $st==='approved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($st) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('students.show', $student) }}" class="h-8 px-3 inline-flex items-center justify-center rounded-md border bg-white hover:bg-gray-50" title="View">
                                            <i data-lucide="eye" class="h-4 w-4 mr-1"></i> View
                                        </a>
                                        <div x-data="{ open:false }" class="inline-block">
                                            <button @click="open=true" class="h-8 w-8 inline-flex items-center justify-center rounded-md border bg-white hover:bg-gray-50" title="Edit">
                                                <i data-lucide="pencil" class="h-4 w-4"></i>
                                            </button>
                                            <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete this student? This cannot be undone.');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="h-8 w-8 inline-flex items-center justify-center rounded-md border bg-white hover:bg-gray-50 text-red-600" title="Delete">
                                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                                </button>
                                            </form>

                                            <!-- Edit Modal -->
                                            <div x-show="open" x-cloak x-transition.opacity class="fixed inset-0 z-40 bg-black/40" @click="open=false"></div>
                                            <div x-show="open" x-cloak x-transition class="fixed z-50 inset-0 flex items-start justify-center p-4">
                                                <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-lg border bg-white shadow-lg" @click.stop>
                                                    <div class="flex items-center justify-between p-4 border-b">
                                                        <h2 class="font-semibold">Edit Student</h2>
                                                        <button class="h-8 w-8 inline-flex items-center justify-center rounded-md border bg-white" @click="open=false">
                                                            <i data-lucide=\"x\" class="h-4 w-4"></i>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="{{ route('students.update', $student) }}" class="p-4 space-y-3">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                            <div>
                                                                <label class="text-xs text-gray-600">Full Name</label>
                                                                <input name="full_name" value="{{ old('full_name', $student->full_name) }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" required />
                                                            </div>
                                                            <div>
                                                                <label class="text-xs text-gray-600">Reg Number</label>
                                                                <input name="reg_number" value="{{ old('reg_number', $student->reg_number) }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" required />
                                                            </div>
                                                            <div>
                                                                <label class="text-xs text-gray-600">Program</label>
                                                                <input name="course" value="{{ old('course', $student->course) }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" required />
                                                            </div>
                                                            <div>
                                                                <label class="text-xs text-gray-600">Organisation</label>
                                                                <input name="organization_name" value="{{ old('organization_name', $student->organization_name) }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" />
                                                            </div>
                                                            <div>
                                                                <label class="text-xs text-gray-600">Student Contact</label>
                                                                <input name="student_contact" value="{{ old('student_contact', $student->student_contact) }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" />
                                                            </div>
                                                            <div>
                                                                <label class="text-xs text-gray-600">Student Email</label>
                                                                <input name="student_email" type="email" value="{{ old('student_email', $student->student_email) }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" />
                                                            </div>
                                                            <div class="md:col-span-2">
                                                                <label class="text-xs text-gray-600">Notes</label>
                                                                <textarea name="notes" rows="3" class="mt-1 w-full border rounded-md px-3 py-2 text-sm">{{ old('notes', $student->notes) }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center justify-end gap-2 pt-2 border-t">
                                                            <button type="button" @click="open=false" class="py-2 px-3 rounded-md text-xs inline-flex items-center gap-2 border bg-white hover:bg-gray-50">Cancel</button>
                                                            <button type="submit" class="py-2 px-3 rounded-md text-xs inline-flex items-center gap-2 border bg-indigo-600 text-white hover:bg-indigo-700">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-3 py-6 text-center text-gray-500">No students found. Click "Add Student" to create one.</td>
                                </tr>
                            @endforelse
{{--                            <tr class="*:text-gray-900 *:first:font-medium">--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">Laszlo Cravensworth</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">19/10/1678</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">Vampire Gentleman</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">$0</td>--}}
{{--                            </tr>--}}

{{--                            <tr class="*:text-gray-900 *:first:font-medium">--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">Nadja</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">15/03/1593</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">Vampire Seductress</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">$0</td>--}}
{{--                            </tr>--}}

{{--                            <tr class="*:text-gray-900 *:first:font-medium">--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">Colin Robinson</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">01/09/1971</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">Energy Vampire</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">$53,000</td>--}}
{{--                            </tr>--}}

{{--                            <tr class="*:text-gray-900 *:first:font-medium">--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">Guillermo de la Cruz</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">18/11/1991</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">Familiar/Vampire Hunter</td>--}}
{{--                                <td class="px-3 py-2 whitespace-nowrap">$0</td>--}}
{{--                            </tr>--}}
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>

                    <!-- Create Student Modal -->
                    <div x-show="showCreate" x-cloak x-transition.opacity class="fixed inset-0 z-40 bg-black/40" @click="showCreate=false"></div>
                    <div x-show="showCreate" x-cloak x-transition class="fixed z-50 inset-0 flex items-start justify-center p-4">
                        <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-lg border bg-white shadow-lg" @click.stop>
                            <div class="flex items-center justify-between p-4 border-b">
                                <h2 class="font-semibold">Add Student</h2>
                                <button class="h-8 w-8 inline-flex items-center justify-center rounded-md border bg-white" @click="showCreate=false">
                                    <i data-lucide="x" class="h-4 w-4"></i>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('students.store') }}" class="p-4 space-y-3">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-xs text-gray-600">Full Name</label>
                                        <input name="full_name" value="{{ old('full_name') }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" required />
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Reg Number</label>
                                        <input name="reg_number" value="{{ old('reg_number') }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" required />
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Program</label>
                                        <input name="course" value="{{ old('course') }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" required />
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Organisation</label>
                                        <input name="organization_name" value="{{ old('organization_name') }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Student Contact</label>
                                        <input name="student_contact" value="{{ old('student_contact') }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" />
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Student Email</label>
                                        <input name="student_email" type="email" value="{{ old('student_email') }}" class="mt-1 w-full border rounded-md h-9 px-3 text-sm" required />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="text-xs text-gray-600">Notes</label>
                                        <textarea name="notes" rows="3" class="mt-1 w-full border rounded-md px-3 py-2 text-sm">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end gap-2 pt-2 border-t">
                                    <button type="button" @click="showCreate=false" class="py-2 px-3 rounded-md text-xs inline-flex items-center gap-2 border bg-white hover:bg-gray-50">Cancel</button>
                                    <button type="submit" class="py-2 px-3 rounded-md text-xs inline-flex items-center gap-2 border bg-indigo-600 text-white hover:bg-indigo-700">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                // nothing for now; Alpine is already started in resources/js/app.js
            });
            document.addEventListener('DOMContentLoaded', () => {
                if (window.lucide && typeof window.lucide.createIcons === 'function') {
                    window.lucide.createIcons();
                }
            });
        </script>
    @endpush
</x-app-layout>
