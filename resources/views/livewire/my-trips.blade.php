<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Liste de Nombres') }}
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Contenu personnalisé pour la liste de nombres -->
                    <p>Liste de nombres :</p>
                    <ul>
                        @foreach ($numbers as $number)
                            <li>{{ $number }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
