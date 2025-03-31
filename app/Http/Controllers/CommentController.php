<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class CommentController extends Controller
{
    public function list()
    {
        try {
            $commentResources = [];
            Comment::chunk(100, function ($comments) use (&$commentResources) {
                $commentResources = array_merge($commentResources, CommentResource::collection($comments)->toArray(request()));
            });

            return empty($commentResources)
                ? Helper::responseData('No Comments Found', false, null, 404)
                : Helper::responseData('Comments found', true, $commentResources, Response::HTTP_OK);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch comments' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function store(StoreCommentRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = auth('sanctum')->id();
            $comment = Comment::create($data);
            $this->authorize('create', $comment);

            DB::commit();
            return Helper::responseData('Comment Added Successfully', true, new CommentResource($comment), Response::HTTP_OK);
        } catch (Throwable $e) {
            DB::rollBack();
            return Helper::responseData('Failed to add comment' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function show(int $commentId)
    {
        try {
            $comment = Comment::findOrFail($commentId);
            return Helper::responseData('Comment found', true, CommentResource::make($comment), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Comment not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch comment' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function update(UpdateCommentRequest $request, int $commentId)
    {
        try {
            $comment = Comment::findOrFail($commentId);
            $this->authorize('update', $comment);
            $comment->update($request->validated());
            return Helper::responseData('Comment Updated', true, CommentResource::make($comment), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Comment not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to update comment' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function destroy(int $commentId)
    {
        try {
            $comment = Comment::findOrFail($commentId);
            $this->authorize('delete', $comment);
            $comment->delete();

            return Helper::responseData('Comment Deleted', true, null, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Comment not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to delete comment' .' '. $e->getMessage(), false, null, 500);
        }
    }
}
