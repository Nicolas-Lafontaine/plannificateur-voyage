<div>
    <h2>Ajouter une étape</h2>
    
    <div id="map" wire:ignore style="height: 600px; width: 100%;"></div>

    <div class="form-container mt-4 p-4 border border-gray-300 rounded">

    <form wire:submit.prevent="submit" class="border p-4 rounded shadow" style="width: 400px;">
        
        <div class="form-group">
            <label for="departureLocation">Départ :</label>
            <input type="text" id="departureLocation" wire:model="departureLocation" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="arrivalLocation">Arrivée :</label>
            <input type="text" id="arrivalLocation" wire:model="arrivalLocation" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="transportationName">Transport :</label>
            <select id="transportationName" name="transportationName" class="border rounded p-1" wire:model="transportationName">
                <option value="driving">Voiture</option>
                <option value="train">Train</option>
                <option value="foot">Marche</option>
                <option value="bike">Vélo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="daysSpentAtDestination">Jours passés : </label>
            <input type="number" id="daysSpentAtDestination" name="daysSpentAtDestination" wire:model="daysSpentAtDestination" min="0" required class="border rounded p-1" />
        </div>

        <div class="form-group">
            <label for="description">Description :</label>
            <input type="text" id="description" wire:model="description" class="form-control" required>
        </div>


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
    let map = L.map('map').setView([45.5017, -73.5673], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let departureMarker = null;
    let arrivalMarker = null;
    let isSettingDeparture = true;
    let testValue = "toto";

    map.on('click', function(e) {
        const { lat, lng } = e.latlng;
        const coordStr = `${lat.toFixed(5)},${lng.toFixed(5)}`;

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
        isSettingDeparture = !isSettingDeparture;
    });

</script>
@endpush
