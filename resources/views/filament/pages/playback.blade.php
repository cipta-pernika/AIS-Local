<x-filament-panels::page>
    {{ $this->form }}
    <div class="flex flex-row gap-4">
        <div class="basis-2/3">
            <div style="width=100vh;height:77vh;" x-ignore ax-load ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('playback-js') }}" x-data="leafletAISMaps()">
                <div x-ref="map" id="map" style="width: 100%; height: 100%"></div>
            </div>
        </div>
        <div class="basis-auto">
            <x-filament::section>
                <x-filament::section.heading>Summary</x-filament::section.heading>
            </x-filament::section>
        </div>
    </div>




    @push('scripts')
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Leaflet Providers JavaScript -->
    <script src="https://unpkg.com/leaflet-providers@latest/leaflet-providers.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js" integrity="sha512-b94Z6431JyXY14iSXwgzeZurHHRNkLt9d6bAHt7BZT38eqV+GyngIi/tVye4jBKPYQ2lBdRs0glww4fmpuLRwA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="https://cdn.jsdelivr.net/npm/leaflet-plugin-trackplayback@1.0.5/dist/control.trackplayback.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-plugin-trackplayback@1.0.5/dist/leaflet.trackplayback.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-plugin-trackplayback@1.0.5/dist/control.playback.min.css"> -->
    <link rel="stylesheet" href="{{asset('js/leaflet-trackplayback/control/control.playback.min.css')}}">
    @endpush
</x-filament-panels::page>