<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CityController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\PlaylistSongController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\StoreController;
use Illuminate\Auth\Events\Login;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1/users')
    ->controller(AuthController::class)
    ->group(function () {
        Route::get('list-user', 'index');
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::get('/detail/{id}', 'getDetailUser');
        Route::get('/new-users', 'getNewUsersPerMonth');
        Route::get('/most-songs', 'getUsersWithMostSongs');
        Route::get('/artist', 'getArtist');
    });

Route::prefix('v1/songs')
    ->controller(SongController::class)
    ->group(function () {
        Route::get('/index', 'index');
        Route::get('/{id}', 'getDetailById')->where('id', '[0-9]+');
        Route::get('/byUser/{user_id}', 'getSongByUser');
        Route::post('/search', 'search');
        Route::get('/trending-songs', 'trendingSongs');
        Route::get('/new-songs', 'newSongs');
    });


Route::prefix('v1/genres')
    ->controller(GenreController::class)
    ->group(function () {
        Route::get('/index', 'index');
        Route::get('/detail/{id}', 'detail');
    });


Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('v1/dashboard')
        ->middleware('admin')
        ->controller(SongController::class)
        ->group(function () {
            
    });

    Route::prefix('v1/genres')
        ->controller(GenreController::class)
        ->group(function () {
            Route::post('/add', 'add');
            Route::put('/edit/{id}', 'edit');
            Route::delete('delete/{id}', 'delete');
        });

    Route::prefix('v1/users')
        ->controller(AuthController::class)
        ->group(function () {
            Route::get('/info', 'info');
            Route::put('/update', 'updateInfo');
        });

    Route::prefix('v1/playlists')
        ->controller(PlaylistController::class)
        ->group(function () {
            Route::get('/get/{id}', 'index');
            Route::get('/detail/{id}', 'detail');
            Route::post('/add/{id}', 'add');
            Route::put('/edit/{id}', 'edit');
            Route::delete('/delete/{id}', 'delete');
        });

        Route::prefix('v1/playlist-songs')
        ->controller(PlaylistSongController::class)
        ->group(function () {
            Route::post('/add', 'add');
            Route::post('/delete', 'delete');
        });

    Route::prefix('v1/songs')
        ->controller(SongController::class)
        ->group(function () {
            Route::get('/list-song', 'index');
            Route::get('/detail-with-user/{id}', 'getDetailById')->where('id', '[0-9]+');
            Route::post('/add', 'addSong');
            Route::delete('/delete/{id}', 'delete');
            Route::put('/update/{id}', 'updateSong');
        });

    Route::prefix('v1/interactions')
        ->controller(InteractionController::class)
        ->group(function () {
            Route::post('/like', 'like');
            Route::post('/play', 'play');
            Route::get('/get-liked-song/{user_id}', 'getLikedSong');
        });

    Route::prefix('v1/comments')
        ->controller(CommentController::class)
        ->group(function () {
            Route::post('/post', 'add');
        });

    Route::prefix('v1/albums')
        ->controller(AlbumController::class)
        ->group(function () {
            Route::get('/get/{user_id}', 'index');
            Route::get('detail/{id}', 'detail');
            Route::post('/add', 'add');
            Route::put('/edit/{id}', 'edit');
            Route::delete('/delete/{id}', 'delete');
        });
});

