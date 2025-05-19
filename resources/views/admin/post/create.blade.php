@use('App\Enum\PostStatusEnum')

@extends('admin.layouts.master')
@section('title', 'افزودن پست - فودی بلاگ')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">افزودن پست</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <form action="{{ route('admin.post.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">پست جدید</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="title">عنوان</label>
                                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                                            class="form-control">
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
                                        <input type="text" id="tags" name="tags" value="{{ old('tags') }}"
                                            class="form-control" data-taggable>
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
                                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
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
                                    <div class="form-group">
                                        <label for="user_id">نویسنده</label>
                                        <select name="user_id" id="user_id" class="form-select" data-choices
                                            data-selecttext="کلیک برای انتخاب">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" @selected(old('user_id', auth()->id()) == $user->id)>
                                                    {{ $user->full_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="text-danger">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="status">وضعیت</label>
                                        <select name="status" id="status" class="form-select">
                                            @foreach (PostStatusEnum::cases() as $status)
                                                <option value="{{ $status->value }}" @selected(old('status') == $status->value)>
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
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="content">محتوا</label>
                                        <textarea name="content" id="content" cols="5" rows="15" class="form-control">{{ old('content') }}</textarea>
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
                                        </div>
                                        <button type="button" class="btn btn-success mt-2" id="add-ingredient">
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
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('ingredients-container');
        const addButton = document.getElementById('add-ingredient');
        let ingredientCount = 1;

        addButton.addEventListener('click', function() {
            const template = `
                <div class="ingredient-row mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="ingredients[${ingredientCount}][name]" class="form-control" placeholder="نام ماده">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="ingredients[${ingredientCount}][amount]" class="form-control" placeholder="مقدار">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="ingredients[${ingredientCount}][unit]" class="form-control" placeholder="واحد">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="ingredients[${ingredientCount}][notes]" class="form-control" placeholder="توضیحات">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger remove-ingredient">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            ingredientCount++;

            // Show remove button for first ingredient if there's more than one
            if (ingredientCount > 1) {
                document.querySelector('.remove-ingredient').style.display = 'block';
            }
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-ingredient')) {
                e.target.closest('.ingredient-row').remove();
                ingredientCount--;

                // Hide remove button for first ingredient if it's the only one
                if (ingredientCount === 1) {
                    document.querySelector('.remove-ingredient').style.display = 'none';
                }
            }
        });
    });
</script>
@endpush
