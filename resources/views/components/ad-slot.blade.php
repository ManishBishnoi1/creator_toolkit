@props(['type' => 'horizontal'])

@if($type === 'horizontal')
    <div class="max-w-container-max mx-auto px-gutter my-6 reveal">
        <div class="glass p-4 rounded-xl flex flex-col items-center justify-center min-h-[90px] border-white/5 bg-white/[0.01]">
            <span class="font-label-md text-[9px] uppercase tracking-widest text-on-surface-variant/40 mb-1">Sponsored Advertisement</span>
            <div class="text-[11px] text-on-surface-variant/30 italic">[Responsive Banner Ad Slot - 728x90]</div>
        </div>
    </div>
@else
    <div class="glass p-4 rounded-xl flex flex-col items-center justify-center min-h-[250px] border-white/5 bg-white/[0.01]">
        <span class="font-label-md text-[9px] uppercase tracking-widest text-on-surface-variant/40 mb-2">Sponsored Advertisement</span>
        <div class="text-[11px] text-on-surface-variant/30 italic text-center">[Square/Medium Rectangle Ad Slot - 300x250]</div>
    </div>
@endif
