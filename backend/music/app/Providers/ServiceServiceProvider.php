<?php

namespace App\Providers;

use App\Services\Album\AlbumService;
use App\Services\Album\AlbumServiceEloquent;
use App\Services\Comment\CommentService;
use App\Services\Comment\CommentServiceEloquent;
use App\Services\Genre\GenreService;
use App\Services\Genre\GenreServiceEloquent;
use App\Services\GenreSong\GenreSongService;
use App\Services\GenreSong\GenreSongServiceEloquent;
use App\Services\Interaction\InteractionService;
use App\Services\Interaction\InteractionServiceEloquent;
use App\Services\Playlist\PlaylistService;
use App\Services\Playlist\PlaylistServiceEloquent;
use App\Services\PlayListSong\PlaylistSongService;
use App\Services\PlayListSong\PlayListSongServiceEloquent;
use App\Services\Song\SongService;
use App\Services\Song\SongServiceEloquent;
use App\Services\User\UserService;
use App\Services\User\UserServiceEloquent;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserService::class, UserServiceEloquent::class);
        $this->app->singleton(SongService::class, SongServiceEloquent::class);
        $this->app->singleton(InteractionService::class, InteractionServiceEloquent::class);
        $this->app->singleton(GenreService::class, GenreServiceEloquent::class);
        $this->app->singleton(GenreSongService::class, GenreSongServiceEloquent::class);
        $this->app->singleton(PlaylistService::class, PlaylistServiceEloquent::class);
        $this->app->singleton(PlaylistSongService::class, PlayListSongServiceEloquent::class);
        $this->app->singleton(CommentService::class, CommentServiceEloquent::class);
        $this->app->singleton(AlbumService::class, AlbumServiceEloquent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
