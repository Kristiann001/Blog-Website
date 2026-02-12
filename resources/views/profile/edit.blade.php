<x-app-layout>
    <x-slot name="header">
        <h2 class="brand-font text-3xl text-gray-900 leading-tight">
            {{ __('Account Center') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Account Overview Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Sidebar/Nav -->
                <div class="md:col-span-1 space-y-4">
                    <div class="glass p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-cyan-100 rounded-full flex items-center justify-center mb-4">
                                <span class="text-3xl font-bold text-cyan-600 tracking-tighter">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <h3 class="brand-font text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mt-1">{{ auth()->user()->role }} Account</p>
                        </div>
                        <div class="mt-8 space-y-2">
                            <a href="#personal-info" class="block px-4 py-2 text-xs font-bold uppercase tracking-widest text-cyan-500 bg-cyan-50 rounded-lg">Personal Info</a>
                            <a href="#security" class="block px-4 py-2 text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-cyan-500 transition">Security</a>
                            <a href="#danger-zone" class="block px-4 py-2 text-xs font-bold uppercase tracking-widest text-red-400 hover:text-red-600 transition">Danger Zone</a>
                        </div>
                    </div>

                    <!-- Usage Stats -->
                    <div class="glass p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-4">Activity Insights</h4>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[9px] text-gray-400 uppercase tracking-widest">Joined On</p>
                                <p class="text-xs font-bold text-gray-900">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                            </div>
                            @if(auth()->user()->role === 'user')
                                <div>
                                    <p class="text-[9px] text-gray-400 uppercase tracking-widest">Total Purchases</p>
                                    <p class="text-xs font-bold text-gray-900">{{ auth()->user()->payments()->where('status', 'completed')->count() }} Stories</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Main Content Panels -->
                <div class="md:col-span-3 space-y-8">
                    <div id="personal-info" class="p-8 bg-white shadow-sm border border-gray-100 rounded-2xl">
                        <h4 class="brand-font text-xl font-bold mb-6 text-gray-900">Personal Information</h4>
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div id="security" class="p-8 bg-white shadow-sm border border-gray-100 rounded-2xl">
                        <h4 class="brand-font text-xl font-bold mb-6 text-gray-900">Update Security</h4>
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div id="danger-zone" class="p-8 bg-white shadow-sm border border-red-100 rounded-2xl">
                        <h4 class="brand-font text-xl font-bold mb-6 text-red-600">Danger Zone</h4>
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
