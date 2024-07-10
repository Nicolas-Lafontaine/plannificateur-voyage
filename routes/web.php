<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Login;

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
});
