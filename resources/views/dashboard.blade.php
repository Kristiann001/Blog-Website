<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="brand-font text-3xl text-gray-900 leading-tight">
                {{ auth()->user()->role === 'admin' ? __('Zenith Command Center') : __('Reader Dashboard') }}
            </h2>
            <div class="flex items-center space-x-2">
                <span class="text-[10px] uppercase tracking-[0.3em] font-bold text-gray-400">Account Type:</span>
                <span class="text-[10px] uppercase tracking-[0.3em] font-bold text-cyan-500 bg-cyan-50 px-3 py-1 rounded-full">{{ auth()->user()->role }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/30">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Profile & Stats -->
                <div class="bg-white/80 backdrop-blur-xl border border-white/20 overflow-hidden shadow-2xl rounded-3xl p-8 relative">
                    <div class="absolute top-0 right-0 p-4">
                        <i class="fas fa-crown text-cyan-200 text-6xl opacity-20 -rotate-12 translate-x-4"></i>
                    </div>
                    <h3 class="brand-font text-xl font-bold mb-6 text-gray-900">{{ __('Overview') }}</h3>
                    <div class="space-y-6">
                        <div>
                            <p class="text-[9px] uppercase tracking-widest text-gray-400 font-bold mb-1">Authenticated As</p>
                            <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                        
                        @if(auth()->user()->role === 'admin')
                            @php
                                $totalPosts = \App\Models\Post::count();
                                $totalSales = \App\Models\Payment::where('status', 'completed')->sum('amount');
                            @endphp
                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                                <div>
                                    <p class="text-[9px] uppercase tracking-widest text-gray-400 font-bold mb-1">Total Library</p>
                                    <p class="text-xl brand-font font-bold text-cyan-600">{{ $totalPosts }}</p>
                                </div>
                                <div>
                                    <p class="text-[9px] uppercase tracking-widest text-gray-400 font-bold mb-1">Gross Yield</p>
                                    <p class="text-xl brand-font font-bold text-cyan-600">Ksh {{ number_format($totalSales) }}</p>
                                </div>
                            </div>
                        @else
                            <div class="pt-4 border-t border-gray-100">
                                <p class="text-[9px] uppercase tracking-widest text-gray-400 font-bold mb-1">Member Since</p>
                                <p class="text-sm font-bold text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-8">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center text-[10px] font-bold uppercase tracking-[0.2em] text-cyan-500 hover:text-cyan-600 transition group">
                            Account Settings 
                            <i class="fas fa-chevron-right ml-2 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>

                @if(auth()->user()->role === 'admin')
                    <!-- Admin Quick Controls -->
                    <div class="md:col-span-2 bg-gray-900 text-white overflow-hidden shadow-2xl rounded-3xl p-8 relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-transparent"></div>
                        <h3 class="brand-font text-xl font-bold mb-6 relative z-10">{{ __('Editorial Controls') }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 relative z-10">
                            <a href="{{ route('admin.posts.index') }}" class="glass p-6 rounded-2xl hover:bg-white/10 transition group border border-white/5">
                                <i class="fas fa-feather-pointed text-2xl text-cyan-400 mb-4"></i>
                                <h4 class="text-sm font-bold uppercase tracking-widest mb-1">Manage Stories</h4>
                                <p class="text-xs text-gray-400">Review, publish, and stage content.</p>
                            </a>
                            <a href="{{ route('admin.posts.create') }}" class="glass p-6 rounded-2xl hover:bg-white/10 transition group border border-white/5">
                                <i class="fas fa-plus-circle text-2xl text-cyan-400 mb-4"></i>
                                <h4 class="text-sm font-bold uppercase tracking-widest mb-1">Compose New</h4>
                                <p class="text-xs text-gray-400">Draft your next masterpiece.</p>
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Customer Purchased Content -->
                    <div class="md:col-span-2 bg-white/60 backdrop-blur-md overflow-hidden shadow-xl border border-gray-100 rounded-3xl p-8">
                        <h3 class="brand-font text-xl font-bold mb-6 text-gray-900">{{ __('Your Exclusive Library') }}</h3>
                        @php
                            $purchased = auth()->user()->payments()->where('status', 'completed')->with('post')->get();
                        @endphp
                        @if($purchased->count() > 0)
                            <div class="space-y-4">
                                @foreach($purchased as $payment)
                                    <div class="flex items-center justify-between p-4 bg-white/50 border border-gray-50 rounded-2xl hover:border-cyan-100 transition">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 rounded-lg bg-cyan-50 flex items-center justify-center text-cyan-600">
                                                <i class="fas fa-lock-open text-xs"></i>
                                            </div>
                                            <div>
                                                <a href="{{ route('blog.show', $payment->post->slug) }}" class="text-sm font-bold text-gray-900 hover:text-cyan-600 transition">{{ $payment->post->title }}</a>
                                                <p class="text-[9px] text-gray-400 uppercase tracking-widest">Unlocked {{ $payment->updated_at->format('M d') }}</p>
                                            </div>
                                        </div>
                                        <span class="text-[10px] font-bold text-cyan-500 uppercase tracking-widest">Ksh {{ number_format($payment->amount) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <i class="fas fa-layer-group text-4xl text-gray-200 mb-4"></i>
                                <p class="text-sm text-gray-400 italic mb-6 uppercase tracking-widest font-bold">Your library is waiting.</p>
                                <a href="{{ route('blog.index') }}" class="inline-flex bg-gray-900 text-white px-8 py-3 rounded-full text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-cyan-500 transition shadow-lg">Discover Stories</a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
