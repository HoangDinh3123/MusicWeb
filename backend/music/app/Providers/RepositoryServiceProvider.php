<?php

namespace App\Providers;

use App\Repositories\Album\AlbumRepository;
use App\Repositories\Album\AlbumRepositoryEloquent;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\CommentRepositoryEloquent;
use App\Repositories\Genre\GenreRepository;
use App\Repositories\Genre\GenreRepositoryEloquent;
use App\Repositories\GenreSong\GenreSongRepository;
use App\Repositories\GenreSong\GenreSongRepositoryEloquent;
use App\Repositories\Interaction\InteractionRepository;
use App\Repositories\Interaction\InteractionRepositoryEloquent;
use App\Repositories\Playlist\PlaylistRepository;
use App\Repositories\Playlist\PlaylistRepositoryEloquent;
use App\Repositories\PlaylistSong\PlaylistSongRepository;
use App\Repositories\PlaylistSong\PlaylistSongRepositoryEloquent;
use App\Repositories\Song\SongRepository;
use App\Repositories\Song\SongRepositoryEloquent;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->singleton(SongRepository::class, SongRepositoryEloquent::class);
        $this->app->singleton(InteractionRepository::class, InteractionRepositoryEloquent::class);
        $this->app->singleton(GenreRepository::class, GenreRepositoryEloquent::class);
        $this->app->singleton(GenreSongRepository::class, GenreSongRepositoryEloquent::class);
        $this->app->singleton(PlaylistRepository::class, PlaylistRepositoryEloquent::class);
        $this->app->singleton(PlaylistSongRepository::class, PlaylistSongRepositoryEloquent::class);
        $this->app->singleton(CommentRepository::class, CommentRepositoryEloquent::class);
        $this->app->singleton(AlbumRepository::class, AlbumRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
