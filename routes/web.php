<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::view('/author-profile', 'front.about-author')->name('author');
Route::view('/about', 'front.about')->name('about');
Route::get('/posts/{post}', [HomeController::class, 'show'])->name('posts.show');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('posts.category');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');


Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::put('/posts/{post}/ratings/{rating}', [RatingController::class, 'update'])->name('ratings.update');
    Route::delete('/posts/{post}/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin.check'])->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name('dashboard');

    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/show/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/destroy/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('post')->name('post.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/show/{post}', [PostController::class, 'show'])->name('show');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/edit/{post}', [PostController::class, 'edit'])->name('edit');
        Route::put('/update/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/destroy/{post}', [PostController::class, 'destroy'])->name('destroy');
        Route::post('/status/{post}', [PostController::class, 'status'])->name('status');
    });

    Route::prefix('comment')->name('comment.')->group(function () {
        Route::get('/', [AdminCommentController::class, 'index'])->name('index');
        Route::get('/show/{comment}', [AdminCommentController::class, 'show'])->name('show');
        Route::post('/answer/{comment}', [AdminCommentController::class, 'answer'])->name('answer');
        Route::delete('/destroy/{comment}', [AdminCommentController::class, 'destroy'])->name('destroy');
        Route::post('/status/{comment}', [AdminCommentController::class, 'status'])->name('status');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/show/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/destroy/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';