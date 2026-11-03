<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Route::get('/', [MovieController::class, 'index']);
Route::get('/', [MovieController::class, 'index']);
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movie.show');
Route::get('/search', [MovieController::class, 'search'])->name('movies.search');
// Admin Panel Route
Route::get('/admin/add-movie', [MovieController::class, 'createMovieLink'])->name('admin.create');
Route::post('/admin/save-movie', [MovieController::class, 'storeMovieLink'])->name('admin.store');
Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movie.show');
Route::get('/search', [MovieController::class, 'search'])->name('movie.search');
Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movie.show');
Route::get('/series/{id}/{season?}/{episode?}', [MovieController::class, 'showSeries'])->name('series.show');
Route::get('/search', [MovieController::class, 'search'])->name('movie.search');
