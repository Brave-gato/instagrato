<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', [PostController::class, 'index'])->name('home');

// Routes pour les posts
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Création et gestion des posts (à ajouter si nécessaire)
    // Route::resource('posts', PostController::class)->except(['index', 'show']);
});

// Routes d'authentification
Route::middleware(['auth'])->group(function () {
    // Vos routes qui nécessitent une authentification
});


require __DIR__ . '/auth.php';
