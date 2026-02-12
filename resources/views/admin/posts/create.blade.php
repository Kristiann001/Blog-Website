<x-app-layout>
    <x-slot name="header">
        <h2 class="brand-font text-3xl text-gray-900 leading-tight">
            {{ __('Compose New Story') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
                <div class="p-10">
                    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <div class="space-y-2">
                            <label for="title" class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 ml-1">Story Title</label>
                            <input type="text" name="title" id="title" class="w-full bg-white border border-gray-100 rounded-2xl px-6 py-4 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/5 transition shadow-sm" placeholder="Enter a captivating title..." required>
                        </div>

                        <div class="space-y-2">
                            <label for="content" class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 ml-1">Narrative Content</label>
                            <textarea name="content" id="content" rows="12" class="w-full bg-white border border-gray-100 rounded-2xl px-6 py-4 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/5 transition shadow-sm" placeholder="Write your story here..." required></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label for="category_id" class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 ml-1">Category</label>
                                <select name="category_id" id="category_id" class="w-full bg-white border border-gray-100 rounded-2xl px-6 py-4 text-sm focus:border-cyan-500 transition shadow-sm">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="featured_image" class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 ml-1">Cover Imagery</label>
                                <div class="relative">
                                    <input type="file" name="featured_image" id="featured_image" class="w-full bg-white border border-gray-100 rounded-2xl px-6 py-3.5 text-xs focus:border-cyan-500 transition shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label for="status" class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 ml-1">Editorial Status</label>
                                <select name="status" id="status" class="w-full bg-white border border-gray-100 rounded-2xl px-6 py-4 text-sm focus:border-cyan-500 transition shadow-sm">
                                    <option value="draft">Draft (Internal Only)</option>
                                    <option value="published">Published (Public)</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label for="published_at" class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 ml-1">Publication Date</label>
                                <input type="date" name="published_at" id="published_at" class="w-full bg-white border border-gray-100 rounded-2xl px-6 py-4 text-sm focus:border-cyan-500 transition shadow-sm">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="price" class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 ml-1">Access Premium (Ksh)</label>
                            <div class="relative">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs uppercase">Ksh</span>
                                <input type="number" step="0.01" name="price" id="price" value="0.00" class="w-full bg-white border border-gray-100 rounded-2xl pl-16 pr-6 py-4 text-sm font-bold text-cyan-600 focus:border-cyan-500 transition shadow-sm" required>
                                <p class="text-[9px] text-gray-400 mt-2 ml-1">* Set to 0.00 to keep the story complimentary.</p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-50 flex items-center justify-between">
                            <a href="{{ route('admin.posts.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-gray-600 transition">Cancel</a>
                            <button type="submit" class="bg-gray-900 text-white text-[10px] font-bold uppercase tracking-[0.3em] px-10 py-4 rounded-full hover:bg-cyan-500 transition shadow-xl min-w-[200px]">
                                Finalize & Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
