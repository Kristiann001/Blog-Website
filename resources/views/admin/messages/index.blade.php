@extends('admin.layout')

@section('title', 'Contact Messages')

@section('content')
<div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Contact Messages</h2>

    @if($messages->count())
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Message</th>
                        <th class="px-4 py-2">Received At</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $msg)
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-2">{{ $msg->name }}</td>
                        <td class="px-4 py-2">{{ $msg->email }}</td>
                        <td class="px-4 py-2">{{ Str::limit($msg->message, 80, '...') }}</td>
                        <td class="px-4 py-2">{{ $msg->created_at->format('d M Y, H:i') }}</td>
                        
                        <td class="px-4 py-2 space-x-2">

    {{-- View Message --}}
    <a href="{{ route('admin.messages.show', $msg->id) }}" 
       class="text-indigo-600 hover:underline">View</a>

    {{-- Reply Button --}}
    <a href="{{ route('admin.messages.show', $msg->id) }}#reply-form"
       class="text-green-600 hover:underline">Reply</a>

    {{-- Delete --}}
    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:underline"
                onclick="return confirm('Are you sure you want to delete this message?')">
            Delete
        </button>
    </form>

</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    @else
        <p class="text-gray-600 dark:text-gray-300">No messages yet.</p>
    @endif
</div>
@endsection
