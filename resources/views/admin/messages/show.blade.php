@extends('admin.layout')

@section('title', 'View Message')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Message Details</h2>

    <div class="mb-4">
        <strong class="text-gray-700 dark:text-gray-200">Name:</strong>
        <span class="text-gray-800 dark:text-gray-100">{{ $message->name }}</span>
    </div>

    <div class="mb-4">
        <strong class="text-gray-700 dark:text-gray-200">Email:</strong>
        <span class="text-gray-800 dark:text-gray-100">{{ $message->email }}</span>
    </div>

    <div class="mb-4">
        <strong class="text-gray-700 dark:text-gray-200">Message:</strong>
        <div class="mt-2 p-4 bg-gray-100 dark:bg-gray-700 rounded text-gray-800 dark:text-gray-100">
            {{ $message->message }}
        </div>
    </div>

    <!-- Reply Form -->
<div class="mt-10 bg-gray-100 dark:bg-gray-700 p-4 rounded">
    <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-200">
        Reply to this Message
    </h3>

    <form action="{{ route('admin.messages.reply', $message->id) }}" method="POST">
        @csrf
        <textarea 
            name="reply" 
            rows="4" 
            class="w-full p-3 border rounded dark:bg-gray-800 dark:text-gray-100"
            placeholder="Type your reply..."
            required
        ></textarea>

        <button 
            type="submit"
            class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500"
        >
            Send Reply
        </button>
    </form>
 </div>

    <!-- <div class="mb-4">
        <strong class="text-gray-700 dark:text-gray-200">Received At:</strong>
        <span class="text-gray-800 dark:text-gray-100">{{ $message->created_at->format('d M Y, H:i') }}</span>
    </div> -->

    <div class="flex gap-4 mt-6">
        <a href="{{ route('admin.messages.index') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-200">
           Back to Messages
        </a>

        <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this message?');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500">
                Delete Message
            </button>
        </form>
    </div>
</div>
@endsection
