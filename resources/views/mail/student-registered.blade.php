<x-mail::message>
# Introduction

Dear {{ $student->full_name }},

Your registration is successful.

<x-mail::button :url="config('app.url')">
Go to site
</x-mail::button>

Thanks,
{{ config('app.name') }}
</x-mail::message>
