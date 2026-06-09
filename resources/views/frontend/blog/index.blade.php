<x-layout>
    <!-- Blog Hero Header -->
    <section class="relative pt-12 pb-16 overflow-hidden text-center px-6" style="background: linear-gradient(135deg, #1e2b49 0%, #111827 50%, #0a0f1d 100%);">
        <div class="max-w-4xl mx-auto space-y-4">
            <!-- Breadcrumbs -->
            <nav class="flex justify-center items-center gap-1.5 text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">
                <a href="/" class="hover:text-white transition-colors">Home</a>
                <span class="material-symbols-outlined text-[10px] text-slate-500">chevron_right</span>
                <span class="text-white">Blog</span>
            </nav>

            <h1 class="font-display text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                Creator Insights &amp; Guides
            </h1>
            <p class="text-xs md:text-sm text-slate-300 font-medium max-w-xl mx-auto leading-relaxed">
                Stay updated with the best strategies for downloading Instagram reels, saving highlights anonymously, formatting video streams, and growing your audience.
            </p>

            <!-- Search Form -->
            <div class="max-w-md mx-auto pt-4">
                <form action="{{ route('blog.index') }}" method="GET" class="relative w-full">
                    <span class="material-symbols-outlined absolute left-4 text-slate-400 text-lg top-1/2 -translate-y-1/2">search</span>
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ $searchQuery ?? '' }}" 
                        placeholder="Search articles (e.g. watermark, story)..." 
                        class="w-full bg-white/10 text-white placeholder-slate-400 text-xs md:text-sm pl-11 pr-24 py-3.5 rounded-full border border-white/20 focus:border-[#00b8ff] focus:ring-1 focus:ring-[#00b8ff] outline-none transition-all shadow-inner backdrop-blur"
                    />
                    <button 
                        type="submit" 
                        class="absolute right-1.5 top-1/2 -translate-y-1/2 bg-gradient-to-r from-[#e100ff] to-[#00b8ff] hover:opacity-90 text-white font-bold text-[11px] md:text-xs px-5 py-2.5 rounded-full cursor-pointer transition-all shadow"
                    >
                        Search
                    </button>
                </form>
                @if(!empty($searchQuery))
                    <div class="text-xs text-slate-400 mt-3.5 flex items-center justify-center gap-2">
                        <span>Showing search results for: <strong>"{{ $searchQuery }}"</strong></span>
                        <a href="{{ route('blog.index') }}" class="text-[#00b8ff] hover:underline flex items-center gap-0.5">
                            Clear <span class="material-symbols-outlined text-[10px] leading-none">close</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Blog Grid Content Wrapper -->
    <div class="bg-slate-50/50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 py-16">
            @if($posts->isEmpty())
                <div class="max-w-md mx-auto text-center py-12 space-y-4">
                    <div class="w-16 h-16 bg-white border border-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-400">
                        <span class="material-symbols-outlined text-2xl">search_off</span>
                    </div>
                    <h3 class="font-display text-lg font-bold text-slate-800">No Articles Found</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        We could not find any articles matching your search query. Try searching for other keywords or check our homepage tools!
                    </p>
                    <a href="{{ route('blog.index') }}" class="inline-block bg-[#5d3be8] text-white font-bold text-xs px-6 py-2.5 rounded-lg transition-colors hover:bg-[#4a2cc4] shadow-sm">
                        Browse All Articles
                    </a>
                </div>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <article class="bg-white border border-slate-100 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                            <!-- Card Image Placeholder/Accent -->
                            <div class="h-44 w-full relative overflow-hidden border-b border-slate-100 bg-gradient-to-br from-slate-50 to-slate-100">
                                <!-- Visual Graphic Container -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <!-- Visual Graphic -->
                                    <div class="absolute inset-0 bg-gradient-to-tr from-[#e100ff]/5 to-[#00b8ff]/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <span class="material-symbols-outlined text-slate-300 text-4xl group-hover:scale-110 group-hover:text-indigo-400 transition-all duration-300">
                                        @if($post->category_id === 'guides') menu_book
                                        @elseif($post->category_id === 'tips') lightbulb
                                        @elseif($post->category_id === 'stories') visibility
                                        @elseif($post->category_id === 'creators') auto_awesome
                                        @elseif($post->category_id === 'legal') gavel
                                        @else article
                                        @endif
                                    </span>
                                </div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm border border-slate-100 text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-full shadow-sm text-slate-700 z-10">
                                    # {{ $post->category_id ?: 'General' }}
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 flex-grow flex flex-col justify-between space-y-4 text-left">
                                <div class="space-y-2">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs leading-none">calendar_today</span>
                                        {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                                    </span>
                                    <h2 class="font-display text-base md:text-lg font-bold text-slate-800 group-hover:text-[#5d3be8] transition-colors leading-snug">
                                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h2>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                        {{ Str::limit(strip_tags($post->content), 120) }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-500">
                                    <span class="flex items-center gap-1 text-[10px] text-slate-400">
                                        <span class="material-symbols-outlined text-xs leading-none">schedule</span>
                                        {{ ceil(str_word_count(strip_tags($post->content)) / 180) }} min read
                                    </span>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-[#5d3be8] hover:text-[#4a2cc4] flex items-center gap-0.5 group-hover:translate-x-0.5 transition-transform">
                                        Read Article <span class="material-symbols-outlined text-[13px] leading-none">chevron_right</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Laravel Custom Pagination Links -->
                <div class="mt-12 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layout>
