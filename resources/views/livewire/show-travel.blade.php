<x-app-layout>
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $travel->name }}
        </h2>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <p><strong>Distance totale:</strong> {{ $travel->total_length }} km</p>
            <!-- Ajoutez plus de détails ici selon vos besoins -->
        </div>
    </div>
</x-app-layout>