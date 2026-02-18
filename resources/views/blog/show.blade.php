@extends('layouts.app')

@section('title', $post->title . ' — Zenith Stories')

@section('content')

{{-- Global Toast Component --}}
<div x-data="toastComponent()" 
     @toast.window="add($event.detail)"
     class="fixed bottom-6 right-6 z-[100] flex flex-col space-y-3 pointer-events-none">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.visible"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="pointer-events-auto flex items-center bg-gray-900 text-white px-5 py-3.5 rounded-2xl shadow-2xl border border-white/10 min-w-[300px] max-w-sm">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-xl bg-cyan-600/20 text-cyan-400 mr-3.5">
                <i x-show="toast.type === 'success'" class="fas fa-check-circle text-lg"></i>
                <i x-show="toast.type === 'error'" class="fas fa-exclamation-circle text-lg"></i>
                <i x-show="toast.type === 'info'" class="fas fa-info-circle text-lg"></i>
            </div>
            <div class="flex-grow">
                <p class="text-sm font-semibold text-gray-100" x-text="toast.message"></p>
            </div>
            <button @click="remove(toast.id)" class="ml-4 text-gray-500 hover:text-white transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
    </template>
</div>

<article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16 animate-fade-up">

    {{-- Flash messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-600 hover:text-green-800"><i class="fas fa-times"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-red-600 hover:text-red-800"><i class="fas fa-times"></i></button>
        </div>
    @endif

    {{-- Featured Image --}}
    @if($post->featured_image)
        <div class="relative rounded-2xl overflow-hidden mb-8 shadow-lg card-zoom">
            <img src="{{ asset('storage/' . $post->featured_image) }}"
                 alt="{{ $post->title }}"
                 class="w-full h-auto max-h-[500px] object-cover">
        </div>
    @endif

    {{-- Header --}}
    <header class="mb-8">
        <div class="flex items-center space-x-3 mb-4">
            <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-cyan-600 bg-cyan-50 px-2.5 py-1 rounded-md">
                {{ $post->category->name ?? 'General' }}
            </span>
            @if($post->price > 0)
                <span class="text-[10px] font-bold tracking-wider uppercase text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md">
                    <i class="fas fa-lock text-[8px] mr-1"></i> Premium · Ksh {{ number_format($post->price) }}
                </span>
            @endif
        </div>

        <h1 class="text-3xl sm:text-4xl md:text-[2.75rem] font-extrabold text-gray-900 leading-tight tracking-tight mb-5">
            {{ $post->title }}
        </h1>

        <div class="flex items-center space-x-3 text-sm text-gray-500">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                <i class="fas fa-user text-xs text-gray-400"></i>
            </div>
            <div>
                <span class="font-semibold text-gray-800">{{ $post->user->name }}</span>
                <span class="mx-1.5 text-gray-300">&middot;</span>
                <time>{{ $post->published_at ? $post->published_at->format('F d, Y') : 'Draft' }}</time>
            </div>
        </div>
    </header>

    <hr class="border-gray-100 mb-8">

    {{-- Body --}}
    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
        @php
            $isPremium = $post->price > 0;
            $hasPurchased = auth()->check() && auth()->user()->hasPurchased($post);
            $isAdmin = auth()->check() && auth()->user()->role === 'admin';
        @endphp

        @if(!$isPremium || $hasPurchased || $isAdmin)
            <div class="article-body space-y-5">
                {!! nl2br(e($post->content)) !!}
            </div>
        @else
            <div class="mt-2 p-6 border border-dashed border-amber-400 rounded-xl bg-amber-50">
                <h3 class="text-lg font-semibold mb-4 text-amber-800">Unlock full story for Ksh {{ number_format($post->price) }}</h3>
                
                <form id="mpesa-form" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            M-Pesa Phone Number (254XXXXXXXXX)
                        </label>
                        <input 
                            type="tel" 
                            id="phone_number" 
                            value="254759725385"
                            maxlength="12"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            placeholder="254759725385"
                            required>
                    </div>

                    <button 
                        type="button" 
                        id="pay-button"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                        <span id="button-text">Pay Ksh {{ number_format($post->price) }} with M-Pesa</span>
                    </button>
                </form>

                <div id="status-message" class="mt-4 text-center text-sm"></div>
            </div>
        @endif
    </div>

    {{-- Back link --}}
    <div class="mt-12 pt-8 border-t border-gray-100">
        <a href="{{ route('blog.index') }}"
           class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-cyan-600 transition-colors group">
            <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            Back to all stories
        </a>
    </div>
</article>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const payBtn          = document.getElementById('pay-button');
    const phoneInput      = document.getElementById('phone_number');
    const messageDiv      = document.getElementById('status-message');
    const form            = document.getElementById('mpesa-form');
    const postId          = {{ $post->id }};
    let pollingTimer      = null;
    let pollingStartTime  = null;

    function setMessage(text, type = 'info') {  // info | success | error | warning
        messageDiv.innerHTML = `<div class="p-3 rounded-lg text-center font-medium
            ${type === 'success' ? 'bg-green-100 text-green-800' : ''}
            ${type === 'error'   ? 'bg-red-100   text-red-800'   : ''}
            ${type === 'warning' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-50 text-blue-800'}">
            ${text}
        </div>`;
    }

    function startPolling(checkoutRequestId) {
        if (pollingTimer) clearInterval(pollingTimer);

        setMessage('Payment request sent! Please check your phone and enter your PIN.', 'info');
        payBtn.disabled = true;
        document.getElementById('button-text').textContent = 'Processing – check your phone';

        pollingStartTime = Date.now();

        pollingTimer = setInterval(async () => {
            // Safety timeout: stop after ~4 minutes
            if (Date.now() - pollingStartTime > 240000) {
                clearInterval(pollingTimer);
                setMessage('Payment check timed out. Please refresh the page or contact support.', 'warning');
                resetButton();
                return;
            }

            try {
                const response = await fetch(`/api/payment/status/${checkoutRequestId}`);
                const data = await response.json();

                if (data.status === 'completed') {
                    clearInterval(pollingTimer);
                    setMessage('✅ Payment successful! Loading full content...', 'success');
                    // Small delay → then reload (gives nice UX feedback)
                    setTimeout(() => location.reload(), 1200);
                }
                else if (data.status === 'failed') {
                    clearInterval(pollingTimer);
                    setMessage('❌ Payment failed or was cancelled.<br>You can try again.', 'error');
                    resetButton();
                }
                // else → still pending / processing → keep polling silently
            } catch (err) {
                console.error('Polling error:', err);
                // Don't stop polling on network glitch – retry next interval
            }
        }, 4000);   // every 4 seconds – reasonable balance
    }

    function resetButton() {
        payBtn.disabled = false;
        document.getElementById('button-text').textContent = `Pay Ksh {{{ number_format($post->price) }}} with M-Pesa`;
    }

    // === Pay button handler ===
    if (payBtn) {
        payBtn.addEventListener('click', async () => {
            const phone = phoneInput.value.trim().replace(/\s/g, '');

            if (!phone.match(/^254[0-9]{9}$/)) {
                setMessage('Please enter a valid phone number (254XXXXXXXXX)', 'error');
                return;
            }

            setMessage('Initiating payment...', 'info');
            payBtn.disabled = true;
            document.getElementById('button-text').textContent = 'Initiating...';

            try {
                const res = await fetch('/api/payment/initiate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        phone_number: phone,
                        post_id: postId,
                    })
                });

                const data = await res.json();

                if (data.success && data.checkout_request_id) {
                    startPolling(data.checkout_request_id);
                } else {
                    setMessage(data.message || 'Could not start payment. Try again.', 'error');
                    resetButton();
                }
            } catch (err) {
                setMessage('Network error – please check your connection.', 'error');
                resetButton();
            }
        });
    }

    // === Auto-resume polling if page reloaded after initiation ===
    @if(session('checkout_request_id'))
        startPolling('{{ session('checkout_request_id') }}');
    @endif
});
</script>
@endsection
