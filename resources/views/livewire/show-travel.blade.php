<div>
    <div class="mb-4">
        <label>Départ : <input type="text" wire:model="start" placeholder="-42.0,71.0" class="border rounded p-1" /></label>
        <label>Arrivée : <input type="text" wire:model="end" placeholder="-41.0,72.0" class="border rounded p-1" /></label>
        <label>Points intermédiaires : 
    <input type="text" wire:model="waypoints" placeholder="-41.5,71.5;-41.7,71.7" class="border rounded p-1" />
</label>

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
let markers = [];

document.addEventListener('DOMContentLoaded', function () {

        const initialLat = @js($latitudeTest ?? 72.0);
        const initialLng = @js($longitudeTest ?? -41.0);
        const zoomLevel = @js($zoomTest ?? 6);

        if (!map) {
        // Initialisation unique de la carte
        map = L.map('map').setView([initialLat, initialLng], zoomLevel); // 'map' est l'id html et map la variable js
        console.log('🗺️ Carte initialisée avec succès');
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
    }

        // Ajout des marqueurs de départ et d'arrivée
        function updateMarkers(routeCoordinates, waypoints) {
        // Supprime les anciens marqueurs
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];

            // Ajoute le marqueur de départ
        let startMarker = L.marker([routeCoordinates[0][1], routeCoordinates[0][0]]).addTo(map)
            .bindPopup("Départ");
        markers.push(startMarker);

        // Ajoute les marqueurs pour les points intermédiaires
        waypoints.forEach((waypoint, index) => {
            let [lon, lat] = waypoint.split(',').map(coord => parseFloat(coord.trim()));
            let marker = L.marker([lat, lon]).addTo(map)
                .bindPopup(`Point intermédiaire ${index + 1}`);
            markers.push(marker);
        });

        // Ajoute le marqueur d'arrivée
        let endMarker = L.marker([routeCoordinates[routeCoordinates.length - 1][1], routeCoordinates[routeCoordinates.length - 1][0]]).addTo(map)
            .bindPopup("Arrivée");
        markers.push(endMarker);

        }

    window.addEventListener('updateRoute', (event) => {
        let routeGeoJSON = event.detail; // Récupérer les données de l'événement (la réponse de OSRM)
        
        console.log('event.detail avant conversion : ',event.detail);

        if (Array.isArray(routeGeoJSON)) { // event.detail est un tableau de coordonnées, on le convertit en GeoJSON
        routeGeoJSON = {
            "type": "FeatureCollection",
            "features": routeGeoJSON.map(item => ({
                "type": "Feature",
                "geometry": item
            }))
        };
    }
    console.log('event.detail après conversion : ',event.detail);

        if (routeLayer) {
            map.removeLayer(routeLayer); // Supprimer l'ancienne route si il'y en a une déjà affichée
        }
        
        routeLayer = L.geoJSON(routeGeoJSON, { color: 'blue', weight: 4 }).addTo(map);
        map.fitBounds(routeLayer.getBounds()); // Ajuster la vue pour voir tout le tracé de l'itinéraire

            // Récupération de toutes les coordonnées de l'itinéraire
    const coordinates = routeGeoJSON.features[0].geometry.coordinates;

    // Récupérer les waypoints depuis le composant Livewire
    const waypoints = @js(explode(';', $waypoints)); // Assurez-vous que $waypoints est bien formaté

    console.log('waypoints : ',waypoints);

    updateMarkers(coordinates, waypoints); // Ajout des marqueurs sur tous les points
        });
    });

</script>
@endpush
