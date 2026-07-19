<x-layout>
    <!-- Hero/Gradient Section with Breadcrumbs -->
    <section class="relative pt-12 pb-20 overflow-hidden bg-gradient-to-r from-[#e100ff] to-[#00b8ff] text-center px-6">
        <!-- Breadcrumbs Navigation -->
        <nav class="max-w-7xl mx-auto flex justify-center items-center gap-1.5 text-[10px] md:text-xs text-white/80 font-bold uppercase tracking-wider mb-6">
            <a href="/" class="hover:text-white transition-colors">Home</a>
            <span class="material-symbols-outlined text-[10px] text-white/50">chevron_right</span>
            <span class="text-white">{{ $h1 }}</span>
        </nav>

        <div class="max-w-4xl mx-auto space-y-4">
            <h1 class="font-display text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                {{ $h1 }}
            </h1>
            
            <!-- Downloader Widget -->
            <x-downloader />
        </div>
    </section>

    <!-- Main Content Container -->
    <div class="max-w-5xl mx-auto px-6 py-16 space-y-16">
        
        <!-- Section 1: Introduction -->
        <section class="grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-4 text-left">
                <h2 class="font-display text-2xl md:text-3xl font-extrabold text-[#1e2b49]">
                    Free {{ $h1 }} Online
                </h2>
                <p class="text-sm text-slate-600 leading-relaxed font-normal">
                    {{ $contentBlocks['intro'] ?? 'Download and save Instagram media in high quality using our optimized downloader tool. Free, secure, and compatible with all modern mobile and desktop devices.' }}
                </p>
            </div>
            
            <!-- 3D Instagram Icon Illustration -->
            <div class="flex justify-center">
                <div class="relative w-40 h-40 flex items-center justify-center">
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] rounded-[36px] shadow-2xl transform rotate-3 scale-95 opacity-80 blur-md"></div>
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] rounded-[36px] flex items-center justify-center border-4 border-white shadow-lg">
                        <div class="w-24 h-24 border-[6px] border-white rounded-[24px] flex items-center justify-center relative">
                            <div class="w-10 h-10 border-[6px] border-white rounded-full"></div>
                            <div class="w-3 h-3 bg-white rounded-full absolute top-2 right-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 2: Features Card Block -->
        @if(!empty($contentBlocks['features']))
        <section class="bg-slate-50 border border-slate-100 rounded-3xl p-8 md:p-10 text-left space-y-6">
            <h3 class="font-display text-xl md:text-2xl font-extrabold text-[#1e2b49]">
                {{ $contentBlocks['features_title'] ?? 'Top Features' }}
            </h3>
            <ul class="space-y-3">
                @foreach($contentBlocks['features'] as $feature)
                <li class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-green-500 mt-0.5 text-lg leading-none">check_circle</span>
                    <span class="text-xs md:text-sm text-slate-600 font-medium leading-relaxed">{{ $feature }}</span>
                </li>
                @endforeach
            </ul>
        </section>
        @endif

        <!-- Section 3: How to download Section (Vibrant Steps Card) -->
        <section class="bg-[#5d3be8] text-white rounded-3xl p-8 md:p-12 shadow-xl text-center space-y-10">
            <h2 class="font-display text-2xl md:text-3xl font-extrabold">
                {{ $contentBlocks['steps_title'] ?? 'How to download from Instagram' }}
            </h2>
            
            <div class="grid md:grid-cols-3 gap-8 text-left">
                @foreach(($contentBlocks['steps'] ?? [
                    ['title' => 'Copy the URL', 'text' => 'Open Instagram, choose the public media you want to save, and copy its share link.'],
                    ['title' => 'Paste the link', 'text' => 'Paste the complete Instagram URL into the downloader field above and select Download.'],
                    ['title' => 'Save the file', 'text' => 'Wait for processing to finish, then use the download button to save the available media.']
                ]) as $index => $step)
                    <div class="space-y-2">
                        <h3 class="font-display text-lg font-bold">{{ $index + 1 }}. {{ $step['title'] }}</h3>
                        <p class="text-xs text-indigo-100 leading-relaxed font-light">{{ $step['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        @if(!empty($contentBlocks['details']))
        <section class="grid md:grid-cols-2 gap-8" aria-label="Downloader information">
            @foreach($contentBlocks['details'] as $detail)
                <article class="space-y-3 text-left">
                    <h2 class="font-display text-xl font-extrabold text-[#1e2b49]">{{ $detail['title'] }}</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $detail['body'] }}</p>
                </article>
            @endforeach
        </section>
        @endif

        <!-- Section 4: FAQ Accordions -->
        @if(!empty($faqs))
        <section class="space-y-8">
            <h2 class="font-display text-2xl md:text-3xl font-extrabold text-[#1e2b49] text-center">
                Frequently Asked Questions
            </h2>
            
            <div class="max-w-3xl mx-auto space-y-3">
                @foreach($faqs as $index => $faq)
                <details class="group border border-slate-200 rounded-xl overflow-hidden hover:border-[#00b8ff] transition-all bg-white shadow-sm" {{ $index === 0 ? 'open' : '' }}>
                    <summary class="flex justify-between items-center px-5 py-4 font-bold text-xs md:text-sm text-[#1e2b49] cursor-pointer hover:bg-slate-50 list-none select-none">
                        <span>{{ $faq['question'] }}</span>
                        <span class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform text-lg leading-none">expand_more</span>
                    </summary>
                    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50 text-[11px] md:text-xs text-slate-500 leading-relaxed font-normal">
                        {{ $faq['answer'] }}
                    </div>
                </details>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</x-layout>
