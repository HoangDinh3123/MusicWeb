<?php

namespace App\Http\Controllers;

use App\Events\CommentBroadcast;
use App\Events\ReplyCommentBroadcast;
use App\Http\Requests\Comment\AddCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Services\Comment\CommentService;
use Illuminate\Http\JsonResponse;
use App\Traits\APIResponseTrait;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use APIResponseTrait;

    public function __construct(protected CommentService $commentService)
    {
        
    }


    public function add(AddCommentRequest $request)
    {
        try {
            $data = $this->commentService->add($request->validated());

            $comment = new CommentResource($this->commentService->getDetail($data->id));
            if($request->input('parent_id') !== null) {
                event(new ReplyCommentBroadcast($comment, $request->input('parent_id')));
            }
            else
            {
                event(new CommentBroadcast($comment, $request->input('song_id')));
            }

            return $this->successResponse($comment);

        }
        catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Somethings went wrong', 500);
        }
    }
}
