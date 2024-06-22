<?php

namespace App\Providers;

use App\Models\Playlist;
use App\Models\Song;
use App\Models\Album;
use App\Models\Genre;
use App\Observers\SongObserver;
use App\Observers\AlbumObserver;
use App\Observers\GenreObserver;
use App\Observers\PlaylistObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Song::observe(SongObserver::class);
        Playlist::observe(PlaylistObserver::class);
        Album::observe(AlbumObserver::class);
        Genre::observe(GenreObserver::class);
    }
}
