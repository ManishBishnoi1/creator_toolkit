<x-layout>
    <!-- Breadcrumbs Header -->
    <div class="bg-slate-50 border-b border-slate-100 py-4 px-6 text-left">
        <nav class="max-w-7xl mx-auto flex flex-wrap items-center gap-1.5 text-[10px] md:text-xs text-slate-500 font-bold uppercase tracking-wider">
            <a href="/" class="hover:text-slate-800 transition-colors">Home</a>
            <span class="material-symbols-outlined text-[10px] text-slate-400">chevron_right</span>
            <a href="{{ route('blog.index') }}" class="hover:text-slate-800 transition-colors">Blog</a>
            <span class="material-symbols-outlined text-[10px] text-slate-400">chevron_right</span>
            <span class="text-slate-800 truncate max-w-[150px] md:max-w-xs">{{ $post->title }}</span>
        </nav>
    </div>

    <!-- Article Content Grid -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left Side: Main Article -->
            <main class="lg:col-span-8 space-y-8 text-left">
                <!-- Title & Meta Header -->
                <div class="space-y-4">
                    <span class="inline-block bg-[#5d3be8]/10 text-[#5d3be8] text-[9px] font-extrabold uppercase tracking-widest px-3 py-1.5 rounded-full">
                        # {{ $post->category_id ?: 'Guides' }}
                    </span>
                    <h1 class="font-display text-2xl md:text-4xl font-extrabold text-[#1e2b49] leading-tight">
                        {{ $post->title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-y-2 gap-x-6 text-slate-400 text-xs font-semibold border-b border-slate-100 pb-6">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                            {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            {{ ceil(str_word_count(strip_tags($post->content)) / 180) }} min read
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">person</span>
                            By InstaReel Download Creator Team
                        </span>
                    </div>
                </div>

                <!-- Rich Text Post Body -->
                <article class="prose prose-slate max-w-none text-slate-700 text-sm md:text-base leading-relaxed space-y-6">
                    {!! $post->content !!}
                </article>

                <!-- Helpful / Feedback Box (Trust Signal) -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 text-center space-y-3 mt-8">
                    <h3 class="font-display text-sm font-bold text-slate-800">Was this article helpful?</h3>
                    <p class="text-[11px] text-slate-500 max-w-md mx-auto">
                        We constantly analyze feedback to improve our article quality. Share your response below to help us improve.
                    </p>
                    <div class="flex justify-center gap-3 pt-2">
                        <button type="button" class="border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 font-bold text-xs px-4 py-2 rounded-lg cursor-pointer transition-colors shadow-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm text-green-500">thumb_up</span> Yes, helpful
                        </button>
                        <button type="button" class="border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 font-bold text-xs px-4 py-2 rounded-lg cursor-pointer transition-colors shadow-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm text-red-500">thumb_down</span> Needs work
                        </button>
                    </div>
                </div>
            </main>

            <!-- Right Side: Sidebar -->
            <aside class="lg:col-span-4 space-y-8 text-left">
                <!-- Downloader CTA Widget (Crucial) -->
                <div class="bg-gradient-to-tr from-[#e100ff]/10 to-[#00b8ff]/10 border border-[#00b8ff]/20 rounded-2xl p-6 space-y-4">
                    <h3 class="font-display text-base font-extrabold text-[#1e2b49]">
                        Instagram Reels Saver
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-normal">
                        Want to save videos directly without watermarks? Start clean HD MP4 downloads with a single copy-paste.
                    </p>
                    <a href="/" class="block bg-gradient-to-r from-[#e100ff] to-[#00b8ff] hover:opacity-95 text-white text-center font-bold text-xs py-3.5 rounded-xl transition-all shadow shadow-indigo-200">
                        Try Downloader Tool
                    </a>
                </div>

                <!-- Recent Posts list -->
                @if(!$recentPosts->isEmpty())
                <div class="bg-white border border-slate-100 rounded-2xl p-6 space-y-4">
                    <h3 class="font-display text-sm font-extrabold text-[#1e2b49] uppercase tracking-wider border-b border-slate-100 pb-2">
                        Recent Articles
                    </h3>
                    <div class="divide-y divide-slate-100">
                        @foreach($recentPosts as $recent)
                        <div class="py-3.5 first:pt-0 last:pb-0 group">
                            <a href="{{ route('blog.show', $recent->slug) }}" class="block space-y-1">
                                <h4 class="font-display text-xs font-bold text-slate-700 group-hover:text-[#5d3be8] transition-colors leading-snug">
                                    {{ $recent->title }}
                                </h4>
                                <span class="text-[9px] text-slate-400 font-medium">
                                    {{ $recent->published_at ? $recent->published_at->format('M d, Y') : $recent->created_at->format('M d, Y') }}
                                </span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Platform Benefits (Trust & Authority) -->
                <div class="bg-white border border-slate-100 rounded-2xl p-6 space-y-4">
                    <h3 class="font-display text-sm font-extrabold text-[#1e2b49] uppercase tracking-wider border-b border-slate-100 pb-2">
                        Downloader Benefits
                    </h3>
                    <ul class="space-y-3.5 text-xs text-slate-600">
                        <li class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-green-500 text-base leading-none">verified_user</span>
                            <span class="font-medium">100% Safe: No login or authorization hooks.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-[#00b8ff] text-base leading-none">speed</span>
                            <span class="font-medium">High Speed: Instant CDN scraping.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-purple-500 text-base leading-none">hd</span>
                            <span class="font-medium">Full HD Quality: 1080p MP4 resolution.</span>
                        </li>
                    </ul>
                </div>
            </aside>

        </div>
    </div>
</x-layout>
