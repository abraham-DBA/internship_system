@component('mail::message')
# Internship Approval

Dear {{ $student->full_name }},

Your internship registration has been approved. Below are your assigned supervisor details:

- Supervisor: **{{ $student->supervisor_name }}**
- Email: **{{ $student->supervisor_email }}**

We have attached your approval letter to this email for download and records.

Thanks,
{{ config('app.name') }}
@endcomponent
