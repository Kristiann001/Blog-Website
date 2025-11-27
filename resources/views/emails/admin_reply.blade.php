@component('mail::message')
# Hello {{ $messageModel->name }},

You sent us a message:

> {{ $messageModel->message }}

**Admin Reply:**
{{ $reply->reply }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
