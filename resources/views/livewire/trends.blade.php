<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Tendances') }}
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Pays le plus visité -->
        <div class="bg-white shadow-lg rounded-xl p-4 flex flex-col items-center">
            <img src="{{ $mostVisitedCountryImage }}" alt="Pays le plus visité" class="w-20 h-20 mb-3">
            <p class="text-lg font-semibold">Pays le plus visité</p>
            <p class="text-gray-600">{{ $mostVisitedCountryName }}</p>
        </div>

        <!-- Nombre moyen de Km par voyage -->
        <div class="bg-white shadow-lg rounded-xl p-4 flex flex-col items-center">
            <img src="{{ asset('images/icons/road.png') }}" alt="Distance moyenne" class="w-20 h-20 mb-3">
            <p class="text-lg font-semibold">Distance moyenne des voyages</p>
            <p class="text-gray-600">{{ $averageKm }} km</p>
        </div>

        <!-- Moyen de transport favori -->
        <div class="bg-white shadow-lg rounded-xl p-4 flex flex-col items-center">
            <img src="{{ $mostPopularTransportImage }}" alt="Transport favori" class="w-20 h-20 mb-3">
            <p class="text-lg font-semibold">Moyen de transport favori</p>
            <p class="text-gray-600">{{ $mostPopularTransportName }}</p>
        </div>

        <!-- Durée moyenne -->
        <div class="bg-white shadow-lg rounded-xl p-4 flex flex-col items-center">
            <img src="{{ asset('images/icons/calendar.png') }}" alt="Durée moyenne" class="w-20 h-20 mb-3">
            <p class="text-lg font-semibold">Durée moyenne des voyages</p>
            <p class="text-gray-600">{{ $averageDuration }} jours</p>
        </div>
    </div>
</div>
