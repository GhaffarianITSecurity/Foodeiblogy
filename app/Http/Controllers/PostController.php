<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
       
        $post->load([ 'category', 'comments' => function($query) {
            $query->where('status', 'approved')->latest();
        }]);


        $relatedPosts = Post::with(['category'])
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->when($post->category_id, function($query) use ($post) {
                $query->where('category_id', $post->category_id);
            })
            ->latest()
            ->take(3)
            ->get();


        if ($relatedPosts->isEmpty()) {
            $relatedPosts = Post::with([ 'category'])
                ->where('status', 'published')
                ->where('id', '!=', $post->id)
                ->latest()
                ->take(3)
                ->get();
        }

        
        $post->increment('views');

        return view('front.posts.show', compact('post', 'relatedPosts'));
    }
} 