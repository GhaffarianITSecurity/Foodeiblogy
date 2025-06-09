<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only add the column if it doesn't exist
        if (!Schema::hasColumn('posts', 'slug')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('title');
            });
        }

        // Populate slug for existing posts and ensure uniqueness
        $existingSlugs = [];
        \DB::table('posts')->orderBy('id')->get()->each(function ($post) use (&$existingSlugs) {
            $baseSlug = \Illuminate\Support\Str::slug($post->title ?: uniqid('post_'));
            $slug = $baseSlug;
            $i = 1;
            while (in_array($slug, $existingSlugs) || \DB::table('posts')->where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $baseSlug . '-' . $i;
                $i++;
            }
            $existingSlugs[] = $slug;
            \DB::table('posts')->where('id', $post->id)->update(['slug' => $slug]);
        });

        // Add unique constraint and make not nullable
        Schema::table('posts', function (Blueprint $table) {
            $table->unique('slug');
            $table->string('slug')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};