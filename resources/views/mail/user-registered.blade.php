<x-mail::message>
# Introduction

Congrats! {{$user->name}} has now been Registered.

<x-mail::button :url="''">
Button
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
