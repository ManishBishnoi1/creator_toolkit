<x-layout>
    <!-- Hero Section -->
    <section class="relative pt-40 pb-12 overflow-hidden px-gutter">
        <div class="max-w-container-max mx-auto grid lg:grid-cols-2 gap-stack-lg items-center">
            <div class="space-y-stack-md reveal">
                <span class="inline-flex items-center gap-2 px-3 py-1 glass rounded-full text-secondary font-label-md">
                    <span class="material-symbols-outlined text-[16px]">bolt</span>
                    AI-Powered Downloader
                </span>
                <h1 class="font-display-lg text-display-lg leading-tight tracking-tighter text-white">
                    Download Instagram Reels <span class="text-secondary bg-clip-text text-transparent bg-gradient-to-r from-secondary to-tertiary">Instantly</span>
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">
                    Fast, free, and high-quality Instagram reel downloader with AI-powered creator tools to boost your social presence.
                </p>
                
                <div class="flex flex-wrap gap-stack-md pt-2">
                    <div class="flex items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-secondary text-sm">check_circle</span>
                        <span class="font-body-sm">No watermark</span>
                    </div>
                    <div class="flex items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-secondary text-sm">check_circle</span>
                        <span class="font-body-sm">Fast downloads</span>
                    </div>
                    <div class="flex items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-secondary text-sm">check_circle</span>
                        <span class="font-body-sm">Mobile friendly</span>
                    </div>
                    <div class="flex items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-secondary text-sm">check_circle</span>
                        <span class="font-body-sm">Unlimited usage</span>
                    </div>
                </div>

                <!-- Downloader Widget -->
                <x-downloader />
            </div>

            <!-- Float Mockup Image Preview -->
            <div class="relative group reveal">
                <div class="absolute inset-0 bg-secondary/10 blur-3xl rounded-full opacity-50 group-hover:opacity-80 transition-opacity"></div>
                <div class="glass float-animation p-4 rounded-3xl relative overflow-hidden border-white/10">
                    <img alt="UI Preview" class="rounded-2xl w-full h-[400px] object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBCpmywZwhlCeAtF3TIFPJbqfxROTX5Thaf1CrJG4pZYkIcPM4qUhG9lP_yLlGQJpCfNKrKriUKoLQ_VDYEIyNZ1hPc1rnHe3RCz7G3xFd15PTj0vIDlCEChPkh8SuchRV17wzBtTbt7bGTPQhmCb4oMIYz-ET8Mv6xgL8IgTbcmgS1od-Rb9iRWD8CLaxWgmpU2na3LM88CXsBX8aB8ol50IGHd7T6AXmSCN-infgKepPRNzJ5lFdlpVKhuo5u4Q8UM5VBzlGZj-fR"/>
                    <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-black/80 to-transparent">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center">
                                    <span class="material-symbols-outlined text-secondary">motion_photos_on</span>
                                </div>
                                <div>
                                    <p class="font-label-md text-white">Reel_0921.mp4</p>
                                    <p class="text-[10px] text-on-surface-variant">4K Resolution • 12.4 MB</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="px-3 py-1 rounded-full glass text-[10px] text-white">Processing...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AdSense Space 1 -->
    <x-ad-slot type="horizontal" />

    <!-- Trusted By / Stats Section -->
    <section class="py-12 border-y border-white/5 bg-surface-container-lowest/30 reveal">
        <div class="max-w-container-max mx-auto px-gutter grid grid-cols-2 md:grid-cols-3 gap-8">
            <div class="text-center space-y-1">
                <div class="flex justify-center items-center gap-2 text-primary">
                    <span class="material-symbols-outlined">download_done</span>
                    <span class="font-headline-md text-white">1M+</span>
                </div>
                <p class="font-body-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Downloads Served</p>
            </div>
            <div class="text-center space-y-1 border-x border-white/10 px-8">
                <div class="flex justify-center items-center gap-2 text-primary">
                    <span class="material-symbols-outlined">group</span>
                    <span class="font-headline-md text-white">100K+</span>
                </div>
                <p class="font-body-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Active Creators</p>
            </div>
            <div class="text-center space-y-1 hidden md:block">
                <div class="flex justify-center items-center gap-2 text-primary">
                    <span class="material-symbols-outlined">public</span>
                    <span class="font-headline-md text-white">Fast</span>
                </div>
                <p class="font-body-sm text-on-surface-variant uppercase tracking-widest text-[10px]">Global Access</p>
            </div>
        </div>
    </section>

    <!-- Features Section Component -->
    <x-features />

    <!-- AdSense Space 2 -->
    <x-ad-slot type="horizontal" />

    <!-- How It Works Section -->
    <section class="py-stack-lg px-gutter relative overflow-hidden reveal">
        <div class="max-w-container-max mx-auto">
            <h2 class="font-headline-lg text-headline-lg text-center mb-20 text-white">Download in 3 Simple Steps</h2>
            <div class="relative">
                <div class="absolute top-1/2 left-0 w-full h-[1px] bg-white/10 hidden md:block"></div>
                <div class="grid md:grid-cols-3 gap-stack-lg relative">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-16 h-16 rounded-full bg-surface-container border border-white/20 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:border-secondary transition-all relative z-10 bg-background">
                            <span class="material-symbols-outlined text-secondary">link</span>
                        </div>
                        <h4 class="font-headline-md text-white mb-2">Paste URL</h4>
                        <p class="text-on-surface-variant font-body-sm">Copy the link of any Instagram Reel and paste it into the search box.</p>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-16 h-16 rounded-full bg-surface-container border border-white/20 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:border-secondary transition-all relative z-10 bg-background">
                            <span class="material-symbols-outlined text-secondary">settings_suggest</span>
                        </div>
                        <h4 class="font-headline-md text-white mb-2">Process</h4>
                        <p class="text-on-surface-variant font-body-sm">Our AI system analyzes the content and prepares the highest quality file.</p>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="w-16 h-16 rounded-full bg-surface-container border border-white/20 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:border-secondary transition-all relative z-10 bg-background">
                            <span class="material-symbols-outlined text-secondary">download_for_offline</span>
                        </div>
                        <h4 class="font-headline-md text-white mb-2">Download</h4>
                        <p class="text-on-surface-variant font-body-sm">Save the video directly to your device. No watermark, high bit-rate.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SEO Content Block & Sidebar Ad Layout -->
    <section id="about" class="py-stack-lg px-gutter bg-surface-container-lowest/50 reveal">
        <div class="max-w-container-max mx-auto grid lg:grid-cols-3 gap-stack-lg">
            <!-- Main SEO Body -->
            <div class="lg:col-span-2 space-y-stack-lg">
                <h2 class="font-headline-lg text-headline-lg text-white">Why Choose Creator Toolkit for Instagram Reels?</h2>
                <div class="prose prose-invert max-w-none space-y-stack-md text-on-surface-variant">
                    <p class="font-body-md leading-relaxed">
                        In the competitive world of short-form video, speed is everything. Creator Toolkit provides the fastest <strong>Instagram Reel Downloader</strong> on the web, designed specifically for professional social media managers and independent creators. Our platform bypasses common limitations of other services, offering unlimited high-quality downloads without restrictive data caps.
                    </p>
                    
                    <div class="grid md:grid-cols-2 gap-stack-md pt-4">
                        <div class="space-y-2">
                            <h4 class="text-white font-bold font-display text-sm">Uncompromising Quality</h4>
                            <p class="text-body-sm">We don't compress your content. Download Reels in their original 1080p or 4K resolution, preserving every pixel for your reposts or edits.</p>
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-white font-bold font-display text-sm">Privacy Focused</h4>
                            <p class="text-body-sm">No login required. We respect your digital footprint and ensure that all downloads are processed anonymously and securely.</p>
                        </div>
                    </div>

                    <p class="font-body-md leading-relaxed pt-4">
                        By integrating <strong>AI-powered creator tools</strong> directly into the downloading workflow, we help you transition from consumer to creator in minutes. From generating viral captions to discovering the best trending hashtags, our ecosystem is built to maximize your reach.
                    </p>
                </div>
            </div>

            <!-- Sidebar Advertisement Slot -->
            <div class="flex flex-col gap-6">
                <div class="glass p-6 rounded-2xl border-white/5 space-y-4">
                    <h4 class="font-headline-md text-sm text-white font-semibold">Downloader Specs</h4>
                    <ul class="space-y-3 text-xs text-on-surface-variant">
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-base">check_circle</span>
                            <span>Zero sign-in or tokens required</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-base">check_circle</span>
                            <span>Original HD format retrieval</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-base">check_circle</span>
                            <span>Multi-device compatibility (iOS, Android, PC)</span>
                        </li>
                    </ul>
                </div>
                
                <!-- AdSense Space 3 (Sidebar) -->
                <x-ad-slot type="sidebar" />
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-stack-lg px-gutter reveal">
        <div class="max-w-container-max mx-auto">
            <h2 class="font-headline-lg text-headline-lg text-center mb-16 text-white">Loved by Top Creators</h2>
            <div class="grid md:grid-cols-3 gap-stack-md">
                <!-- Testimonial 1 -->
                <div class="glass p-8 rounded-3xl space-y-6">
                    <div class="flex items-center gap-1 text-secondary">
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    </div>
                    <p class="text-white font-body-md italic text-lg leading-relaxed">"The fastest downloader I've ever used. The AI caption generator saves me hours of brainstorming every week!"</p>
                    <div class="flex items-center gap-4">
                        <img alt="Avatar" class="w-12 h-12 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBmwhgHeCRcCXJE_osJSCbUD4wEEBHYxnbc0RcpjFi-Lpeuk91YwiRcbhmgIqQIj3gQh9aZnrjnUYePRPA2neQvsBHtW1Cs70FidDbTyB8v27FxIHk6o40CR4MYY2GwPvOzKw2zWfKrawYxw8Pr4B_yf4F5VsLp8V8FbnWlorOUIiJLbuZ5TCU3G4CVJR1z5UaD0OqoH7cvfFYmn2tFJZhjxusHAw31THx56KZRzrDs5c3F-di8Gjc6bs0ztZhPteN6MKPhy-0wklY_"/>
                        <div>
                            <p class="font-bold text-white text-sm">Sarah Jenkins</p>
                            <p class="text-on-surface-variant text-xs">@sarahcreate_</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="glass p-8 rounded-3xl space-y-6 border-secondary/35 bg-secondary/5">
                    <div class="flex items-center gap-1 text-secondary">
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    </div>
                    <p class="text-white font-body-md italic text-lg leading-relaxed">"Absolutely essential for my workflow. No watermarks and high quality every single time. 10/10 recommendation."</p>
                    <div class="flex items-center gap-4">
                        <img alt="Avatar" class="w-12 h-12 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC-0k-BSq2QlyoFdF3R6pGez1doxsh4l1D5kjOyNaE_hMEPFrh_3qC9ufKzxKk5zh6WUmtiYFPDBsE6mMbU5Lr95ADXogmFX5ppkIN67BYa7M8AYC4Tc3n7XM9WlFns4NZpFBPX_1T6xWAOw9QdtZELRcZFTIMLSwWxX-RaoL8FWN0N8nE_HriCPimD1ryVXvsqKxpPratVBRCdFp9_hlc5-9KGHhPTvAF6xl91ShZqbcJOX6CXO50xdnKuUtQXXAphGIG2RX45DMJ3"/>
                        <div>
                            <p class="font-bold text-white text-sm">Marcus Tech</p>
                            <p class="text-on-surface-variant text-xs">@marcusedits</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="glass p-8 rounded-3xl space-y-6">
                    <div class="flex items-center gap-1 text-secondary">
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                    </div>
                    <p class="text-white font-body-md italic text-lg leading-relaxed">"Finally a tool that works on mobile as good as it does on desktop. The hashtag tool is a game changer."</p>
                    <div class="flex items-center gap-4">
                        <img alt="Avatar" class="w-12 h-12 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6atz5X2vTGiAniTJwplhQJDVxIC8KdCjx4cnQaeZ7txtWNDvPm5MUkcad_0kKRbdkhGNeMhVEf6r_5H2KJ74lqYU5g6xhq-40VncLZ7Ddf6SP5hvj-cgkH5duKNB8C524CtELhdY8Hcb67MZ6F-vYwmvbXGOtLlSya63gFg_9ZejA5AW7VlBfNOlu7EZBkxz1hAJ0yHXLBDgBuiO2EIPdoLbWFGXBXnrKJx3FWaPCwUBOwpOW5aKp0ETAf1xuW2l0YsOG8ZVLWj2f"/>
                        <div>
                            <p class="font-bold text-white text-sm">Elena Rose</p>
                            <p class="text-on-surface-variant text-xs">@elenasvlog</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section Component -->
    <x-faq />

    <!-- CTA Section -->
    <section class="py-24 px-gutter relative overflow-hidden reveal">
        <div class="max-w-container-max mx-auto text-center relative z-10">
            <div class="glass p-12 md:p-20 rounded-[40px] border-secondary/20 space-y-stack-lg">
                <h2 class="font-display-lg text-display-lg leading-tight text-white">Start Downloading <br/><span class="text-secondary bg-clip-text text-transparent bg-gradient-to-r from-secondary to-tertiary">Reels Today</span></h2>
                <p class="text-on-surface-variant text-xl max-w-2xl mx-auto">Join over 100,000 creators using the most powerful toolkit on the planet.</p>
                <div class="flex flex-col md:flex-row gap-4 justify-center pt-4">
                    <button class="gradient-btn btn-pulse px-10 py-4 rounded-xl font-headline-md text-lg cursor-pointer">Try Creator Toolkit</button>
                    <button class="glass px-10 py-4 rounded-xl font-headline-md text-lg hover:bg-white/10 transition-colors cursor-pointer">View Features</button>
                </div>
            </div>
        </div>
    </section>
</x-layout>
