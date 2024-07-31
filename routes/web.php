<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    FilmController,
    RegisterController
};

Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre');
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'create')->name('register.create');
    Route::post('/register', 'store')->name('register.store');
});
// Route::middleware(['can:isUser'])->group(function() {
//     Route::resource('/movies', FilmController::class);
// });

