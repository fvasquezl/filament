<div class="w-full h-full bg-black">
    {{-- Imagen a pantalla completa --}}
    @if($latestPost && !empty($latestPost['image']))
        <img src="{{ $latestPost['image'] }}?v={{ $latestPost['updated_at'] ?? now()->timestamp }}" alt="Post Image"
            class="w-full h-full object-contain" loading="eager"
            wire:key="post-image-{{ $latestPost['id'] }}-{{ $latestPost['updated_at'] ?? now()->timestamp }}">
    @else
        <div class="flex items-center justify-center h-full">
            <p class="text-white text-2xl">No hay imagen disponible</p>
        </div>
    @endif
</div>

@script
<script>
    document.addEventListener('livewire:initialized', () => {
        const houseId = @js($houseId);

        if (houseId && window.Echo) {
            window.Echo.private('house.' + houseId)
                .listen('.post.activated', (e) => {
                    $wire.handlePostUpdated(e);
                });
        }
    });
</script>
@endscript