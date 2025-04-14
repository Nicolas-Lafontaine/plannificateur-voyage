<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes itinéraires') }}
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
            <a href="" style="display: inline-block; padding: 15px 30px; font-size: 18px; color: white; background-color: blue; border: none; border-radius: 5px; text-decoration: none; cursor: pointer;">
                Créer un nouvel itinéraire
            </a>
        </div>




        <!-- Cartes des voyages -->
        <div class="row">
            @forelse ($travels as $travel)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="https://picsum.photos/150" class="card-img-top" alt="Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $travel->name }}</h5>
                            <p class="card-text">Distance totale : {{ number_format($travel->total_length, 2) }} km</p>
                            <p class="card-text">Impact Co2 : {{ number_format($travel->total_co2_emission_in_kg, 2) }} kg</p>
                            <p class="card-text">Durée totale : {{ $travel->total_duration }} jours</p>
                            <a href="{{ route('travels.show', $travel->id) }}" class="btn btn-primary">Voir</a>
                            <a href="{{ route('edit-travel', $travel->id) }}" class="btn btn-primary">Modifier</a>
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
    <!-- Bouton flottant rond centré en bas -->
    <a href="{{ route('new-travel') }}" style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; font-size: 24px; color: white; background-color: blue; border: none; border-radius: 50%; text-decoration: none; cursor: pointer; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); z-index: 1000;">
        +
    </a>
</div>

