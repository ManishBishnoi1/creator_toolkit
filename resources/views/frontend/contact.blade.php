<x-layout>
    <x-slot:title>Contact Us - InstaReel Download | Instagram Reels Downloader</x-slot:title>
    <x-slot:description>Contact the InstaReel Download team — for support, feature suggestions, or any other queries. We are ready to help you!</x-slot:description>

    <div class="max-w-xl mx-auto px-6 py-16 text-left space-y-8">
        <div class="space-y-2">
            <h1 class="font-display text-3xl font-extrabold text-[#1e2b49]">
                Contact Us
            </h1>
            <p class="text-xs text-slate-500">
                Have a question or want to share feedback? Fill out the form below and we will reply as soon as possible.
            </p>
        </div>

        <!-- Success Notification -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-5 text-xs font-semibold leading-relaxed">
                {{ session('success') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-5 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="font-semibold">• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('pages.submit-contact') }}" method="POST" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-5">
            @csrf
            
            <!-- Name -->
            <div class="space-y-1.5">
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Your Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    required 
                    value="{{ old('name') }}" 
                    placeholder="e.g. John Doe"
                    class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg px-3 py-2.5 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none"
                />
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Email Address</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    required 
                    value="{{ old('email') }}" 
                    placeholder="you@example.com"
                    class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg px-3 py-2.5 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none"
                />
            </div>

            <!-- Message -->
            <div class="space-y-1.5">
                <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Your Message</label>
                <textarea 
                    name="message" 
                    id="message" 
                    rows="5" 
                    required 
                    placeholder="Write your question or feedback here..."
                    class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-lg px-3 py-2.5 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none"
                >{{ old('message') }}</textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-[#e60067] hover:bg-[#c80055] text-white font-bold text-xs py-3.5 rounded-lg uppercase tracking-wider transition-colors cursor-pointer text-center">
                Send Message
            </button>
        </form>
    </div>
</x-layout>
