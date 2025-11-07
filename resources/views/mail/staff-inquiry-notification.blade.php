<x-mail::message>
# New Student Inquiry

A new student inquiry has been submitted and is currently marked as **PENDING**.

<x-mail::panel>
<strong>Name:</strong> {{ $inquiry->full_name }}

<strong>Email:</strong> {{ $inquiry->email }}

<strong>Reg No:</strong> {{ $inquiry->reg_number ?? '—' }}

<strong>Subject:</strong> {{ $inquiry->subject }}

<strong>Message:</strong>

{{ $inquiry->message }}
</x-mail::panel>

You are receiving this as part of STAFF COHORT 2025 notifications.

<x-mail::button :url="url('/inquiries')">
View in Dashboard
</x-mail::button>

Thanks,
{{ config('app.name') }}
</x-mail::message>
