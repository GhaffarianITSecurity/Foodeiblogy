<?php

namespace App\Models;

use App\Enum\PostStatusEnum;
use Maize\Markable\Markable;
use Maize\Markable\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Maize\Markable\Models\Bookmark;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', // عنوان
        'content', // محتوا
        'user_id', // شناسه کاربر
        'category_id', // شناسه دسته‌بندی
        'tags', // برچسب‌ها
        'status', // وضعیت
        'image', // تصویر
    ];



    protected function casts()
    {
        return [
            'status' => PostStatusEnum::class
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class)->orderBy('order');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    public function getUserRatingAttribute()
    {
        if (!auth()->check()) {
            return null;
        }
        return $this->ratings()->where('user_id', auth()->id())->first();
    }

    public function getStatusTitleAttribute()
    {
        return match ($this->status->value) {
            'published' => 'منتشر شده',
            'draft' => 'پیش‌نویس',
            'pending' => 'در انتظار بررسی',
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status->value) {
            'published' => 'success',
            'draft' => 'secondary',
            'pending' => 'warning',
        };
    }

   
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = static::generateUniqueSlug($post->title);
        });

        static::updating(function ($post) {
            if ($post->isDirty('title')) {
                $post->slug = static::generateUniqueSlug($post->title, $post->id);
            }
        });
    }

    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $i = 1;
        while (static::where('slug', $slug)
            ->when($ignoreId, function ($query) use ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            })
            ->withTrashed()
            ->exists()) {
            $slug = $originalSlug . '-' . $i;
            $i++;
        }
        return $slug;
    }
}
