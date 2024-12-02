<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ImageController;

/* Web Routes */
// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Routes d'authentification
Auth::routes();

// Routes protégées par authentification. Protected routes
Route::middleware('auth')->group(function () {

    //Routes intervention-image
    //Route::get('image-upload', [ImageController::class, 'index']);
    //Route::post('image-upload', [ImageController::class, 'store'])->name('image.store');

    // Page d'accueil. Home feed
    Route::get('/', [PostController::class, 'index'])->name('home');


    //on peut la retirer, laissé pour test   
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Posts
    Route::prefix('posts')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        
        // Comments on posts
        Route::post('/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        
        // Likes on posts
        Route::post('/{post}/likes', [LikeController::class, 'store'])->name('likes.store');
        Route::delete('/{post}/likes', [LikeController::class, 'destroy'])->name('likes.destroy');
    });
    
    // Profiles
    Route::prefix('profile')->group(function () {
        Route::get('/{user}', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/{user}', [ProfileController::class, 'update'])->name('profile.update');
    });
    
    // Following
    Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('follow.destroy');
    
    // Search
    Route::get('/search', SearchController::class)->name('search');
});



require __DIR__ . '/auth.php';
