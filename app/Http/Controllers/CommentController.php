<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Enum\CommentStatusEnum;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string',
        ]);

        $comment = Comment::create([
            'post_id' => $validated['post_id'],
            'user_id' => auth()->id(),
            'full_name' => auth()->user()->full_name,
            'email' => auth()->user()->email,
            'comment' => $validated['comment'],
            'status' => CommentStatusEnum::Pending,
        ]);

        return back()->with('success', 'نظر شما با موفقیت ثبت شد و پس از تایید نمایش داده خواهد شد.');
    }
} 