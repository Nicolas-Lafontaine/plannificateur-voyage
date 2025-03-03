<div>
    <div class="mb-4">
        <label>Départ : <input type="text" wire:model="start" placeholder="-42.0,71.0" class="border rounded p-1" /></label>
        <label>Arrivée : <input type="text" wire:model="end" placeholder="-41.0,72.0" class="border rounded p-1" /></label>
        <button wire:click="getRoute" class="px-4 py-2 bg-blue-500 text-white rounded">Tracer la route</button>
    </div>

    @if (session()->has('error'))
        <div class="text-red-500">{{ session('error') }}</div>
    @endif

    <div wire:ignore>
        <div id="map" style="height: 800px;"></div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
let map;  
let routeLayer; 

document.addEventListener('DOMContentLoaded', function () {

        const initialLat = @js($latitudeTest ?? 72.0);
        const initialLng = @js($longitudeTest ?? -41.0);
        const zoomLevel = @js($zoomTest ?? 6);

        if (!map) {
        // Initialisation unique de la carte
        map = L.map('map').setView([initialLat, initialLng], zoomLevel);
        console.log('🗺️ Carte initialisée avec succès');
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
    }

    window.addEventListener('updateRoute', (event) => {
        const routeGeoJSON = event.detail; // Récupérer les données de l'événement
        if (routeLayer) {
            map.removeLayer(routeLayer); // Supprimer l'ancienne route
        }

            routeLayer = L.geoJSON(routeGeoJSON, { color: 'blue', weight: 4 }).addTo(map);
            map.fitBounds(routeLayer.getBounds()); // Ajuster la vue
        });
    });

</script>
@endpush
