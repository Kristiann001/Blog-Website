<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="brand-font text-3xl text-gray-900 leading-tight">
                {{ __('Story Management') }}
            </h2>
            <a href="{{ route('admin.posts.create') }}" class="bg-gray-900 text-white text-[10px] font-bold uppercase tracking-[0.3em] px-8 py-3 rounded-full hover:bg-cyan-500 transition shadow-lg">
                <i class="fas fa-plus mr-2"></i> New Story
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-8">
                    @if(session('success'))
                        <div class="bg-cyan-50 border border-cyan-100 text-cyan-700 px-6 py-4 rounded-2xl mb-8 flex items-center shadow-sm">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b border-gray-100">
                                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Title</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Status</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Pricing</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($posts as $post)
                                <tr class="group hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-6">
                                        <p class="text-sm font-bold text-gray-900 group-hover:text-cyan-600 transition">{{ $post->title }}</p>
                                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">{{ $post->category->name ?? 'General' }}</p>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest @if($post->status === 'published') bg-green-50 text-green-600 @else bg-yellow-50 text-yellow-600 @endif">
                                            <span class="w-1.5 h-1.5 rounded-full mr-2 @if($post->status === 'published') bg-green-500 @else bg-yellow-500 @endif"></span>
                                            {{ $post->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6">
                                        <p class="text-xs font-bold text-gray-700">{{ $post->price > 0 ? 'Ksh ' . number_format($post->price) : 'Complimentary' }}</p>
                                    </td>
                                    <td class="px-6 py-6 text-right space-x-4">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-cyan-500 transition">Edit</a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Archive this story?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[10px] font-bold uppercase tracking-widest text-red-300 hover:text-red-500 transition">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
