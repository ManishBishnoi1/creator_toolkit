<div class="w-full max-w-3xl mx-auto px-4" x-data="downloaderForm()">
    <!-- Tabs Navigation -->
    <div class="flex flex-wrap justify-center gap-2 mb-8 text-[11px] font-bold text-white/95">
        <a href="#" class="flex items-center gap-1.5 px-4 py-2 rounded-full border border-white/10 hover:border-white/30 hover:text-white transition-colors bg-white/5">
            <span class="material-symbols-outlined text-[13px]">smart_display</span>
            <span>Video</span>
        </a>
        <a href="#" class="flex items-center gap-1.5 px-4 py-2 rounded-full border border-white/10 hover:border-white/30 hover:text-white transition-colors bg-white/5">
            <span class="material-symbols-outlined text-[13px]">image</span>
            <span>Photo</span>
        </a>
        <a href="#" class="flex items-center gap-1.5 px-4 py-2 rounded-full border border-white/30 text-white bg-white/20">
            <span class="material-symbols-outlined text-[13px]">motion_photos_on</span>
            <span>Reels</span>
        </a>
        <a href="#" class="flex items-center gap-1.5 px-4 py-2 rounded-full border border-white/10 hover:border-white/30 hover:text-white transition-colors bg-white/5">
            <span class="material-symbols-outlined text-[13px]">history_toggle_off</span>
            <span>Story</span>
        </a>
        <a href="#" class="flex items-center gap-1.5 px-4 py-2 rounded-full border border-white/10 hover:border-white/30 hover:text-white transition-colors bg-white/5">
            <span class="material-symbols-outlined text-[13px]">star</span>
            <span>Highlights</span>
        </a>
    </div>

    <!-- Form State -->
    <div x-show="!result && !loading">
        <form @submit.prevent="submitDownload" class="bg-white rounded-lg shadow-xl p-1 flex items-center gap-1 border border-slate-100 overflow-hidden">
            <div class="flex-grow flex items-center px-3 gap-2">
                <input 
                    x-model="url"
                    required
                    class="bg-transparent border-none focus:ring-0 w-full text-slate-800 placeholder:text-slate-400 focus:outline-none text-xs md:text-sm py-3" 
                    placeholder="Paste Reel link here..." 
                    type="url"
                />
                <!-- Clear Button Inside Input -->
                <button type="button" x-show="url" @click="resetForm" class="text-slate-400 hover:text-slate-600 focus:outline-none flex items-center justify-center p-1 cursor-pointer">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
            
            <button type="submit" class="bg-[#e60067] hover:bg-[#c80055] text-white font-bold px-6 md:px-8 py-3.5 rounded-md text-xs tracking-wider uppercase transition-colors whitespace-nowrap cursor-pointer">
                Download
            </button>
        </form>
        <button type="button" @click="pasteLink" class="mt-3 text-xs text-white/80 hover:text-white hover:underline flex items-center gap-1 pl-1 cursor-pointer mx-auto justify-center">
            <span class="material-symbols-outlined text-[14px]">content_paste</span> Paste from clipboard
        </button>
        
        <!-- Discover More Links -->
        <div class="max-w-2xl mx-auto mt-6 bg-white rounded-lg shadow-md border border-slate-100 text-left overflow-hidden">
            <div class="px-4 py-2.5 border-b border-slate-100 bg-slate-50">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Discover more</p>
            </div>
            <div class="divide-y divide-slate-100 text-xs font-semibold text-blue-600">
                <a href="#" class="flex justify-between items-center px-4.5 py-3 hover:bg-slate-50 transition-colors">
                    <span>Download Instagram Content</span>
                    <span class="material-symbols-outlined text-slate-400 text-sm">chevron_right</span>
                </a>
                <a href="#" class="flex justify-between items-center px-4.5 py-3 hover:bg-slate-50 transition-colors">
                    <span>Photo & Video Sharing</span>
                    <span class="material-symbols-outlined text-slate-400 text-sm">chevron_right</span>
                </a>
                <a href="#" class="flex justify-between items-center px-4.5 py-3 hover:bg-slate-50 transition-colors">
                    <span>1080p Video</span>
                    <span class="material-symbols-outlined text-slate-400 text-sm">chevron_right</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="bg-white max-w-2xl mx-auto p-8 rounded-xl shadow-lg border border-slate-100 flex flex-col items-center justify-center gap-3" x-cloak>
        <div class="relative w-8 h-8">
            <div class="absolute inset-0 rounded-full border-2 border-slate-100"></div>
            <div class="absolute inset-0 rounded-full border-2 border-t-[#e60067] animate-spin"></div>
        </div>
        <p class="text-xs text-slate-500 font-semibold mt-2">Extracting reel, please wait...</p>
    </div>

    <!-- Error State -->
    <div x-show="error" class="bg-red-50 max-w-2xl mx-auto p-6 rounded-xl border border-red-100 flex flex-col gap-3 text-left" x-cloak>
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-500">warning</span>
            <div>
                <p class="text-xs font-bold text-red-800">Download Failed</p>
                <p class="text-[11px] text-red-600 mt-1" x-text="errorMessage">Failed to fetch the reel</p>
                <button type="button" @click="resetForm" class="text-xs text-[#e60067] hover:underline mt-2 font-bold block cursor-pointer">Try another link</button>
            </div>
        </div>
    </div>

    <!-- Result State -->
    <div x-show="result" class="bg-white max-w-2xl mx-auto p-5 rounded-xl shadow-lg border border-slate-100 flex flex-col sm:flex-row gap-4 text-left" x-cloak>
        <img :src="result?.thumbnail_url" class="w-full sm:w-24 aspect-[9/16] object-cover rounded-lg bg-black border border-slate-200" alt="Reel Thumbnail">
        <div class="flex-grow flex flex-col justify-between py-1">
            <div class="space-y-1">
                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-widest" x-text="'@' + result?.owner?.username">@creator</span>
                <h4 class="text-sm font-bold text-slate-800 leading-snug line-clamp-2" x-text="result?.title">Reel title</h4>
                <p class="text-[10px] text-slate-400" x-text="result?.duration + 's duration'"></p>
            </div>
            <div class="flex gap-2 pt-4 sm:pt-0">
                <a :href="result?.video_url" class="bg-[#e60067] hover:bg-[#c80055] text-white px-5 py-2.5 rounded-lg font-bold text-xs text-center transition-colors cursor-pointer flex-grow sm:flex-grow-0">
                    Save MP4
                </a>
                <button type="button" @click="resetForm" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg font-bold text-xs text-center transition-colors flex-grow sm:flex-grow-0 cursor-pointer">
                    Clear
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function downloaderForm() {
        return {
            url: '',
            loading: false,
            error: false,
            errorMessage: '',
            result: null,

            pasteLink() {
                navigator.clipboard.readText().then(text => {
                    this.url = text;
                }).catch(err => {
                    console.error('Failed to read clipboard contents: ', err);
                });
            },

            submitDownload() {
                this.loading = true;
                this.error = false;
                this.result = null;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('/tools/instagram-reel', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ url: this.url })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(res => {
                    this.loading = false;
                    if (res.success) {
                        this.result = res.data;
                    } else {
                        this.error = true;
                        this.errorMessage = res.message || 'Scraping failed.';
                    }
                })
                .catch(err => {
                    this.loading = false;
                    this.error = true;
                    this.errorMessage = err.message || 'A network error occurred. Please check the Instagram link.';
                });
            },

            resetForm() {
                this.url = '';
                this.result = null;
                this.error = false;
                this.errorMessage = '';
            }
        };
    }
</script>
