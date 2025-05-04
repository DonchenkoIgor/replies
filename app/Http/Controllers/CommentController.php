<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\ReplyStoreRequest;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('comments.index', compact('comments'));
    }

    public function store(CommentStoreRequest $request)
    {
        $validated = $request->validated();

        Comment::create($validated);

        return redirect()->route('comments.index')->with('success', 'Comment created successfully.');
    }

    public function replyStore(ReplyStoreRequest $request, $commentId)
    {
        $validated = $request->validated();

        $validated['comment_id'] = $commentId;

        Reply::create($validated);

        return redirect()->route('comments.index')->with('success', 'Comment created successfully.');
    }
}
