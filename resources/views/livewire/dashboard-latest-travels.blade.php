<div class="p-6 bg-white border-b border-gray-200">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($latestTravels as $index => $travel)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($latestTravels as $index => $travel)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img class="d-block w-100 carousel-image" src="{{ $travel->image_url_carrousel }}" alt="{{ $travel->name }}">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $travel->name }}</h5>
                        <p>{{ $travel->total_length }} km</p>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="false"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <p class="text-center mt-4">Derniers voyages ajoutés</p>
</div>

@push('styles')
<style>
    .carousel-image {
        height: 600px; /* Définissez la hauteur souhaitée */
        object-fit: cover; /* Cela permet de conserver le ratio d'aspect tout en remplissant l'espace */
    }
</style>
@endpush
