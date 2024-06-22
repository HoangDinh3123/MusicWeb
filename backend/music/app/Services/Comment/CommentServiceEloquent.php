<?php
namespace App\Services\Comment;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepository;
use Illuminate\Support\Collection;

class CommentServiceEloquent implements CommentService 
{
    public function __construct(protected CommentRepository $commentRepository)
    {
        
    }

    /**
     * @return commentRepository
     */

     public function getAll(int $song_id): Collection
     {
        return $this->commentRepository
            ->where('song_id', $song_id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->get();
     }

     public function getDetail(int $id)
     {
      return $this->commentRepository->find($id);
     }

     public function add(array $attributes)
     {
        return $this->commentRepository->create($attributes);
     }
}