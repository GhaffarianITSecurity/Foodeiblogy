<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
        // Load the post with its relationships
        $post->load(['author', 'category', 'comments' => function($query) {
            $query->where('status', 'approved')->latest();
        }]);

        // Get related posts
        $relatedPosts = Post::with(['author', 'category'])
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->when($post->category_id, function($query) use ($post) {
                $query->where('category_id', $post->category_id);
            })
            ->latest()
            ->take(3)
            ->get();

        // If no related posts found in same category, get latest posts
        if ($relatedPosts->isEmpty()) {
            $relatedPosts = Post::with(['author', 'category'])
                ->where('status', 'published')
                ->where('id', '!=', $post->id)
                ->latest()
                ->take(3)
                ->get();
        }

        // Increment view count
        $post->increment('views');

        return view('front.posts.show', compact('post', 'relatedPosts'));
    }
} 