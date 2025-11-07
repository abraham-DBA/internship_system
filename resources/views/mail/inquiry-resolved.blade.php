<x-mail::message>
# Inquiry Update: Completed

Hello {{ $inquiry->full_name }},

Your inquiry titled "{{ $inquiry->subject }}" has been processed and marked as **COMPLETED**.

<x-mail::panel>
<strong>Submitted On:</strong> {{ $inquiry->created_at->format('d M Y, h:i A') }}

<strong>Summary of your message:</strong>

{{ $inquiry->message }}
</x-mail::panel>

If further action is required, the admin team will reach out with additional instructions.

<x-mail::button :url="url('/')">
Go to Portal
</x-mail::button>

Thanks,
{{ config('app.name') }}
</x-mail::message>
