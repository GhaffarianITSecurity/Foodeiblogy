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
            // مقدار دهی متغییر ها برای ساختن کالکشن
            $featuredPost = null;
            $latestPosts = new Collection();
            $featuredPosts = new Collection();
            $recentPosts = new Collection();
            $categories = new Collection();


            $featuredPost = Post::with(['category'])
                ->where('status', PostStatusEnum::Published)
                ->latest()
                ->first();


            $latestPosts = Post::with([ 'category'])
                ->where('status', PostStatusEnum::Published)
                ->latest()
                ->take(4)
                ->get();


            $featuredPosts = Post::with([ 'category'])
                ->where('status', PostStatusEnum::Published)
                ->latest()
                ->take(5)
                ->get();


            $recentPosts = Post::with(['category'])
                ->where('status', PostStatusEnum::Published)
                ->latest()
                ->take(6)
                ->get();


            $categories = Category::withCount('posts')->get();

        } catch (\Exception $e) {

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

        $post->load([ 'category', 'comments' => function ($query) {
            $query->where('status', CommentStatusEnum::Approved->value)->latest();
        }]);

        $relatedPosts = Post::with(['category'])
            ->where('status', PostStatusEnum::Published)
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('front.posts.show', compact('post', 'relatedPosts'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $posts = Post::where('title', 'like', "%{$query}%")
                     ->orWhere('content', 'like', "%{$query}%")
                     ->paginate(10);
        
        return view('front.search', [
            'posts' => $posts,
            'query' => $query
        ]);
    }
}

 

