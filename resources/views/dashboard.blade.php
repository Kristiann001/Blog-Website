<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ auth()->user()->role === 'admin' ? __('Admin Dashboard') : __('My Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Profile Summary -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">{{ __('Account Info') }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Name:</strong> {{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Role:</strong> <span class="uppercase">{{ auth()->user()->role }}</span></p>
                </div>

                @if(auth()->user()->role === 'admin')
                    <!-- Admin Quick Stats -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">{{ __('Platform Stats') }}</h3>
                        @php
                            $totalPosts = \App\Models\Post::count();
                            $totalSales = \App\Models\Payment::where('status', 'completed')->sum('amount');
                        @endphp
                        <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Total Posts:</strong> {{ $totalPosts }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Total Revenue:</strong> Ksh {{ number_format($totalSales) }}</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.posts.index') }}" class="text-cyan-500 hover:underline text-sm font-bold uppercase tracking-widest">Manage Posts &rarr;</a>
                        </div>
                    </div>
                @else
                    <!-- Customer Purchased Content -->
                    <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">{{ __('My Purchased Content') }}</h3>
                        @php
                            $purchased = auth()->user()->payments()->where('status', 'completed')->with('post')->get();
                        @endphp
                        @if($purchased->count() > 0)
                            <div class="space-y-4">
                                @foreach($purchased as $payment)
                                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-2">
                                        <a href="{{ route('blog.show', $payment->post->slug) }}" class="text-cyan-500 hover:text-cyan-600 font-medium">{{ $payment->post->title }}</a>
                                        <span class="text-xs text-gray-400 uppercase tracking-widest">Ksh {{ number_format($payment->amount) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic">{{ __('You haven\'t purchased any premium content yet.') }}</p>
                            <div class="mt-4">
                                <a href="{{ route('blog.index') }}" class="text-cyan-500 hover:underline text-sm font-bold uppercase tracking-widest">Browse Blog &rarr;</a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
