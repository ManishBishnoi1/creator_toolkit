<nav class="fixed top-0 w-full z-50 bg-white/0 backdrop-blur-0 border-b border-white/0 transition-all duration-300 ease-out" id="main-nav">
    <div class="flex justify-between items-center px-gutter py-4 max-w-container-max mx-auto">
        <div class="font-headline-md text-headline-md font-bold text-on-surface flex items-center gap-2">
            <span class="w-6 h-6 rounded-lg bg-gradient-to-tr from-secondary to-tertiary flex items-center justify-center">
                <span class="material-symbols-outlined text-black text-[16px] font-bold">bolt</span>
            </span>
            <a href="/">Creator Toolkit</a>
        </div>
        
        <div class="hidden md:flex gap-stack-lg items-center">
            <a class="font-body-md text-body-md text-primary border-b-2 border-primary pb-1" href="#">Features</a>
            <a class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors" href="#features">Tools</a>
            <a class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors" href="#faq">FAQ</a>
            <a class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors" href="#about">About</a>
        </div>

        @if (Route::has('login'))
            <div class="flex items-center gap-4">
                @auth
                    <a class="gradient-btn px-6 py-2 rounded-full font-label-md transition-all text-center" href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors" href="{{ route('login') }}">Sign In</a>
                    @if (Route::has('register'))
                        <a class="gradient-btn px-6 py-2 rounded-full font-label-md transition-all text-center" href="{{ route('register') }}">Get Started</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</nav>
