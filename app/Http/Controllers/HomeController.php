<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Enum\PostStatusEnum;
use App\Enum\CommentStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Initialize variables with empty collections
            $featuredPost = null;
            $latestPosts = new Collection();
            $featuredPosts = new Collection();
            $recentPosts = new Collection();
            $categories = new Collection();

            // Get featured post (latest published post)
            $featuredPost = Post::with(['author', 'category'])
                ->where('status', PostStatusEnum::Published)
                ->latest()
                ->first();

            // Get latest posts for the hero section
            $latestPosts = Post::with(['author', 'category'])
                ->where('status', PostStatusEnum::Published)
                ->latest()
                ->take(4)
                ->get();

            // Get posts for the featured posts section
            $featuredPosts = Post::with(['author', 'category'])
                ->where('status', PostStatusEnum::Published)
                ->latest()
                ->take(5)
                ->get();

            // Get posts for the latest posts section
            $recentPosts = Post::with(['author', 'category'])
                ->where('status', PostStatusEnum::Published)
                ->latest()
                ->take(6)
                ->get();

            // Get all categories for the sidebar
            $categories = Category::withCount('posts')->get();

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in HomeController@index: ' . $e->getMessage());
            
            // Initialize empty collections if there's an error
            $latestPosts = new Collection();
            $featuredPosts = new Collection();
            $recentPosts = new Collection();
            $categories = new Collection();
        }

        return view('front.index', compact(
            'featuredPost',
            'latestPosts',
            'featuredPosts',
            'recentPosts',
            'categories'
        ));
    }

    public function show(Post $post)
    {
        if ($post->status !== PostStatusEnum::Published) {
            abort(404);
        }

        $post->load(['author', 'category', 'comments' => function ($query) {
            $query->where('status', CommentStatusEnum::Approved->value)->latest();
        }]);

        $relatedPosts = Post::with(['author', 'category'])
            ->where('status', PostStatusEnum::Published)
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('front.posts.show', compact('post', 'relatedPosts'));
    }
}
