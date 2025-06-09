<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UploadService\UploadService;
use App\Http\Requests\Admin\PostCreateRequest;
use App\Http\Requests\Admin\PostUpdateRequest;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::when($request->filled('search'), function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->search . '%');
        })->orderByDesc('created_at')->paginate();
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        return view('admin.post.create', compact('categories', 'users'));
    }

    public function store(PostCreateRequest $request, UploadService $uploadService)
    {
        $inputs = $request->validated();
        $inputs['user_id'] = auth()->id();
        $inputs['slug'] = Str::slug($inputs['title']);

        $existing = Post::withTrashed()->where('title', $inputs['title'])->first();
        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
                $existing->update($inputs);
                $post = $existing;
            } else {
                return to_route('admin.post.create')->with('danger', 'پستی با این عنوان قبلاً وجود دارد.');
            }
        } else {
            $post = Post::create($inputs);
        }

        if ($request->hasFile('image')) {
            $result = $uploadService->folder('posts')->upload($request->file('image'));
            if (!$result) {
                return to_route('admin.post.create')->with('warning', 'مکشلی در آپلود تصویر پیش آمده است');
            }
            $post->update(['image' => $result]);
        }

        if ($request->has('ingredients')) {
            foreach ($request->ingredients as $index => $ingredient) {
                if (!empty($ingredient['name'])) {
                    $post->ingredients()->create([
                        'name' => $ingredient['name'],
                        'amount' => $ingredient['amount'],
                        'unit' => $ingredient['unit'],
                        'notes' => $ingredient['notes'],
                        'order' => $index
                    ]);
                }
            }
        }
        return to_route('admin.post.index')->with('success', 'پست جدید با موفقیت ایجاد شد');
    }

    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $users = User::all();
        return view('admin.post.edit', compact('categories', 'users', 'post'));
    }

    public function update(PostUpdateRequest $request, Post $post, UploadService $uploadService)
    {
        $inputs = $request->validated();

        if ($request->hasFile('image')) {
            if (!empty($post->image)) {
                $uploadService->delete($post->image);
            }

            $result = $uploadService->folder('posts')->upload($request->file('image'));

            if (!$result) {
                return to_route('admin.post.create')->with('warning', 'مکشلی در آپلود تصویر پیش آمده است');
            }

            $inputs['image'] = $result;
        }

        $post->update($inputs);


        $post->ingredients()->delete(); 
        if ($request->has('ingredients')) {
            foreach ($request->ingredients as $index => $ingredient) {
                if (!empty($ingredient['name'])) {
                    $post->ingredients()->create([
                        'name' => $ingredient['name'],
                        'amount' => $ingredient['amount'],
                        'unit' => $ingredient['unit'],
                        'notes' => $ingredient['notes'],
                        'order' => $index
                    ]);
                }
            }
        }

        return to_route('admin.post.index')->with('success', 'پست با موفقیت ویرایش شد');
    }

    public function destroy(Post $post)
    {
        foreach ($post->comments as $comment) {
            $comment->delete();
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'حذف پست مورد نظر  همراه با نظرات آن انجام شد.'
        ]);
    }

    public function status(Request $request, Post $post)
    {
        $post->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'color' => $post->status_color,
            'title' => $post->status_title,
            'message' => 'تغییر وضعیت پست انجام شد.'
        ]);
    }
}
