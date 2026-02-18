@extends('layouts.app')

@section('title', 'Payments — Admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Payments</h1>
        <a href="{{ route('admin.posts.index') }}" class="text-sm text-cyan-600 hover:underline">← Back to Posts</a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl text-sm">
            {{ session('info') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Post</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($payments as $payment)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $payment->user->name ?? 'Unknown' }}<br>
                        <span class="text-xs text-gray-400">{{ $payment->user->email ?? '' }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-700">
                        {{ Str::limit($payment->post->title ?? 'Deleted Post', 40) }}
                    </td>
                    <td class="px-6 py-4 text-gray-700">Ksh {{ number_format($payment->amount) }}</td>
                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">{{ $payment->phone_number }}</td>
                    <td class="px-6 py-4">
                        @if($payment->status === 'completed')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle"></i> Completed
                            </span>
                        @elseif($payment->status === 'pending')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                <i class="fas fa-times-circle"></i> Failed
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $payment->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4">
                        @if($payment->status === 'pending')
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.payments.approve', $payment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        onclick="return confirm('Approve this payment and unlock content for the user?')"
                                        class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition-colors">
                                        ✓ Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $payment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        onclick="return confirm('Mark this payment as failed?')"
                                        class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold rounded-lg transition-colors">
                                        ✗ Reject
                                    </button>
                                </form>
                            </div>
                        @elseif($payment->status === 'completed')
                            <span class="text-xs text-gray-400">{{ $payment->mpesa_receipt_number }}</span>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $payments->links() }}
    </div>
</div>
@endsection
