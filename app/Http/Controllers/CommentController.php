<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function list()
    {
        $commentResources = [];
        Comment::chunk(100, function ($comments) use (&$commentResources) {
            $commentResources = array_merge($commentResources, CommentResource::collection($comments)->toArray(request()));
        });
        if (empty($commentResources)) {
            return Helper::responseData('No Comments Found', false, null, 404);
        }
        return Helper::responseData('Comments found', true, $commentResources, Response::HTTP_OK);
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create([
            'content' => $request->input('content'),
            'parent_id' => $request->input('parent_id', null), // Default to null if not provided
            'product_id' => $request->input('product_id'),     // Ensure this is passed in the request
            'user_id' => auth('sanctum')->id(),                         // Set to the authenticated user ID
            'rate' => $request->input('rate', null),           // Default to null if not provided
        ]);//        $this->authorize('create', $comment);

        return Helper::responseData('Comment Added Successfully', true, new CommentResource($comment), Response::HTTP_OK);
    }

    public function show(int $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        return Helper::responseData('Comment found', true, CommentResource::make($comment), Response::HTTP_OK);
    }

    public function update(UpdateCommentRequest $request, int $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->update($request->validated());
        return Helper::responseData('Comment Updated', true, CommentResource::make($comment), Response::HTTP_OK);
    }

    public function destroy(int $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();

        return Helper::responseData('Comment Deleted', true, null, Response::HTTP_OK);
    }
}
