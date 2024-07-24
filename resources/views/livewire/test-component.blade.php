<x-app-layout>
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rechercher un itinéraire') }}
            </h2>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <!-- Filtres et champ de recherche -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div class="flex-1 mr-4">
                        <input type="text" placeholder="Rechercher" class="w-full p-2 border rounded">
                    </div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Filtrer</button>
                </div>
            </div>

            <!-- Cartes des voyages -->
            <div class="grid grid-cols-2 gap-6">
                @foreach ($travels as $travel)
                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                        <img src="https://via.placeholder.com/150" alt="Image" class="w-full h-32 object-cover rounded mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $travel->name }}</h3>
                        <p class="text-gray-700 mb-4">Distance totale : {{ $travel->total_length }} km</p>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">Voir</button>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                <span class="mx-1">1</span>
                <span class="mx-1">2</span>
                <span class="mx-1">3</span>
                <span class="mx-1">...</span>
                <span class="mx-1">10</span>
            </div>
        </div>
    </div>
</x-app-layout>
