<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Enum\CommentStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pendingCommentsCount = Comment::where('status', CommentStatusEnum::Pending)->count();
        $rejectedCommentsCount = Comment::where('status', CommentStatusEnum::Rejected)->count();
        $usersCount = User::count();
        $postsCount = Post::count();

        return view('admin.dashboard', compact(
            'pendingCommentsCount',
            'rejectedCommentsCount',
            'usersCount',
            'postsCount'
        ));
    }
}
