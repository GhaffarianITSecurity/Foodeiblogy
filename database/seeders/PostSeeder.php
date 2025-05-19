<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Enum\PostStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    public function run()
    {
        DB::beginTransaction();
        try {
            // Create a default user if not exists
            $user = User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'first_name' => 'Admin',
                    'last_name' => 'User',
                    'password' => bcrypt('password'),
                    'is_admin' => 1,
                ]
            );

            if (!$user) {
                throw new \Exception('Failed to create user');
            }

            Log::info('User created/found:', ['user_id' => $user->id, 'email' => $user->email]);

            // Create food categories
            $categories = [
                'غذاهای سنتی' => 'traditional-foods',
                'دسرها' => 'desserts',
                'نوشیدنی‌ها' => 'beverages',
                'پیش غذاها' => 'appetizers',
            ];

            $createdCategories = [];
            foreach ($categories as $name => $slug) {
                $category = Category::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $name]
                );

                if (!$category) {
                    throw new \Exception("Failed to create category: {$name}");
                }

                $createdCategories[$slug] = $category;
                Log::info('Category created/found:', [
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => $slug
                ]);
            }

            // Sample Persian food posts
            $posts = [
                [
                    'title' => 'چلو خورشت قیمه - غذای ملی ایران',
                    'content' => 'چلو خورشت قیمه یکی از معروف‌ترین غذاهای ایرانی است که در تمام نقاط ایران پخته می‌شود. این غذا از برنج ایرانی، خورشت قیمه و ته‌چین تشکیل شده است. قیمه از گوشت گوسفند، پیاز، رب گوجه‌فرنگی و ادویه‌های مخصوص تهیه می‌شود.',
                    'category' => 'traditional-foods',
                    'image' => 'posts/ghormeh-sabzi.jpg',
                ],
                [
                    'title' => 'خوراک فسنجان - طعمی متفاوت از شمال ایران',
                    'content' => 'فسنجان یکی از غذاهای محلی شمال ایران است که با گردو، مرغ یا گوشت، رب انار و ادویه‌های مخصوص تهیه می‌شود. این غذا طعمی ترش و شیرین دارد و معمولاً با برنج سرو می‌شود.',
                    'category' => 'traditional-foods',
                    'image' => 'posts/fesenjan.jpg',
                ],
                [
                    'title' => 'باقالی پلو با ماهیچه - غذای مخصوص تهران',
                    'content' => 'باقالی پلو با ماهیچه یکی از غذاهای محبوب تهرانی‌هاست. این غذا از برنج، باقالی، ماهیچه گوسفند و ادویه‌های مخصوص تهیه می‌شود و معمولاً در مهمانی‌ها و مراسم خاص سرو می‌شود.',
                    'category' => 'traditional-foods',
                    'image' => 'posts/baghali-polo.jpg',
                ],
                [
                    'title' => 'شیرینی باقلوا - شیرینی سنتی ایرانی',
                    'content' => 'باقلوا یکی از شیرینی‌های سنتی ایرانی است که با خمیر فیلو، مغز پسته، شکر و گلاب تهیه می‌شود. این شیرینی در مناسبت‌های خاص مانند عید نوروز و مراسم عروسی سرو می‌شود.',
                    'category' => 'desserts',
                    'image' => 'posts/baklava.jpg',
                ],
                [
                    'title' => 'آبگوشت - غذای سنتی و مقوی',
                    'content' => 'آبگوشت یکی از غذاهای سنتی و مقوی ایرانی است که از گوشت گوسفند، نخود، لوبیا، پیاز و ادویه‌های مخصوص تهیه می‌شود. این غذا معمولاً در فصل زمستان پخته می‌شود.',
                    'category' => 'traditional-foods',
                    'image' => 'posts/abgoosht.jpg',
                ],
                [
                    'title' => 'شربت بیدمشک - نوشیدنی سنتی ایرانی',
                    'content' => 'شربت بیدمشک یکی از نوشیدنی‌های سنتی ایرانی است که از عرق بیدمشک، شکر و آب تهیه می‌شود. این نوشیدنی خنک کننده و آرامش بخش است.',
                    'category' => 'beverages',
                    'image' => 'posts/bidmeshk.jpg',
                ],
            ];

            foreach ($posts as $post) {
                if (!isset($createdCategories[$post['category']])) {
                    Log::error('Category not found:', ['slug' => $post['category']]);
                    continue;
                }

                try {
                    $createdPost = Post::create([
                        'title' => $post['title'],
                        'content' => $post['content'],
                        'user_id' => $user->id,
                        'category_id' => $createdCategories[$post['category']]->id,
                        'status' => PostStatusEnum::Published,
                        'image' => $post['image'],
                        'created_at' => now()->subDays(rand(1, 30)),
                    ]);

                    if (!$createdPost) {
                        throw new \Exception("Failed to create post: {$post['title']}");
                    }

                    Log::info('Post created:', [
                        'post_id' => $createdPost->id,
                        'title' => $post['title'],
                        'category_id' => $createdCategories[$post['category']]->id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to create post:', [
                        'title' => $post['title'],
                        'error' => $e->getMessage()
                    ]);
                    throw $e;
                }
            }

            DB::commit();
            Log::info('Seeder completed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Seeder failed:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
} 