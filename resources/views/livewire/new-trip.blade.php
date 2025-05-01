<div>    
    <div id="map" wire:ignore style="height: 600px; width: 100%;"></div>

    <div class="form-container mt-4 p-4 border border-gray-300 rounded">

    <form wire:submit.prevent="submit" class="border p-4 rounded shadow" style="width: 400px;">
        
        @if (session()->has('message'))
        <div class="text-green-500 font-semibold mb-4">
            {{ session('message') }}
        </div>
        @endif

        <div class="form-group">
            <label for="departureLocation">Départ :</label>
            <input type="text" id="departureLocation" wire:model="departureLocation" class="form-control" required>
            @error('departureLocation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="arrivalLocation">Arrivée :</label>
            <input type="text" id="arrivalLocation" wire:model="arrivalLocation" class="form-control" required>
            @error('arrivalLocation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="transportationName">Transport :</label>
            <select id="transportationName" name="transportationName" class="border rounded p-1" wire:model="transportationName">
                <option value=""></option>
                <option value="driving">Voiture</option>
                <option value="foot">Marche</option>
                <option value="bike">Vélo</option>
            </select>
            @error('transportationName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="daysSpentAtDestination">Jours passés : </label>
            <input type="number" id="daysSpentAtDestination" name="daysSpentAtDestination" wire:model="daysSpentAtDestination" min="0" required class="border rounded p-1" />
            @error('daysSpentAtDestination') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror 
        </div>

        <div class="form-group">
            <label for="description">Description :</label>
            <input type="text" id="description" wire:model="description" class="form-control" required>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        @if($isFirstTrip)
        <div class="form-group">
            <label for="customDepartureDate">Date de départ de votre voyage :</label>
            <input type="date" id="customDepartureDate" wire:model="customDepartureDate" class="form-control" required>
            <small class="form-text text-muted">Choisissez la date de départ de votre tout premier trajet.</small>
            @error('customDepartureDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        @endif


        <button type="submit" class="btn btn-primary btn-block">Soumettre</button>
    </form>
    </div>

    <div id="error-message" class="text-red-500 mt-2"></div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const initialLat = @js($latitudeLastTrip ?? 45.5017);
    const initialLng = @js($longitudeLastTrip ?? -73.5673);
    const zoomLevel = @js($zoomDefault ?? 10);

    let map = L.map('map').setView([initialLat, initialLng], zoomLevel);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let departureMarker = null;
    let arrivalMarker = null;
    let isSettingDeparture = false;
    let isFirstTripCreated = false;

    if(@js(!$isFirstTrip)){
        departureMarker = L.marker([initialLat,initialLng]).addTo(map).bindPopup("Étape précédente").openPopup();
    }

    map.on('click', function(e) {
        const { lat, lng } = e.latlng;
        const coordStr = `${lat.toFixed(5)},${lng.toFixed(5)}`;

        if(@js($isFirstTrip) && !isFirstTripCreated){
            isSettingDeparture = !isSettingDeparture;
            console.log("Changement de l'état de isSettingDeparture");
        }

        if (isSettingDeparture) {
            if (departureMarker) map.removeLayer(departureMarker);
            departureMarker = L.marker(e.latlng).addTo(map).bindPopup("Départ").openPopup();
            document.getElementById('departureLocation').value = coordStr;
            Livewire.dispatch('updateDepartureLocation', { value: coordStr });        
        } else {
            if (arrivalMarker) map.removeLayer(arrivalMarker);
            arrivalMarker = L.marker(e.latlng).addTo(map).bindPopup("Arrivée").openPopup();
            document.getElementById('arrivalLocation').value = coordStr;
            Livewire.dispatch('updateArrivalLocation', { value: coordStr });
        }
    });

    window.addEventListener('trip-added', event => {
    
        console.log("📡 Données reçues de Livewire :", event.detail);
        const lat = event.detail[0].lat;
        const lng = event.detail[0].lng;

        console.log("Lat:", lat);
        console.log("Lng:", lng);


        // Supprime les anciens marqueurs
        if (departureMarker) map.removeLayer(departureMarker);
        if (arrivalMarker) map.removeLayer(arrivalMarker);

        // Place le nouveau marker de départ
        departureMarker = L.marker([lat, lng]).addTo(map).bindPopup("Étape précédente").openPopup();
        map.setView([lat, lng], zoomLevel);

        // Réinitialise les champs
        document.getElementById('departureLocation').value = `${lat},${lng}`;
        Livewire.dispatch('updateDepartureLocation', { value: `${lat},${lng}` });

        isSettingDeparture = false; 
        @js($isFirstTrip = false);
        isFirstTripCreated = true;
        
    });


</script>
@endpush
