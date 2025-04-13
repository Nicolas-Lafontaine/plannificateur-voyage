<div>
    <!-- TABLEAU TRIPS -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom du lieu</th>
                <th>Distance avec étape précédente</th>
                <th>Date prévue</th>
                <th>Transport utilisé</th>
                <th>Émission de CO2 (kg)</th>
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
                <td>{{ $trip->transportation->name }}</td>
                <td>{{ number_format($trip->co2_emission_in_kg, 2) }}</td>
                <td>{{ $trip->days_spent_at_destination }}</td>
                <td>
                    <button wire:click="deleteTrip({{ $trip->id }})" class="btn btn-danger btn-sm"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette étape ?')">
                        Supprimer
                    </button>
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

</div>


