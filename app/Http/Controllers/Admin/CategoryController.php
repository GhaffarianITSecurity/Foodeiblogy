<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryCreateRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(3);
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.category.create', compact('categories'));
    }

    public function store(CategoryCreateRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $existing = Category::withTrashed()->where('slug', $data['slug'])->first();
        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
                $existing->update($data);
                return to_route('admin.category.index')->with('success', 'دسته بندی حذف شده بازیابی و بروزرسانی شد.');
            } else {
                return back()->withInput()->with('danger', 'این دستبندی در حال حاضر وجود دارد');
            }
        }
        Category::create($data);
        return to_route('admin.category.index')->with('success', 'دسته بندی با موفقیت ایجاد شد.');
    }

    public function show(Category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $categories = Category::get()->except($category->id);
        return view('admin.category.edit', compact('category', 'categories'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);
        return to_route('admin.category.index')->with('success', 'دسته بندی با موفقیت ویرایش شد.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'حذف دسته بندی مورد نظر انجام شد.'
        ]);
    }
}
