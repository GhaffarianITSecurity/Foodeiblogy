<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RatingController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $rating = $post->ratings()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return back()->with('success', 'Rating submitted successfully!');
    }

    public function update(Request $request, Post $post, Rating $rating)
    {
        $this->authorize('update', $rating);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $rating->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Rating updated successfully!');
    }

    public function destroy(Post $post, Rating $rating)
    {
        $this->authorize('delete', $rating);
        
        $rating->delete();

        return back()->with('success', 'Rating removed successfully!');
    }
}