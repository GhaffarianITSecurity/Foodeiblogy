<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Enum\CommentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommentAnswerRequest;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::when($request->filled('status'), function ($query) use ($request) {
            $query->where('status', CommentStatusEnum::from($request->status));
        })->orderByDesc('created_at')->paginate();

        return view('admin.comment.index', compact('comments'));
    }

    public function show(Comment $comment)
    {
        return view('admin.comment.show', compact('comment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string',
        ]);

        $comment = Comment::create([
            'post_id' => $validated['post_id'],
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'comment' => $validated['comment'],
            'status' => CommentStatusEnum::Pending,
        ]);

        return back()->with('success', 'نظر شما با موفقیت ثبت شد و پس از تایید نمایش داده خواهد شد.');
    }

    public function answer(CommentAnswerRequest $request, Comment $comment)
    {
        $comment->answer()->create([
            'user_id' => auth()->id(),
            'full_name' => auth()->user()->full_name,
            'email' => auth()->user()->email,
            'post_id' => $comment->post_id,
            'comment' => $request->validated('content'),
            'status' => CommentStatusEnum::Approved,
        ]);

        return to_route('admin.comment.show', $comment)->with('success', 'پاسخ نظر ثبت شد.');
    }

    public function destroy(Comment $comment)
    {
        foreach ($comment->answer as $ans) {
            $ans->delete();
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'حذف پست مورد نظر  همراه با نظرات آن انجام شد.'
        ]);
    }

    public function status(Request $request, Comment $comment)
    {
        $comment->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'color' => $comment->status_color,
            'title' => $comment->status_title,
            'message' => 'تغییر وضعیت نظر انجام شد.'
        ]);
    }
}
