<div wire:ignore.self>
    <div id="map" style="height: 800px;"></div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapContainer = document.getElementById('map');

    if (mapContainer && !mapContainer._leaflet_id) { // Empêche la réinitialisation multiple
        const map = L.map('map').setView([45.5017, -73.5673], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([45.5017, -73.5673]).addTo(map)
            .bindPopup('Montreal !')
            .openPopup();
    }
});

</script>
@endpush
