<!-- Partie gauche (carte) -->
<div style="display: table; width: 100%; height: 100vh;">
    <div style="display: table-cell; width: 70%; vertical-align: top;">
        <div wire:ignore id="map" style="height: 100vh;"></div>
    </div>
<!-- Partie droite (scrollbox contenant les étapes) -->
<div style="display: table-cell; width: 35%; vertical-align: top; height: 100vh;">
    <div style="height: 100%; overflow-y: auto; padding: 15px;">
        <div class="row">
            @forelse ($travel->trips as $trip)
                <div class="col-12 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset($trip->pictures) }}" class="card-img-top" alt="image de l'étape">
                        <div class="card-body">
                            <p class="card-text">{{ $trip->description }}</p>
                            <!-- Bouton pour ouvrir la partie déroulante -->
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#comments-{{ $trip->id }}" aria-expanded="false" aria-controls="comments-{{ $trip->id }}">
                                Voir les commentaires <span class="ml-1">&#x25BC;</span> <!-- flèche vers le bas -->
                            </button>
                            <!-- Partie masquée par défaut -->
                            <div class="collapse mt-2" id="comments-{{ $trip->id }}">
                                <div class="card card-body" style="max-width: 500px;">
                                    @if ($trip->commentaries && count($trip->commentaries) > 0)
                                        <ul>
                                            @foreach ($trip->commentaries as $commentary)
                                                <li>
                                                    <span style="font-weight: bold; font-size: 1.2em; color: red;">
                                                    {{ $commentary->user->name }}
                                                    </span>                                                
                                                </li>
                                                <li>{{ $commentary->text }}</li>
                                                <li>
                                                    <span style="font-size: 0.8em; color: gray;">
                                                    {{ $commentary->created_at}}
                                                    </span>
                                                </li>
                                                @if ($commentary->user_id === auth()->id())
                                                <li>
                                                    <button wire:click="deleteComment({{ $commentary->id }})" class="btn btn-sm btn-danger mt-1">
                                                        Supprimer
                                                    </button>
                                                </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Aucun commentaire.</p>
                                    @endif
                                    <!-- Formulaire d'ajout de commentaire -->
                                    <div>
                                        <textarea wire:model.defer="newComment.{{ $trip->id }}"
                                                class="form-control @error('newComment.' . $trip->id) is-invalid @enderror"
                                                rows="3" maxlength="250" placeholder="Écrire un commentaire (max 250 caractères)"></textarea>
                                        @error('newComment.' . $trip->id)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <button wire:click="addComment({{ $trip->id }})"
                                                class="btn btn-sm btn-primary mt-2">
                                            Envoyer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Aucune étape enregistrée.</p>
            @endforelse
        </div>
    </div>
</div>

</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
let map;  
let routeLayer; 
let markers = [];

    const initialLat = @js($latitudeLastTrip ?? 45.5017);
    const initialLng = @js($longitudeLastTrip ?? -73.5673);
    const zoomLevel = @js($zoomDefault ?? 10);

        if (!map) {
        // Initialisation unique de la carte
        map = L.map('map').setView([initialLat, initialLng], zoomLevel); // 'map' est l'id html et map la variable js
        console.log('🗺️ Carte initialisée avec succès');
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
    }

        // Ajout des marqueurs de départ et d'arrivée
        function updateMarkers(routeCoordinates, waypoints, descriptions) {

        // Supprime les anciens marqueurs
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];

        // Ajoute le marqueur de départ
        let startMarker = L.marker([routeCoordinates[0][1], routeCoordinates[0][0]]).addTo(map)
            .bindPopup("Départ");
        markers.push(startMarker);

        console.log('1er marqueurs ajouté pour les coordonnées : ' ,routeCoordinates[0][1], routeCoordinates[0][0]); 
       
        // Ajoute les marqueurs pour les points intermédiaires
        waypoints.forEach((waypoint, index) => {
            let [lon, lat] = waypoint.split(',').map(coord => parseFloat(coord.trim()));
            let marker = L.marker([lat, lon]).addTo(map)
                .bindPopup(descriptions[index]);
            markers.push(marker);
        });

        // Ajoute le marqueur d'arrivée
        let endMarker = L.marker([routeCoordinates[routeCoordinates.length - 1][1], routeCoordinates[routeCoordinates.length - 1][0]]).addTo(map)
            .bindPopup(descriptions[descriptions.length - 1]);
        markers.push(endMarker);
        }

    window.addEventListener('updateRoute', (event) => {
        console.log("📡 Données brutes reçues de Livewire :", event.detail[0]);
        console.log("📡 Données reçues de Livewire :", event.detail);

        if (!event.detail) {
            console.error("❌ ERREUR : Aucune donnée reçue de Livewire !");
            return;
        }

        let routeGeoJSON = event.detail[0].routeGeoJSON; // Récupérer les données de l'événement (la réponse de OSRM)
        let waypointsString = event.detail[0].waypoints || '';
        let descriptions = event.detail[0].descriptions;

        let waypoints = waypointsString ? waypointsString.split(';') : [];

        if (Array.isArray(routeGeoJSON)) { // event.detail est un tableau de coordonnées, on le convertit en GeoJSON
        routeGeoJSON = {
            "type": "FeatureCollection",
            "features": routeGeoJSON.map(item => ({
                "type": "Feature",
                "geometry": item
            }))
        };
        } else if (routeGeoJSON.type === "LineString" && Array.isArray(routeGeoJSON.coordinates)) { 
        // Cas où event.detail est directement un objet LineString
        routeGeoJSON = {
            "type": "FeatureCollection",
            "features": [{
                "type": "Feature",
                "geometry": routeGeoJSON
            }]
        };
        }

        if (routeLayer) {
            map.removeLayer(routeLayer); // Supprimer l'ancienne route si il'y en a une déjà affichée
        }
        
        routeLayer = L.geoJSON(routeGeoJSON, { color: 'blue', weight: 4 }).addTo(map);
        map.fitBounds(routeLayer.getBounds()); // Ajuster la vue pour voir tout le tracé de l'itinéraire

            // Récupération de toutes les coordonnées de l'itinéraire
            const allCoordinates = [];

        // Itérer sur chaque feature et concaténer les coordonnées
        routeGeoJSON.features.forEach(feature => {
            // Vérifier si la géométrie et les coordonnées existent
            if (feature.geometry && feature.geometry.coordinates) {
                // Concaténer les coordonnées dans le tableau allCoordinates
                allCoordinates.push(...feature.geometry.coordinates);
            }
        });

    updateMarkers(allCoordinates, waypoints, descriptions); // Ajout des marqueurs sur tous les points
        });

</script>
@endpush
