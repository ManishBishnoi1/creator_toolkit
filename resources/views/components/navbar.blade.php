<nav class="w-full z-50 bg-white border-b border-slate-100 py-3 px-4 sm:px-6" x-data="{ mobileOpen: false, languageOpen: false }">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between gap-3">
            <!-- Nav Links -->
            <div class="hidden md:flex items-center gap-6">
                <a href="/blog" class="text-xs font-bold text-slate-600 hover:text-slate-900 transition-colors uppercase tracking-wide">Blog</a>
            </div>

            <!-- Centered Logo -->
            <a href="/" class="flex min-w-0 items-center gap-2 font-display text-lg sm:text-xl md:text-2xl font-black tracking-tight">
                <img src="{{ asset('images/logo.png') }}" alt="InstaReel Download Logo" class="h-7 w-7 sm:h-8 sm:w-8 flex-shrink-0" width="32" height="32">
                <span class="truncate text-slate-800">InstaReel Download</span>
            </a>

            <div class="flex items-center gap-2">
                <!-- Right-aligned Language Selection -->
                <div class="relative hidden md:block" x-data="{ open: false }">
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

                <button type="button" class="inline-flex items-center justify-center rounded-md border border-slate-200 bg-slate-50 p-2 text-slate-700 md:hidden" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen.toString()" aria-label="Toggle navigation menu">
                    <span class="material-symbols-outlined text-[20px] leading-none" x-text="mobileOpen ? 'close' : 'menu'"></span>
                </button>
            </div>
        </div>

        <div x-show="mobileOpen" x-cloak class="md:hidden pt-4">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 shadow-sm">
                <a href="/blog" class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold uppercase tracking-wide text-slate-700 hover:bg-white hover:text-slate-900 transition-colors" @click="mobileOpen = false">
                    <span>Blog</span>
                    <span class="material-symbols-outlined text-[18px] leading-none text-slate-400">arrow_forward</span>
                </a>

                <div class="mt-2 border-t border-slate-200 pt-3">
                    <p class="px-4 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">Language</p>
                    <div class="mt-2 grid grid-cols-3 gap-2 px-4">
                        <a href="#" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-center text-xs font-bold text-slate-700 hover:border-slate-300 hover:bg-slate-50">EN</a>
                        <a href="#" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-center text-xs font-bold text-slate-700 hover:border-slate-300 hover:bg-slate-50">ES</a>
                        <a href="#" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-center text-xs font-bold text-slate-700 hover:border-slate-300 hover:bg-slate-50">FR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
