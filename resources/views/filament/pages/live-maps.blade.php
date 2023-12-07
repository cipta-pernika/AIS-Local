<x-filament-panels::page>
    <div style="width=100vh;height:77vh;" x-ignore ax-load ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('aismaps-js') }}" x-data="leafletAISMaps()">
        <div x-ref="map" id="map" style="width: 100%; height: 100%"></div>
    </div>

    @push('scripts')
    <!-- Leaflet.markercluster CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

    <!-- Leaflet.markercluster JavaScript -->
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

    <!-- Leaflet Providers JavaScript -->
    <script src="https://unpkg.com/leaflet-providers@latest/leaflet-providers.js"></script>

    <!-- Leaflet-Geoman CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css" />

    <!-- Leaflet-Geoman JavaScript -->
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>

    <!-- Leaflet-awesome JavaScript -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.css" integrity="sha512-cUoWMYmv4H9TGP4hbm1mIjYo90WzIQFo/5jj+P5tQcDTf+iVR59RyIj/a9fRsBxzxt5Dnv/Ex7MzRIxcDwaOLw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.min.js" integrity="sha512-8BqQ2RH4L4sQhV41ZB24fUc1nGcjmrTA6DILV/aTPYuUzo+wBdYdp0fvQ76Sxgf36p787CXF7TktWlcxu/zyOg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="
https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.css
" rel="stylesheet">

<script src="
https://cdn.jsdelivr.net/npm/leaflet-sidebar-v2/js/leaflet-sidebar.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/leaflet-sidebar-v2/css/leaflet-sidebar.min.css
" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js" integrity="sha512-b94Z6431JyXY14iSXwgzeZurHHRNkLt9d6bAHt7BZT38eqV+GyngIi/tVye4jBKPYQ2lBdRs0glww4fmpuLRwA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="
https://cdn.jsdelivr.net/npm/leaflet-pulse-icon@0.1.0/src/L.Icon.Pulse.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/leaflet-pulse-icon@0.1.0/src/L.Icon.Pulse.min.css
" rel="stylesheet">    

@endpush
</x-filament-panels::page>