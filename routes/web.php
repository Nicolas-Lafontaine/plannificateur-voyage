<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Login;
use App\Livewire\SearchItinerary;
use App\Livewire\MyTrips;
use App\Livewire\Trends;
use App\Livewire\ShowTravel;
use App\Livewire\NewTravel;
use App\Livewire\EditTravel;
use App\Livewire\EditTrip;
use App\Livewire\NewTrip;


Route::get('/', function () {
    return view('welcome');
});

// Route pour le composant Livewire personnalisé (si nécessaire)
Route::get('/mon-composant', function () {
    return view('livewire.mon-composant');
});



// Utiliser les routes par défaut de Jetstream pour la connexion et l'inscription
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/testbug', function () {
    return view('testbugview');
    });

Route::get('/searchitinerary', function () {
    return view('searchview');  
})->name('searchitinerary');

Route::get('/mytrips', function () {
    return view('mytripsview');
})->name('mytrips');

Route::get('/new-travel', function () {
    return view('newtravelview');
})->name('new-travel');

Route::get('/new-trip/{id}', function () {
    return view('newtripview', ['id' => $id]);
})->name('new-trip');

Route::get('/edit-travel/{id}', function () {
    return view('edittravelview', ['id' => $id]);
})->name('edit-travel');

Route::get('/edit-trip/{id}', function () {
    return view('edittripview', ['id' => $id]);
})->name('edit-trip');

Route::get('/trends!', function () {
    return view('trendsview');
})->name('trends!');

Route::get('/travels/{id}', function($id) {
    return view('travels.show', ['id' => $id]);
})->name('travels.show');

        // Route pour le composant Livewire NewTravel
        Route::get('/new-travel', NewTravel::class)->name('new-travel');

        Route::get('/new-trip/{id}', NewTrip::class)->name('new-trip');

        // Route pour le composant Livewire NewTravel
        Route::get('/edit-travel/{id}', EditTravel::class)->name('edit-travel');

        Route::get('/edit-trip/{id}', EditTrip::class)->name('edit-trip');

        // Route pour le composant Livewire MyTrips
        Route::get('/my-trips', MyTrips::class)->name('my-trips');

        // Route pour le composant Livewire SearchItinerary
        Route::get('/search-itinerary', SearchItinerary::class)->name('search-itinerary');

        // Route pour le composant Livewire Trends
        Route::get('/trends', Trends::class)->name('trends');

        Route::get('/travels/{id}', ShowTravel::class)->name('travels.show');
});

// Route::get('/search-itinerary', function () {
//     return view('livewire.search-itinerary'); // Créez cette vue si nécessaire
// })->name('search-itinerary');


// Route::get('/trends', function () {
//     return view('livewire.trends'); // Créez cette vue si nécessaire
// })->name('trends');

        