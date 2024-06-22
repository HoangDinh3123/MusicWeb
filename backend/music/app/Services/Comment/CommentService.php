<?php
namespace App\Services\Comment;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepository;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

interface CommentService {
    /**
     * @return CommentRepository
     */
    public function getAll(int $song_id): Collection;
    public function getDetail(int $id);
    public function add(array $attributes);
    
}