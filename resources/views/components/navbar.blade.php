<nav class="w-full z-50 bg-white border-b border-slate-100 py-3 px-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Nav Links -->
        <div class="flex items-center gap-6">
            <a href="/blog" class="text-xs font-bold text-slate-600 hover:text-slate-900 transition-colors uppercase tracking-wide">Blog</a>
        </div>
        
        <!-- Centered Logo -->
        <a href="/" class="flex items-center gap-2 font-display text-2xl font-black tracking-tight">
            <img src="{{ asset('images/logo.png') }}" alt="InstaReel Download Logo" class="h-8 w-auto" width="32" height="32">
            <span class="text-slate-800">InstaReel Download</span>
        </a>
        
        <!-- Right-aligned Language Selection -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-1 text-[11px] font-bold text-slate-600 hover:text-slate-900 border border-slate-200 rounded px-2.5 py-1 bg-slate-50 cursor-pointer">
                <span>EN</span>
                <span class="material-symbols-outlined text-[12px] leading-none text-slate-400">expand_more</span>
            </button>
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-1 bg-white border border-slate-200 shadow-lg rounded-lg w-20 text-[11px] py-1 z-50" x-cloak>
                <a href="#" class="block px-3 py-1.5 hover:bg-slate-50 text-slate-700">EN</a>
                <a href="#" class="block px-3 py-1.5 hover:bg-slate-50 text-slate-700">ES</a>
                <a href="#" class="block px-3 py-1.5 hover:bg-slate-50 text-slate-700">FR</a>
            </div>
        </div>
    </div>
</nav>
