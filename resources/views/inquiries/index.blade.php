<x-app-layout>
  <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Student Inquiries</h1>
        <p class="text-sm text-gray-500">Monitor and process inquiries submitted from the Contact page.</p>
      </div>
    </div>

    @if (session('success'))
      <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-3">
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border">
      <div class="p-4 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
          <div class="rounded-md bg-blue-50 text-blue-700 px-2.5 py-1 text-xs font-medium">Cohort 2025</div>
          <div class="hidden sm:block text-sm text-gray-500">Total: {{ $inquiries->total() }}</div>
        </div>
        <form method="GET" class="w-full max-w-xs">
          <div class="relative">
            <input type="search" name="q" placeholder="Search..." value="{{ request('q') }}" class="w-full border rounded-md pl-3 pr-8 py-2 text-sm focus:outline-blue-500" />
            <svg class="absolute right-2 top-2.5 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M16.8 11.4a5.4 5.4 0 11-10.8 0 5.4 5.4 0 0110.8 0z"/></svg>
          </div>
        </form>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y-2 divide-gray-200">
          <thead class="ltr:text-left rtl:text-right">
            <tr class="*:font-medium *:text-gray-900">
              <th class="px-3 py-2 whitespace-nowrap">Name</th>
              <th class="px-3 py-2 whitespace-nowrap">Email</th>
              <th class="px-3 py-2 whitespace-nowrap">Reg No</th>
              <th class="px-3 py-2 whitespace-nowrap">Subject</th>
              <th class="px-3 py-2 whitespace-nowrap">Status</th>
              <th class="px-3 py-2 whitespace-nowrap">Submitted</th>
              <th class="px-3 py-2 whitespace-nowrap text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 *:even:bg-gray-50">
            @forelse ($inquiries as $inq)
              <tr class="*:text-gray-900 *:first:font-medium">
                <td class="px-3 py-2 whitespace-nowrap">{{ $inq->full_name }}</td>
                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600">{{ $inq->email }}</td>
                <td class="px-3 py-2 whitespace-nowrap text-sm">{{ $inq->reg_number ?? '—' }}</td>
                <td class="px-3 py-2 whitespace-nowrap">{{ \Illuminate\Support\Str::limit($inq->subject, 40) }}</td>
                <td class="px-3 py-2 whitespace-nowrap">
                  @php
                    $badge = match($inq->status) {
                      'pending' => 'bg-amber-50 text-amber-800 ring-amber-200',
                      'resolved', 'completed' => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
                      default => 'bg-gray-50 text-gray-800 ring-gray-200'
                    };
                    $label = Str::upper($inq->status ?? 'PENDING');
                  @endphp
                  <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium ring-1 ring-inset {{ $badge }}">{{ $label }}</span>
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600">{{ $inq->created_at?->format('d M Y, h:i A') }}</td>
                <td class="px-3 py-2 whitespace-nowrap">
                  <div class="flex items-center justify-end gap-2">
                    @if($inq->status !== 'resolved' && $inq->status !== 'completed')
                      <form method="POST" action="{{ route('inquiries.update', $inq) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button class="inline-flex items-center rounded-md bg-emerald-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-emerald-700">Mark as Done</button>
                      </form>
                    @endif
                    <form method="POST" action="{{ route('inquiries.destroy', $inq) }}" onsubmit="return confirm('Delete this inquiry?')">
                      @csrf
                      @method('DELETE')
                      <button class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="7" class="px-3 pb-4 text-sm text-gray-600">{{ $inq->message }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-3 py-6 text-center text-gray-500">No inquiries yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="px-4 py-3 border-t">
        {{ $inquiries->links() }}
      </div>
    </div>
  </div>
</x-app-layout>
