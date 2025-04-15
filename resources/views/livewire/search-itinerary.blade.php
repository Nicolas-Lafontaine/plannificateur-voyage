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
                    <input type="number" wire:model.lazy="minLength" placeholder="Longueur minimale (en km)" class="w-full p-2 border rounded">
                    <input type="number" wire:model.lazy="maxLength" placeholder="Longueur maximale (en km)" class="w-full p-2 border rounded mt-2">
                </div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded" wire:click="render">Filtrer</button>
            </div>
        </div>

        <!-- Cartes des voyages -->
        <div class="row">
            @forelse ($travels as $travel)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ $travel->image_url_card }}" alt="{{ $travel->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $travel->name }}</h5>
                            <p class="card-text">Distance totale : {{ number_format($travel->total_length, 2) }} km</p>
                            <p class="card-text">Impact Co2 : {{ number_format($travel->total_co2_emission_in_kg, 2) }} kg</p>
                            <p class="card-text">Durée totale : {{ $travel->total_duration }} jours</p>
                            <a href="{{ route('travels.show', $travel->id) }}" class="btn btn-primary">Voir</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>Aucun voyage trouvé avec les critères de recherche.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $travels->links() }}
        </div>
    </div>
</div>
