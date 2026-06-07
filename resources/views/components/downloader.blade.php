<div class="pt-stack-lg" x-data="downloaderForm()">
    <!-- Form State -->
    <div x-show="!result && !loading">
        <form @submit.prevent="submitDownload" class="glass p-2 rounded-xl flex items-center gap-2 border-white/20">
            <span class="material-symbols-outlined text-slate-500 pl-3">link</span>
            <input 
                x-model="url"
                required
                class="bg-transparent border-none focus:ring-0 w-full px-2 text-on-surface placeholder:text-on-surface-variant/50 focus:outline-none text-sm" 
                placeholder="Paste Instagram Reel URL here..." 
                type="url"
            />
            <button type="submit" class="gradient-btn btn-pulse px-8 py-3 rounded-lg font-label-md flex items-center gap-2 whitespace-nowrap cursor-pointer">
                <span class="material-symbols-outlined">download</span>
                Download
            </button>
        </form>
        <button type="button" @click="pasteLink" class="mt-2 text-xs text-secondary hover:underline flex items-center gap-1 pl-1 cursor-pointer">
            <span class="material-symbols-outlined text-[14px]">content_paste</span> Paste from clipboard
        </button>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="glass p-6 rounded-xl flex flex-col items-center justify-center gap-3 border-white/20" x-cloak>
        <div class="relative w-10 h-10">
            <div class="absolute inset-0 rounded-full border-2 border-purple-900/30"></div>
            <div class="absolute inset-0 rounded-full border-2 border-t-secondary animate-spin"></div>
        </div>
        <p class="text-xs text-on-surface-variant font-body-sm">Connecting via proxy rotator and retrieving file link...</p>
    </div>

    <!-- Error State -->
    <div x-show="error" class="glass p-6 rounded-xl border-red-900/30 bg-red-950/10 flex flex-col gap-3" x-cloak>
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-400">warning</span>
            <div>
                <p class="text-xs font-semibold text-white">Scraping Failed</p>
                <p class="text-[11px] text-on-surface-variant mt-1" x-text="errorMessage">Failed to fetch the reel</p>
                <button type="button" @click="resetForm" class="text-xs text-secondary hover:underline mt-2 font-bold block cursor-pointer">Try another URL</button>
            </div>
        </div>
    </div>

    <!-- Result State -->
    <div x-show="result" class="glass p-6 rounded-xl border-white/20 flex flex-col sm:flex-row gap-4" x-cloak>
        <img :src="result?.thumbnail_url" class="w-full sm:w-28 aspect-[9/16] object-cover rounded-lg bg-black border border-white/10" alt="Reel Thumbnail">
        <div class="flex-grow flex flex-col justify-between py-1">
            <div class="space-y-1">
                <span class="text-[10px] uppercase font-bold text-secondary tracking-widest" x-text="'@' + result?.owner?.username">@creator</span>
                <h4 class="text-sm font-bold text-white leading-snug line-clamp-2" x-text="result?.title">Reel title</h4>
                <p class="text-[10px] text-on-surface-variant" x-text="result?.duration + 's duration'"></p>
            </div>
            <div class="flex gap-2 pt-4 sm:pt-0">
                <a :href="result?.video_url" class="gradient-btn px-4 py-2 rounded-lg font-label-md text-xs text-center cursor-pointer flex-grow sm:flex-grow-0">
                    Save MP4
                </a>
                <button type="button" @click="resetForm" class="glass px-4 py-2 rounded-lg font-label-md text-xs text-center text-white hover:bg-white/10 flex-grow sm:flex-grow-0 cursor-pointer">
                    Clear
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Alpine Downloader Form handler
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
