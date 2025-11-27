<p>Hello {{ $reply->contact->name }},</p>

<p>{{ $reply->reply }}</p>

<p>— Admin {{ $reply->admin->name }}</p>
<p>Sent on {{ $reply->created_at->format('d M Y, H:i') }}</p>
