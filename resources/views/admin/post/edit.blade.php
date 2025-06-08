@use('App\Enum\PostStatusEnum')

@extends('admin.layouts.master')
@section('title', 'ویرایش پست -فودی بلاگ')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">ویرایش پست</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <form action="{{ route('admin.post.update', $post) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">ویرایش پست</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="title">عنوان</label>
                                        <input type="text" id="title" name="title"
                                            value="{{ old('title', $post->title) }}" class="form-control">
                                        @error('title')
                                            <div class="text-danger">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tags">برچست ها</label>
                                        <input type="text" id="tags" name="tags"
                                            value="{{ old('tags', $post->tags) }}" class="form-control" data-taggable>
                                        @error('tags')
                                            <div class="text-danger">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="category_id">دسته بندی</label>
                                        <select name="category_id" id="category_id" class="form-select" data-choices
                                            data-selecttext="کلیک برای انتخاب">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="text-danger">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="status">وضعیت</label>
                                        <select name="status" id="status" class="form-select">
                                            @foreach (PostStatusEnum::cases() as $status)
                                                <option value="{{ $status->value }}" @selected(old('status', $post->status->value) == $status->value)>
                                                    {{ __('app.post_status.' . $status->value) }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <div class="text-danger">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="image">تصویر</label>
                                        <input type="file" name="image" id="image" class="form-control"
                                            accept="image/jpeg,image/png">
                                        @error('image')
                                            <div class="text-danger">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                    @if (!empty($post->image))
                                        <div class="p-2">
                                            <img src="{{ Storage::url($post->image) }}" width="150" heigth="auto" />
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="content">محتوا</label>
                                        <textarea name="content" id="content" cols="5" rows="15" class="form-control">{{ old('content', $post->content) }}</textarea>
                                        @error('content')
                                            <div class="text-danger">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>مواد اولیه</label>
                                        <div id="ingredients-container">
                                            @foreach($post->ingredients as $index => $ingredient)
                                                <div class="ingredient-row mb-3">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <input type="text" name="ingredients[{{ $index }}][name]" class="form-control" placeholder="نام ماده" value="{{ $ingredient->name }}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" name="ingredients[{{ $index }}][amount]" class="form-control" placeholder="مقدار" value="{{ $ingredient->amount }}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" name="ingredients[{{ $index }}][unit]" class="form-control" placeholder="واحد" value="{{ $ingredient->unit }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" name="ingredients[{{ $index }}][notes]" class="form-control" placeholder="توضیحات" value="{{ $ingredient->notes }}">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger remove-ingredient" {{ $index === 0 && count($post->ingredients) === 1 ? 'style=display:none' : '' }}>
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if(count($post->ingredients) === 0)
                                                <div class="ingredient-row mb-3">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <input type="text" name="ingredients[0][name]" class="form-control" placeholder="نام ماده">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" name="ingredients[0][amount]" class="form-control" placeholder="مقدار">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" name="ingredients[0][unit]" class="form-control" placeholder="واحد">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" name="ingredients[0][notes]" class="form-control" placeholder="توضیحات">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger remove-ingredient" style="display: none;">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-success mt-2" onclick="addIngredient()">
                                            <i class="bi bi-plus"></i> افزودن ماده
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.post.index') }}" class="btn btn-outline-secondary"><i
                                    class="bi bi-chevron-left me-2"></i>بازگشت</a>
                            <button type="submit" class="btn btn-success"><i class="bi bi-save me-2"></i>ذخیره</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
<script>
let ingredientIndex = {{ count($post->ingredients) }};
function addIngredient() {
    var container = document.getElementById('ingredients-container');
    var template = '<div class="ingredient-row mb-3">' +
        '<div class="row">' +
        '<div class="col-md-3"><input type="text" name="ingredients[' + ingredientIndex + '][name]" class="form-control" placeholder="نام ماده"></div>' +
        '<div class="col-md-2"><input type="text" name="ingredients[' + ingredientIndex + '][amount]" class="form-control" placeholder="مقدار"></div>' +
        '<div class="col-md-2"><input type="text" name="ingredients[' + ingredientIndex + '][unit]" class="form-control" placeholder="واحد"></div>' +
        '<div class="col-md-4"><input type="text" name="ingredients[' + ingredientIndex + '][notes]" class="form-control" placeholder="توضیحات"></div>' +
        '<div class="col-md-1"><button type="button" class="btn btn-danger" onclick="removeIngredient(this)"><i class="bi bi-trash"></i></button></div>' +
        '</div>' +
        '</div>';
    container.insertAdjacentHTML('beforeend', template);
    ingredientIndex++;
}
function removeIngredient(btn) {
    var row = btn.closest('.ingredient-row');
    if(row) row.remove();
}
</script>
@endpush
