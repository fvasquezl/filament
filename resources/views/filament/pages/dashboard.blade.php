{{-- Incluir Vite assets --}}
@if(app()->environment('local'))
    @vite(['resources/js/app.js'])
@else
    <script src="{{ asset('build/assets/app.js') }}" defer></script>
@endif

@stack('scripts')
<x-filament-panels::page>
    <style>
        /* Solo hacer transparente el contenido principal, no el sidebar */
        .fi-main-ctn>.fi-page-wrapper {
            background: transparent !important;
        }

        .fi-page {
            background: transparent !important;
        }

        /* Asegurar que el sidebar mantenga su fondo */
        .fi-sidebar {
            background: rgb(255 255 255 / var(--tw-bg-opacity)) !important;
        }

        .dark .fi-sidebar {
            background: rgb(24 24 27 / var(--tw-bg-opacity)) !important;
        }
    </style>

    <div class="fixed inset-0 -z-10">
        @livewire('realtime-post')
    </div>

</x-filament-panels::page>