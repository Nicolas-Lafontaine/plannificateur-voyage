<div>
    <!-- TABLEAU TRIPS -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom du lieu</th>
                <th>Distance avec l'étape précédente</th>
                <th>Date de départ</th>
                <th>Transport utilisé</th>
                <th>Émission de CO2</th>
                <th>Jours sur place</th>
                <th>Supprimer</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($trips as $trip)
            <tr>
                <td>{{ $trip->description }}</td>
                <td>{{ $trip->length_in_km }} km</td>
                <td>{{ $trip->departure_date->format('Y-m-d')}} </td>
                <td>
                    @php
                        $translations = [
                            'driving' => 'Voiture',
                            'car' => 'Voiture',
                            'plane' => 'Avion',
                            'train' => 'Train',
                            'bus' => 'Bus',
                            'bike' => 'Vélo',
                        ];
                        $name = $trip->transportation->name;
                    @endphp

                    {{ $translations[$name] ?? $name }}
                </td>
                <td>{{ number_format($trip->co2_emission_in_kg, 2) }} kg</td>
                <td>{{ $trip->days_spent_at_destination }}</td>
                <td>
                    <div x-data="{ confirming: false }">
                        <template x-if="!confirming">
                            <button @click="confirming = true" class="btn btn-danger btn-sm">
                                Supprimer
                            </button>
                        </template>
                        <template x-if="confirming">
                            <div class="flex items-center gap-2">
                                <span>Confirmer la suppression ?</span>
                                <button type="button" @click="$wire.deleteTrip({{ $trip->id }})" class="btn btn-danger btn-sm">
                                    Oui
                                </button>
                                <button @click="confirming = false" class="btn btn-secondary btn-sm">
                                    Annuler
                                </button>
                            </div>
                        </template>
                    </div>
                </td>
                <td>
                    <a href="{{ route('edit-trip', $trip->id )}}" class="btn btn-primary">Modifier</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">Aucune étape ajoutée.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-between mt-6">
        <div>
            <strong>Distance totale du voyage :</strong> {{ number_format($total_length,2) }} km
        </div>
        <div>
            <strong>Émission totale de CO2 :</strong> {{ number_format($total_co2_emission_in_kg, 2) }} kg
        </div>
    </div>
    <!-- Bouton flottant rond centré en bas -->
    <a href="{{ route('new-trip', $travel->id) }}" style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; font-size: 24px; color: white; background-color: blue; border: none; border-radius: 50%; text-decoration: none; cursor: pointer; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); z-index: 1000;">
        +
    </a>
</div>


